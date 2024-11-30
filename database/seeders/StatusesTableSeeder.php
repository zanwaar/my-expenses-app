<?php

namespace Database\Seeders;

use App\Models\ApprovalStage;
use App\Models\Approver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        DB::table('statuses')->insert([
            ['name' => 'Menunggu Persetujuan'], // ID 1
            ['name' => 'Disetujui'],           // ID 2
        ]);

     
    }
}
