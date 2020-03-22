<?php

use App\Models\Exhibit;
use App\Models\Section;
use Illuminate\Database\Seeder;

class ExhibitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sections = Section::all()->pluck('id');

        factory(Exhibit::class, 50)->create()->each(function (Exhibit $exh) use ($sections) {
            $exh->sections()->attach($sections->random(rand(2, 3)));

            $exh->addMediaFromUrl('https://picsum.photos/1920/1080')->toMediaCollection('uploads');
        });
    }
}
