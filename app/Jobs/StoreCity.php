<?php

namespace App\Jobs;

use App\Models\City;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Stichoza\GoogleTranslate\GoogleTranslate;

class StoreCity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $city;

    /**
     * Create a new job instance.
     *
     * @param   $city
     */
    public function __construct($city)
    {
        $this->city = $city;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \ErrorException
     */
    public function handle()
    {
        $model = new City;
        $model->country = $this->city->iso2;
        $model->lat = $this->city->lat;
        $model->lng = $this->city->lng;

        foreach (config('app.locales') as $locale) {
            $name = $locale !== 'en'
                ? GoogleTranslate::trans($this->city->city, $locale)
                : $this->city->city;

            $model->setTranslation('name', $locale, $name);
        }

        $model->save();
    }
}
