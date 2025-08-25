<?php

// 1) Copia .env se não existir
if (!file_exists('.env')) {
    copy('.env.example', '.env');
}

// 2) Ajusta o caminho do banco SQLite
$envPath = realpath('.env');
$envContents = file_get_contents($envPath);
$sqlitePath = realpath('.') . '/database/database.sqlite';
$envContents = preg_replace('/DB_DATABASE=.*/', 'DB_DATABASE=' . $sqlitePath, $envContents);
file_put_contents($envPath, $envContents);

// 3) Gera APP_KEY
passthru('php artisan key:generate --ansi');

// 4) Cria arquivo SQLite se não existir
if (!file_exists('database/database.sqlite')) {
    touch('database/database.sqlite');
}

// 5) Roda migrations e seed
passthru('php artisan migrate --graceful --seed --ansi');

echo "\nSetup completo!\n";
