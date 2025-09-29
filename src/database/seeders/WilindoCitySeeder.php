<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WilindoCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $this->command->info('Mengambil data kabupaten/kota dari API SPLP...');
            
            $response = Http::timeout(60)->get('https://api-splp.layanan.go.id/master_data_kabkota/2.0');
            
            if (!$response->successful()) {
                throw new \Exception('Gagal mengambil data dari API SPLP. Status: ' . $response->status());
            }
            
            $records = $response->object();
            
            if (!isset($records->data) || !is_array($records->data)) {
                throw new \Exception('Format data API tidak valid');
            }

            $cities = [];
            foreach ($records->data as $dt) {
                if (!isset($dt->kode_kabkota) || !isset($dt->kode_provinsi) || !isset($dt->nama_kabkota)) {
                    continue;
                }
                
                $cities[] = [
                    'code' => str_replace('.', '', $dt->kode_kabkota), 
                    'province_code' => $dt->kode_provinsi, 
                    'name' => Str::title(Str::lower($dt->nama_kabkota)),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            if (empty($cities)) {
                throw new \Exception('Tidak ada data kabupaten/kota yang ditemukan');
            }

            DB::table(config('wilindo.prefix') . 'cities')->truncate();

            $cities = collect($cities);
            $chunks = $cities->chunk(100);
            $totalInserted = 0;
            
            foreach ($chunks as $chunk) {
                DB::table(config('wilindo.prefix') . 'cities')->insert($chunk->toArray());
                $totalInserted += $chunk->count();
                $this->command->info("Memproses {$totalInserted} dari " . count($cities) . " data kabupaten/kota...");
            }
            
            $this->command->info('Berhasil menyimpan ' . count($cities) . ' data kabupaten/kota');
            
        } catch (\Exception $e) {
            $this->command->error('Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
