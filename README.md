![Deploy Staging Branch](https://github.com/Ujian-Online/backend/workflows/Deploy%20Staging%20Branch/badge.svg)

- [Ujian Online Backend](#ujian-online-backend)
  - [Install](#install)
    - [Install MySQL 5.7](#install-mysql-57)
    - [Install Redis Server](#install-redis-server)
    - [Install PHP 7.4](#install-php-74)
    - [Install Composer](#install-composer)
    - [Install Other Dependency](#install-other-dependency)
  - [PDF Export Library](#pdf-export-library)
    - [Ubuntu 20.04](#ubuntu-2004)
  - [Fixed Permission](#fixed-permission)
    - [Folder Permission](#folder-permission)
    - [Fixed Owner Permission](#fixed-owner-permission)
      - [Nginx](#nginx)
      - [Apache](#apache)

# Ujian Online Backend

## Install

### Install MySQL 5.7

- [Source](https://www.fosstechnix.com/how-to-install-mysql-5-7-on-ubuntu-20-04-lts/)

### Install Redis Server

```bash
apt install redis-server
systemctl enable redis-server
```

- Edit Config Redis

```bash
cat > /etc/redis/redis.conf <<CONFIGURATION
maxmemory 256mb
maxmemory-policy allkeys-lru
requirepass pass1234
CONFIGURATION
```

- Restart Redis

```bash
systemctl restart redis-server
```

- **pass1234**: Password untuk Redis, Ganti Agar Aman :)

### Install PHP 7.4

```bash
apt-get install php7.4-{mysqlnd,mbstring,curl,zip,xml,fpm,redis,gd} -y
```

### Install Composer

```bash
wget https://getcomposer.org/installer
php installer --install-dir=/usr/bin --filename=composer
```

### Install Other Dependency

```bash
apt install nginx nano wget git -y
```

```
git clone git@github.com:Ujian-Online/backend.git
composer install
php artisan migrate --seed
```
- Setelah melakukan seeder, detail login akan di print pada terminal atau bisa cek dari file: **.password**

## PDF Export Library

- Download Binnary: [https://wkhtmltopdf.org/downloads.html](https://wkhtmltopdf.org/downloads.html)

### Ubuntu 20.04

```bash
wget https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6-1/wkhtmltox_0.12.6-1.focal_amd64.deb
dpkg -i wkhtmltox_0.12.6-1.focal_amd64.deb
apt install -f
```

## Fixed Permission

### Folder Permission

```bash
find ${pwd} -type d -print0 | xargs -0 chmod 0775;
find ${pwd} -type f -print0 | xargs -0 chmod 0664;
```

### Fixed Owner Permission

#### Nginx

```bash
chown -R www-data:www-data *
```

#### Apache

```bash
chown -R apache:apache *
```
