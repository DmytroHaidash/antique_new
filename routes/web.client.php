<?php

Route::group([
    'as' => 'client.',
    'namespace' => 'Client'
], function () {
    Route::get('/', 'HomeController@index')->name('index');

    Route::get('category/{section}/{child_section?}', 'CatalogController@categories')->name('category');
    Route::group([
        'as' => 'catalog.',
    ], function () {
        Route::get('catalog', 'CatalogController@index')->name('index');
        Route::get('catalog/all', 'CatalogController@all')->name('all');
        Route::post('catalog', 'CatalogController@index')->name('search');
        Route::get('lot/{product}', 'CatalogController@show')->name('show');
        Route::post('lot/{product}', 'OrderController')->name('buy');
        Route::post('lot/{product}/question', 'CatalogController@question')->name('question');
        Route::get('lot/pdf/{product}', 'CatalogController@pdf')->name('pdf');
    });
    Route::group([
        'as' => 'collection.',
        'prefix' => 'collection'
    ], function () {
        Route::get('exhibit/{exhibit}', 'CollectionsController@show')->name('show');
        Route::get('{section}/{child_section?}', 'CollectionsController@index')->name('index');
    });

    Route::group([
        'as' => 'blog.',
        'prefix' => 'blog'
    ], function () {
        Route::get('/', 'BlogController@index')->name('index');
        Route::get('{post}', 'BlogController@show')->name('show');
    });

    Route::group([
        'as' => 'exhibitions.',
        'prefix' => 'exhibitions'
    ], function () {
        Route::get('/', 'ExhibitionsController@index')->name('index');
        Route::get('{exhibition}', 'ExhibitionsController@show')->name('show');
    });

    Route::group([
        'as' => 'contacts.',
        'prefix' => 'contacts'
    ], function () {
        Route::get('/', 'ContactsController@index')->name('index');
    });
    Route::get('subscribe', 'SubscribesController@index')->name('subscribe.index');
    Route::post('subscribe', 'SubscribesController@subscribe')->name('subscribe');


    Route::get('search', 'SearchController@index')->name('search.index');

    Route::get('{locale}', 'LocalesController')
        ->where('locale', '('.implode('|', config('app.locales')).')');

    Route::get('{page}/{subpage?}', 'PagesController@show')
        ->where('page', '(about|book|expertise)');
    Route::post('/question', 'PagesController@question')->name('question');
    Route::post('/order', 'PagesController@order')->name('order');
});
