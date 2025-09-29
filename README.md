# WilIndo

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

## 📝 Catatan

- Data diambil dari API SPLP Kemendagri secara real-time
- Proses seeding mungkin memakan waktu lama karena data yang besar
- Pastikan koneksi internet stabil saat menjalankan seeder
- Memory limit akan otomatis ditingkatkan untuk seeder desa/kelurahan

## 🤝 Kontribusi

Silakan buat issue atau pull request untuk perbaikan dan fitur baru.

## 📄 Lisensi

MIT License