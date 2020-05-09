<?php

use App\Expert;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ExpertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Expert::create([
            "name" => "Li Wei",
            "country" => "China",
            "timezone" => "Asia/Shanghai",
            "expert" => "Chinese teacher",
            "start_work" => Carbon::createFromTime(9, 0, 0, "Asia/Shanghai"),
            "end_work" => Carbon::createFromTime(17, 0, 0, "Asia/Shanghai")
        ]);

        Expert::create([
            "name" => "Quasi Shawa",
            "country" => "Syria",
            "timezone" => "Asia/Damascus",
            "expert" => "Civil engineer",
            "start_work" => Carbon::createFromTime(6, 0, 0, "Asia/Damascus"),
            "end_work" => Carbon::createFromTime(12, 0, 0, "Asia/Damascus")
        ]);

        Expert::create([
            "name" => "Shimaa Badawy",
            "country" => "Egypt",
            "timezone" => "Africa/Cairo",
            "expert" => "Computer Engineer",
            "start_work" => Carbon::createFromTime(13, 0, 0, "Africa/Cairo"),
            "end_work" => Carbon::createFromTime(14, 0, 0, "Africa/Cairo")
        ]);
    }
}
