<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i <= 6; $i++) {
            DB::table('staff')->insert(
                [
                    'nip' => fake()->unique()->numerify('###'),
                    'name' => uniqid('nama_'),
                    'alamat' => uniqid('alamat_'),
                    'email' => uniqid() . '@gmail.com',
                    'foto' => '',
                    'created_at' => new \DateTime,
                    'updated_at' => null,
                ]
            );
        }
    }
}
