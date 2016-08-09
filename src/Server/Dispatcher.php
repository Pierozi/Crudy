<?php

namespace Crudy\Server;

use Hoa\Consistency;
use Hoa\Router;
use Hoa\View;

class Dispatcher extends \Hoa\Dispatcher\Dispatcher
{
    /**
     * Route namespace where search API resources.
     *
     * @var string
     */
    protected $rootNs;

    public function setRouteNamespace(string $ns)
    {
        $this->rootNs = $ns;
    }

    /**
     * Resolve the dispatch call.
     *
     * @param array              $rule   Rule.
     * @param \Hoa\Router        $router Router.
     * @param \Hoa\View\Viewable $view   View.
     *
     * @return mixed
     *
     * @throws \Hoa\Dispatcher\Exception
     */
    protected function resolve(
        array $rule,
        Router $router,
        View\Viewable $view = null
    ) {
        $ruleId = &$rule[Router\Router::RULE_ID];
        $variables = &$rule[Router\Router::RULE_VARIABLES];

        $called = null;
        $variables = &$rule[Router::RULE_VARIABLES];
        $call = isset($variables['_call'])
            ? $variables['_call']
            : $rule[Router::RULE_CALL];
        $able = isset($variables['_able'])
            ? $variables['_able']
            : $rule[Router::RULE_ABLE];
        $rtv = [$router, $this, $view];
        $arguments = [];
        $reflection = null;
        $async = $router->isAsynchronous();
        $class = $call;
        $method = $able;

        if (false === $async) {
            $_class = 'synchronous.call';
            $_method = 'synchronous.able';
        } else {
            $_class = 'asynchronous.call';
            $_method = 'asynchronous.able';
        }

        if ('cmd' === substr($ruleId, 0, 3)) {
            $_class = 'command.call';
        }

        if (false !== strpos($variables['resourcename'], '-')) {
            $variables['resourcename'] = implode('\\', \nspl\a\map(
                'ucfirst',
                explode('-', $variables['resourcename'])
            ));

            $this->_parameters->setParameter('variables.resourcename', $variables['resourcename']);
        }

        $this->_parameters->setKeyword('call', $class);
        $this->_parameters->setKeyword('able', $method);

        $class = $this->_parameters->getFormattedParameter($_class);
        $method = $this->_parameters->getFormattedParameter($_method);

        try {
            $class = Consistency\Autoloader::dnew($class, $rtv);
        } catch (\Exception $e) {
            throw new \Hoa\Dispatcher\Exception(
                'Class %s is not found '.
                '(method: %s, asynchronous: %s).',
                0,
                [
                    $class,
                    strtoupper($variables['_method']),
                    true === $async
                        ? 'true'
                        : 'false',
                ],
                $e
            );
        }

        if (!method_exists($class, $method)) {
            throw new Exception(
                'Method %s does not exist on the class %s '.
                '(method: %s, asynchronous: %s).',
                1,
                [
                    $method,
                    get_class($class),
                    strtoupper($variables['_method']),
                    true === $async
                        ? 'true'
                        : 'false',
                ]
            );
        }

        $called = $class;
        $reflection = new \ReflectionMethod($class, $method);

        foreach ($reflection->getParameters() as $parameter) {
            $name = strtolower($parameter->getName());
            if (true === array_key_exists($name, $variables)) {
                $arguments[$name] = $variables[$name];
                continue;
            }
            if (false === $parameter->isOptional()) {
                throw new Exception(
                    'The method %s on the class %s needs a value for '.
                    'the parameter $%s and this value does not exist.',
                    2,
                    [$method, get_class($class), $name]
                );
            }
        }

        return $reflection->invokeArgs($called, $arguments);
    }
}
