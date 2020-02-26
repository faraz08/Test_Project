<?php

use Illuminate\Database\Seeder;

class OperatorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 50; $i++) {
            DB::table('operator')->insert([
                'name' => \Illuminate\Support\Str::random(10),

            ]);
        }
    }
}
