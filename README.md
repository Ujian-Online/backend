- [Ujian Online Backend](#ujian-online-backend)
  - [Install](#install)
  - [PDF Export Library](#pdf-export-library)
    - [Ubuntu 20.04](#ubuntu-2004)

# Ujian Online Backend

## Install

```
git clone git@github.com:Ujian-Online/backend.git
composer install
php artisan migrate --seed
```
- Setelah melakukan seeder, detail login akan di print pada terminal atau bisa cek dari file: **.password**

## PDF Export Library

- Download Binnary: [https://wkhtmltopdf.org/downloads.html](https://wkhtmltopdf.org/downloads.html)

### Ubuntu 20.04

```
wget https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6-1/wkhtmltox_0.12.6-1.focal_amd64.deb
dpkg -i wkhtmltox_0.12.6-1.focal_amd64.deb
apt install -f
```