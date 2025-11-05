# PHP 8.2 + Composer
FROM php:8.2-cli

# Dependências de sistema e headers para extensões
RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev zlib1g-dev \
    libonig-dev libxml2-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# App
WORKDIR /app
COPY . .

# Instalar dependências do Laravel
# (se der problema de plataforma, podemos trocar por --ignore-platform-reqs)
RUN composer install --no-dev --optimize-autoloader

# Preparar caches (não falhar se .env ainda não existir)
RUN php artisan key:generate --force || true
RUN php artisan config:cache || true
RUN php artisan route:cache  || true
RUN php artisan view:cache   || true

EXPOSE 8000

# Sobe migrations e inicia o servidor
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT}

