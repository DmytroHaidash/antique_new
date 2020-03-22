<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (app('router')->currentRouteNamed('admin.*')) {
            $locale = 'ru';
        } else {
            if (session()->has('locale')) {
                $locale = session()->get('locale', config('app.locale'));
            } else {
                $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

                if ($locale !== 'ru' && $locale !== 'uk' && $locale !== 'en') {
                    $locale = 'uk';
                }
            }
        }

        session()->put('locale', $locale);
        app()->setLocale($locale);

        if (app()->getLocale() === 'ru') {
            setlocale(LC_TIME, 'ru_RU.utf-8');
        } elseif (app()->getLocale() === 'uk') {
            setlocale(LC_TIME, 'uk_UA.utf-8');
        }

        return $next($request);
    }
}
