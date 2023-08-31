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

## Data Kemendagri dari Layanan SPLP
| Kode Provinsi | Nama Provinsi              | Kab/Kota | Kecamatan | Kel/Desa |
| ------------- | -------------------------- | -------- | --------- | -------- |
| 11            | Aceh                       | 23       | 290       | 6500     |
| 12            | Sumatera Utara             | 33       | 455       | 6110     |
| 13            | Sumatera Barat             | 19       | 179       | 1265     |
| 14            | Riau                       | 12       | 172       | 1862     |
| 15            | Jambi                      | 11       | 144       | 1585     |
| 16            | Sumatera Selatan           | 17       | 241       | 3258     |
| 17            | Bengkulu                   | 10       | 129       | 1513     |
| 18            | Lampung                    | 15       | 229       | 2651     |
| 19            | Kepulauan Bangka Belitung  | 7        | 47        | 393      |
| 21            | Kepulauan Riau             | 7        | 80        | 419      |
| 31            | DKI Jakarta                | 6        | 44        | 267      |
| 32            | Jawa Barat                 | 27       | 627       | 5957     |
| 33            | Jawa Tengah                | 35       | 576       | 8563     |
| 34            | Daerah Istimewa Yogyakarta | 5        | 78        | 438      |
| 35            | Jawa Timur                 | 38       | 666       | 8494     |
| 36            | Banten                     | 8        | 155       | 1552     |
| 51            | Bali                       | 9        | 57        | 716      |
| 52            | Nusa Tenggara Barat        | 10       | 117       | 1166     |
| 53            | Nusa Tenggara Timur        | 22       | 315       | 3442     |
| 61            | Kalimantan Barat           | 14       | 174       | 2145     |
| 62            | Kalimantan Tengah          | 14       | 136       | 1571     |
| 63            | Kalimantan Selatan         | 13       | 156       | 2016     |
| 64            | Kalimantan Timur           | 10       | 105       | 1038     |
| 65            | Kalimantan Utara           | 5        | 55        | 482      |
| 71            | Sulawesi Utara             | 15       | 171       | 1839     |
| 72            | Sulawesi Tengah            | 13       | 175       | 2017     |
| 73            | Sulawesi Selatan           | 24       | 313       | 3059     |
| 74            | Sulawesi Tenggara          | 17       | 221       | 2287     |
| 75            | Gorontalo                  | 6        | 77        | 729      |
| 76            | Sulawesi Barat             | 6        | 69        | 648      |
| 81            | Maluku                     | 11       | 118       | 1235     |
| 82            | Maluku Utara               | 10       | 118       | 1185     |
| 91            | P A P U A                  | 9        | 105       | 999      |
| 92            | Papua Barat                | 7        | 86        | 824      |
| 93            | Papua Selatan              | 4        | 82        | 690      |
| 94            | Papua Tengah               | 8        | 131       | 1208     |
| 95            | Papua Pegunungan           | 8        | 252       | 2627     |
| 96            | Papua Barat Daya           | 6        | 132       | 1013     |
| Total         | 38                         | 514      | 7277      | 83763    |
