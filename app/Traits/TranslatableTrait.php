<?php


namespace App\Traits;


trait TranslatableTrait
{
    /**
     * @param  array  $inputs
     * @return $this
     */
    public function makeTranslation(array $inputs)
    {
        foreach (config('app.locales') as $locale) {
            foreach ($inputs as $input) {
                $this->setTranslation($input, $locale, request($locale.'.'.$input));
            }
        }

        return $this;
    }
}