SHELL := /bin/bash

GREEN   := "\\033[1;32m"
NORMAL  := "\\033[0;39m"
RED     := "\\033[1;31m"
PINK    := "\\033[1;35m"
BLUE    := "\\033[1;34m"
WHITE   := "\\033[0;02m"
YELLOW  := "\\033[1;33m"
CYAN    := "\\033[1;36m"

USER = $(shell whoami)
GROUP = $(shell groups $(whoami) | cut -d' ' -f1)
CID=crudy_php_1

e?=testing

connect:
	docker exec -it ${CID} bash

acl:
	@echo -e $(YELLOW)"Docker run in root, we need fix ACL, please enter your password if asking"$(NORMAL); \
	sudo chown -R $(USER):$(GROUP) ./

devpath?=dev:8010

replace-var-config:
	grep -rl '§devPath§' config | xargs sed -i 's/§devPath§/$(devpath)/g'
	cp config/api.suite.yml tests/api.suite.yml

log-error:
	tail -f -n 0 log/error.log

tu:
	./vendor/bin/codecept run -d
