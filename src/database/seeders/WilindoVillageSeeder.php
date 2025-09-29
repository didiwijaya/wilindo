<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class WilindoVillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '2048M');
            
            $this->command->info('Mengambil data desa/kelurahan dari API SPLP...');
            $this->command->warn('Proses ini mungkin memakan waktu lama karena data yang besar...');

            $response = Http::timeout(300)->get('https://api-splp.layanan.go.id/master_data_desakelurahan/2.0');
            
            if (!$response->successful()) {
                throw new \Exception('Gagal mengambil data dari API SPLP. Status: ' . $response->status());
            }
            
            $records = $response->object();
            
            if (!isset($records->data) || !is_array($records->data)) {
                throw new \Exception('Format data API tidak valid');
            }

            $villages = [];
            foreach ($records->data as $dt) {
                if (!isset($dt->kode_desa_kelurahan) || !isset($dt->kode_kecamatan) || !isset($dt->nama_desa_kelurahan)) {
                    continue;
                }
                
                $villages[] = [
                    'code' => str_replace('.', '', $dt->kode_desa_kelurahan), 
                    'district_code' => str_replace('.', '', $dt->kode_kecamatan), 
                    'name' => $dt->nama_desa_kelurahan,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            if (empty($villages)) {
                throw new \Exception('Tidak ada data desa/kelurahan yang ditemukan');
            }

            DB::table(config('wilindo.prefix') . 'villages')->truncate();

            $villages = collect($villages);
            $chunks = $villages->chunk(2500);
            $totalInserted = 0;
            
            foreach ($chunks as $chunk) {
                DB::table(config('wilindo.prefix') . 'villages')->insert($chunk->toArray());
                $totalInserted += $chunk->count();
                $this->command->info("Memproses {$totalInserted} dari " . count($villages) . " data desa/kelurahan...");
            }
            
            $this->command->info('Berhasil menyimpan ' . count($villages) . ' data desa/kelurahan');
            
        } catch (\Exception $e) {
            $this->command->error('Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
