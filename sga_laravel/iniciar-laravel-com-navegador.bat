
@echo off
echo ===========================
echo CORRIGINDO O CACHE DO LARAVEL
echo ===========================

:: Cria as pastas se não existirem
mkdir storage\framework\views
mkdir storage\framework\cache
mkdir storage\logs

:: Limpa todos os caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

:: Abre o navegador no endereço local
start http://127.0.0.1:8001

:: Inicia o servidor Laravel na porta 8001
echo ===========================
echo INICIANDO O SERVIDOR
echo ===========================
php artisan serve --host=127.0.0.1 --port=8001

pause
