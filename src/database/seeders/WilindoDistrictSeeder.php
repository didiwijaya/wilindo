<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class WilindoDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $this->command->info('Mengambil data kecamatan dari API SPLP...');
            
            $response = Http::timeout(120)->get('https://api-splp.layanan.go.id/master_data_kecamatan/2.0');
            
            if (!$response->successful()) {
                throw new \Exception('Gagal mengambil data dari API SPLP. Status: ' . $response->status());
            }
            
            $records = $response->object();
            
            if (!isset($records->data) || !is_array($records->data)) {
                throw new \Exception('Format data API tidak valid');
            }

            $districts = [];
            foreach ($records->data as $dt) {
                if (!isset($dt->kode_kecamatan) || !isset($dt->kode_kabkota) || !isset($dt->nama_kecamatan)) {
                    continue;
                }
                
                $districts[] = [
                    'code' => str_replace('.', '', $dt->kode_kecamatan), 
                    'city_code' => str_replace('.', '', $dt->kode_kabkota), 
                    'name' => $dt->nama_kecamatan,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            if (empty($districts)) {
                throw new \Exception('Tidak ada data kecamatan yang ditemukan');
            }

            DB::table(config('wilindo.prefix') . 'districts')->truncate();

            $districts = collect($districts);
            $chunks = $districts->chunk(500);
            $totalInserted = 0;
            
            foreach ($chunks as $chunk) {
                DB::table(config('wilindo.prefix') . 'districts')->insert($chunk->toArray());
                $totalInserted += $chunk->count();
                $this->command->info("Memproses {$totalInserted} dari " . count($districts) . " data kecamatan...");
            }
            
            $this->command->info('Berhasil menyimpan ' . count($districts) . ' data kecamatan');
            
        } catch (\Exception $e) {
            $this->command->error('Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
