FROM php:8.2-cli-bookworm

RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip zip ca-certificates pkg-config \
    libzip-dev libicu-dev zlib1g-dev libxml2-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libpq-dev \
  && docker-php-ext-configure intl \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j"$(nproc)" \
       intl zip pcntl sockets bcmath exif gd pdo pdo_mysql pdo_pgsql \
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /app

CMD ["php", "-v"]
