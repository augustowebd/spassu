up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose build

install: down build up setup

setup:
	# Copia .env se não existir
	docker compose exec app cp -n .env.example .env || true

	# Instala dependências PHP
	docker compose exec app composer install --no-interaction --optimize-autoloader

	# Gera chave do app
	docker compose exec app php artisan key:generate

	# Roda migrations e seeds
	docker compose exec app php artisan migrate:reset
	docker compose exec app php artisan migrate --seed --force

	# Instala dependências Node
	docker compose exec app npm ci --prefix /var/www/html

	# Build do Vite para produção
	docker compose exec app npm run build --prefix /var/www/html

	# Ajusta permissões
	docker compose exec app chown -R www-data:www-data storage bootstrap/cache public/build
	docker compose exec app chmod -R 775 storage bootstrap/cache public/build

logs:
	docker compose logs -f

restart: down up

artisan:
	docker compose exec app php artisan $(CMD)

tinker:
	docker compose exec app php artisan tinker

test:
	docker compose exec app php artisan test

migrate:
	docker compose exec app php artisan migrate --force
