# WilIndo

[![License](https://poser.pugx.org/didiwijaya/wilindo/license)](https://packagist.org/packages/wilindo/license) [![Total Downloads](https://poser.pugx.org/didiwijaya/wilindo/downloads)](https://packagist.org/packages/didiwijaya/wilindo)

Package Laravel untuk menambahkan migration dan seeder ke project Anda, dimana migration dan seeder tersebut digunakan untuk menyimpan data wilayah Indonesia mulai dari Provinsi, Kabupaten/Kota, Kecamatan dan Desa/Kelurahan.

Sumber data : Layanan SPLP (https://splp.layanan.go.id) portal Kementerian Dalam Negeri.

## 📋 Fitur

- ✅ Migration untuk 4 tabel wilayah (Provinsi, Kabupaten/Kota, Kecamatan, Desa/Kelurahan)
- ✅ Seeder otomatis dari API SPLP Kemendagri
- ✅ Model Eloquent dengan relationship yang lengkap
- ✅ Helper class untuk query data yang mudah
- ✅ Error handling dan progress tracking
- ✅ Chunking data untuk performa optimal
- ✅ Index database untuk query yang cepat
- ✅ Configurable table prefix

## 🚀 Instalasi

### Via Composer

```bash
composer require didiwijaya/wilindo
```

### Publish Assets

```bash
php artisan wilindo:publish
```

### Jalankan Migration

```bash
php artisan migrate
```

### Jalankan Seeder

```bash
php artisan db:seed --class=WilindoSeeder
```

## 📖 Penggunaan

### Menggunakan Model

```php
use DidiWijaya\WilIndo\Models\Province;
use DidiWijaya\WilIndo\Models\City;
use DidiWijaya\WilIndo\Models\District;
use DidiWijaya\WilIndo\Models\Village;

// Ambil semua provinsi
$provinces = Province::all();

// Ambil kota berdasarkan provinsi
$cities = City::byProvince('32')->get();

// Ambil kecamatan berdasarkan kota
$districts = District::byCity('3201')->get();

// Ambil desa berdasarkan kecamatan
$villages = Village::byDistrict('3201010')->get();

// Ambil data lengkap dengan relationship
$village = Village::with(['district.city.province'])->find(1);
```

### Menggunakan Helper

```php
use DidiWijaya\WilIndo\Helpers\WilindoHelper;

// Ambil semua provinsi
$provinces = WilindoHelper::getProvinces();

// Ambil kota berdasarkan provinsi
$cities = WilindoHelper::getCitiesByProvince('32');

// Ambil alamat lengkap berdasarkan kode desa
$address = WilindoHelper::getCompleteAddress('3201010001');

// Cari provinsi berdasarkan nama
$provinces = WilindoHelper::searchProvinces('Jawa');

// Ambil statistik data
$stats = WilindoHelper::getStatistics();
```

## ⚙️ Konfigurasi

File konfigurasi tersimpan di `config/wilindo.php`:

```php
return [
    'prefix' => 'wilindo_', // Prefix untuk nama tabel
];
```

## 📊 Struktur Database

### Tabel Provinsi
- `id` - Primary key
- `code` - Kode provinsi (2 digit)
- `name` - Nama provinsi
- `created_at`, `updated_at` - Timestamps

### Tabel Kabupaten/Kota
- `id` - Primary key
- `code` - Kode kabupaten/kota (4 digit)
- `province_code` - Foreign key ke tabel provinsi
- `name` - Nama kabupaten/kota
- `created_at`, `updated_at` - Timestamps

### Tabel Kecamatan
- `id` - Primary key
- `code` - Kode kecamatan (7 digit)
- `city_code` - Foreign key ke tabel kabupaten/kota
- `name` - Nama kecamatan
- `created_at`, `updated_at` - Timestamps

### Tabel Desa/Kelurahan
- `id` - Primary key
- `code` - Kode desa/kelurahan (10 digit)
- `district_code` - Foreign key ke tabel kecamatan
- `name` - Nama desa/kelurahan
- `created_at`, `updated_at` - Timestamps

## 🔧 Command

### Publish Assets
```bash
php artisan wilindo:publish
```

### Publish Config Only
```bash
php artisan vendor:publish --tag=wilindo-config
```

### Publish Migrations Only
```bash
php artisan vendor:publish --tag=wilindo-migrations
```

### Publish Seeders Only
```bash
php artisan vendor:publish --tag=wilindo-seeders
```

## 📊 Data Kemendagri dari Layanan SPLP

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
| **Total**     | **38**                     | **514**  | **7277**  | **83763** |

## 📝 Catatan

- Data diambil dari API SPLP Kemendagri secara real-time
- Proses seeding mungkin memakan waktu lama karena data yang besar
- Pastikan koneksi internet stabil saat menjalankan seeder
- Memory limit akan otomatis ditingkatkan untuk seeder desa/kelurahan

## 🤝 Kontribusi

Silakan buat issue atau pull request untuk perbaikan dan fitur baru.

## 📄 Lisensi

MIT License