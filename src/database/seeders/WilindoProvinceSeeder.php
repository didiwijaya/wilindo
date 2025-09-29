<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WilindoProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $this->command->info('Mengambil data provinsi dari API SPLP...');
            
            $response = Http::timeout(30)->get('https://api-splp.layanan.go.id/master_data_wilayah_provinsi/2.0');
            
            if (!$response->successful()) {
                throw new \Exception('Gagal mengambil data dari API SPLP. Status: ' . $response->status());
            }
            
            $records = $response->object();
            
            if (!isset($records->data) || !is_array($records->data)) {
                throw new \Exception('Format data API tidak valid');
            }

            $provinces = [];
            foreach ($records->data as $dt) {
                if (!isset($dt->kode_provinsi) || !isset($dt->nama_provinsi)) {
                    continue;
                }
                
                $name = $dt->nama_provinsi == 'DKI JAKARTA' ? 'DKI Jakarta' : Str::title(Str::lower($dt->nama_provinsi));
                $provinces[] = [
                    'code' => $dt->kode_provinsi, 
                    'name' => $name,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            if (empty($provinces)) {
                throw new \Exception('Tidak ada data provinsi yang ditemukan');
            }

            DB::table(config('wilindo.prefix') . 'provinces')->truncate();
            DB::table(config('wilindo.prefix') . 'provinces')->insert($provinces);
            
            $this->command->info('Berhasil menyimpan ' . count($provinces) . ' data provinsi');
            
        } catch (\Exception $e) {
            $this->command->error('Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
