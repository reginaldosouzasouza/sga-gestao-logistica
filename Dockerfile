# PHP 8.2 + Composer
FROM php:8.2-cli

# Dependências de sistema e headers para extensões + ca-certificates para SSL
RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev zlib1g-dev \
    libonig-dev libxml2-dev \
    ca-certificates \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# App
WORKDIR /app
COPY . .

# Instalar dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Limpar caches antes de gerar novos (não falhar se .env ainda não existir)
RUN php artisan config:clear || true
RUN php artisan cache:clear || true

# Preparar caches
RUN php artisan key:generate --force || true
RUN php artisan config:cache || true
RUN php artisan route:cache  || true
RUN php artisan view:cache   || true

EXPOSE 8000

# Limpar config cache, aplicar migrations e iniciar o servidor
CMD php artisan config:clear && \
    php artisan config:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}

