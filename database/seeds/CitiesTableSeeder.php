<?php

use App\Models\City;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            [
                'iso' => 'UA',
                'name' => [
                    'ru' => 'Харьков',
                    'uk' => 'Харків',
                    'en' => 'Kharkiv'
                ]
            ],
            [
                'iso' => 'UA',
                'name' => [
                    'ru' => 'Киев',
                    'uk' => 'Київ',
                    'en' => 'Kiev'
                ]
            ],
            [
                'iso' => 'UA',
                'name' => [
                    'ru' => 'Одесса',
                    'uk' => 'Одеса',
                    'en' => 'Odessa'
                ]
            ]
        ];

        foreach ($cities as $city) {
            $model = new City;
            $model->country = $city['iso'];

            foreach (config('app.locales') as $locale) {
                $model->setTranslation('name', $locale, $city['name'][$locale]);
            }

            $model->save();
        }
    }
}
