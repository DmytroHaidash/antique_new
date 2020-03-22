<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class LocalesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param $locale
     * @return RedirectResponse
     */
    public function __invoke($locale): RedirectResponse
    {
        if (in_array($locale, config('app.locales'))) {
            session()->put('locale', $locale);
        }

        return back();
    }
}
