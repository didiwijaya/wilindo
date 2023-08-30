# didiwijaya/wilindo
[![License](https://poser.pugx.org/didiwijaya/wilindo/license)](https://packagist.org/packages/wilindo/license) [![Total Downloads](https://poser.pugx.org/didiwijaya/wilindo/downloads)](https://packagist.org/packages/didiwijaya/wilindo)

Package Laravel untuk menambahkan migration dan seeder ke project Anda, dimana migration dan seeder tersebut digunakan untuk menyimpan data wilayah Indonesia mulai dari Provinsi, Kabupaten/Kota, Kecamatan dan Desa/Kelurahan.

Sumber data : Layanan SPLP (https://splp.layanan.go.id) portal Kementerian Dalam Negeri.

## Instalasi

### Install Package Via Composer

```
composer require didiwijaya/wilindo
```

### Mempublikasikan File

```
php artisan wilindo:publish
``` 

Setelah perintah diatas dijalankan, maka wilindo akan menyalin:

* File `config/wilindo.php` dari ```/packages/didiwijaya/wilindo/src/config``` ke ```/config```
* Semua file migrations dari ```/packages/didiwijaya/wilindo/src/database/migrations``` ke ```/database/migrations```
* Semua file seeders dari ```/packages/didiwijaya/wilindo/src/database/seeders``` ke ```/database/seeders```

### Konfigurasi Prefix Tabel
Untuk mengatur prefix tabel, buka file `config/wilindo.php`, lalu ubah kode berikut (ubah `wilindo_` dengan prefix tabel yang diinginkan),
```php
<?php

return [
    'prefix' => 'wilindo_',
];
```

### Migration dan Seeder
Jalankan perintah dibawah untuk menjalankan migration dan seeder:

```
php artisan migrate

# Impor semua data (Provinsi, Kab/Kota, Kecamatan, Kel/Desa)
php artisan db:seed --class=WilIndoSeeder

# Atau impor data satu per satu
php artisan db:seed --class=WilIndoProvinceSeeder
php artisan db:seed --class=WilIndoCitySeeder
php artisan db:seed --class=WilIndoDistrictSeeder
php artisan db:seed --class=WilIndoVillageSeeder
```