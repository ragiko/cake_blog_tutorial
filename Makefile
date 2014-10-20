PHP=$(shell which php)
CURL=$(shell which curl)

setup:
	chmod 777 tmp 
	chmod 777 webroot 
	$(PHP) -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"
	$(CURL) -SslO https://raw.githubusercontent.com/brtriver/dbup/master/dbup.phar
install: setup
	$(PHP) composer.phar install

copy-db-config:
	mkdir .dbup/applied
	cp .dbup/properties.ini.template .dbup/properties.ini
	cp Config/database.php.default Config/database.php
mig-up:
	$(PHP) dbup.phar up

update:
	$(PHP) composer.phar update

