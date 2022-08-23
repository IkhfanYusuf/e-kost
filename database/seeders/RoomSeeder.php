<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 8; $i++) {
            if ($i < 5) {
                DB::table('rooms')->insert([
                    'room_name' => $i + 1,
                    'room_price' => '7' . $i . '0000',
                    'room_facility' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Integer maximus nulla quis tellus aliquam fermentum.
                    Suspendisse ac rhoncus felis, at luctus lacus. Proin vel
                    bibendum risus. Donec sollicitudin egestas mi, semper
                    placerat orci imperdiet a. Phasellus dictum luctus magna
                    vitae egestas. Donec ornare blandit justo, vel hendrerit
                    ipsum porta at. Sed quis ligula sed ante venenatis ultrices.
                    Vivamus ultrices vel magna vitae luctus. Pellentesque
                    dignissim nisl in augue pretium vulputate. Vivamus diam
                    justo, elementum cursus lacus ut, gravida tristique ex.
                    Morbi gravida sem nisi, quis finibus nibh hendrerit quis.
                    Quisque id viverra nisi..",
                    'deleted_at' => Carbon::now(),
                ]);
            } else {
                DB::table('rooms')->insert([
                    'room_name' => $i + 1,
                    'room_price' => '8' . $i . '0000',
                    'room_facility' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Integer maximus nulla quis tellus aliquam fermentum.
                    Suspendisse ac rhoncus felis, at luctus lacus. Proin vel
                    bibendum risus. Donec sollicitudin egestas mi, semper
                    placerat orci imperdiet a. Phasellus dictum luctus magna
                    vitae egestas. Donec ornare blandit justo, vel hendrerit
                    ipsum porta at. Sed quis ligula sed ante venenatis ultrices.
                    Vivamus ultrices vel magna vitae luctus. Pellentesque
                    dignissim nisl in augue pretium vulputate. Vivamus diam
                    justo, elementum cursus lacus ut, gravida tristique ex.
                    Morbi gravida sem nisi, quis finibus nibh hendrerit quis.
                    Quisque id viverra nisi..",
                ]);
            }
        }
    }
}
