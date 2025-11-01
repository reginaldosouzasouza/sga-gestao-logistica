# Imagem base com PHP 8.2 + Composer
FROM php:8.2-cli

# Instalar extensões necessárias
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev zip curl && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /app

# Copiar o projeto para o container
COPY . .

# Instalar dependências Laravel
RUN composer install --no-dev --optimize-autoloader

# Gerar cache de configuração
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Expor a porta padrão
EXPOSE 8000

# Comando de inicialização
CMD php artisan serve --host=0.0.0.0 --port=$PORT
