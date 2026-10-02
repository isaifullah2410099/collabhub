FROM mcr.microsoft.com/devcontainers/php:8.4-bookworm

# mysqli is needed because the class project uses new mysqli() in PHP.
RUN docker-php-ext-install mysqli

# MariaDB client is used for database checks.
# Git LFS is included so git push works in a new Codespace.
RUN apt-get update \
    && apt-get install -y mariadb-client git-lfs \
    && rm -rf /var/lib/apt/lists/*
