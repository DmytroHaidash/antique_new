<?php

use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\Models\Media;

if (!function_exists('makeFileName')) {
    function makeFileName(UploadedFile $file)
    {
        return Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
    }
}

if (!function_exists('clearPhone')) {
    function clearPhone($phone)
    {
        return str_replace([' ', '-', '(', ')'], '', $phone);
    }
}

if (!function_exists('makeQueryString')) {
    function makeQueryString($params)
    {
        if (!is_array($params)) {
            return [];
        }

        $request = array_merge(request()->except('page'), $params);

        return $request;
    }
}