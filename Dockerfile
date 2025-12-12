FROM php:8.1-cli

# Instalar extensiones PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_pgsql
# Directorio de trabajo
WORKDIR /app

# Copiar aplicación
COPY . .

# Exponer puerto
EXPOSE 8080
