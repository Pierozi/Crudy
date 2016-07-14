<?php

function isBehat()
{
    return !empty($_SERVER['HTTP_X_BEHAT']);
}

function isCI()
{
    $path = __DIR__ . DIRECTORY_SEPARATOR . '.ci';

    return (
        file_exists($path)
        && str_replace(["\n","\r","\t"], '', file_get_contents($path)) === 'continuousphp'
    );
}

function ver()
{
    $ver  = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '.version');

    list($major, $minor, $patch) = explode('.', $ver);

    $major = (int)$major;
    $minor = (int)$minor;
    $patch = (int)$patch;

    if (!($major >= 0) || !($minor >= 0) || !($patch >= 0)) {
        throw new \Exception('Version of application are not correctly configured');
    }

    return (object)[
        'version' => "$major.$minor.$patch",
        'major' => $major,
        'minor' => $minor,
        'patch' => $patch,
    ];
}