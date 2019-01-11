run:
	docker run -i -t -v ${PWD}:/app -w /app composer install
	docker-compose up -d
	sleep 20  # on attend le démarrage de MySQL
	make reset

reset:
	docker-compose exec app bin/console doctrine:database:create --if-not-exists
	docker-compose exec app bin/console doctrine:schema:drop --force
	docker-compose exec app bin/console doctrine:schema:update --force
	docker-compose exec app bin/console hautelook:fixtures:load --no-interaction
	docker-compose exec app bin/console user:make-friends

db:
	docker-compose exec database mysql -uroot -proot iutagram

test: reset
	docker-compose exec app ./vendor/bin/phpunit
