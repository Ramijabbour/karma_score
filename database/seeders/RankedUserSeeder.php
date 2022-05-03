<?php

namespace Database\Seeders;

use App\Models\image;
use App\Models\RankedUser;
use Illuminate\Database\Seeder;

class RankedUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Image::factory()->count(30000)->create()
            ->each(function ($s){
                $s->rankedUser()->create(RankedUser::factory()->make()->toArray());
            });

    }
}
