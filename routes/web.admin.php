<?php

Route::group([
    'as' => 'admin.',
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['auth', 'role:admin|moderator']
], function () {
    Route::get('/', function () {
        return redirect()->route('admin.posts.index');
    });

    Route::resource('authors', 'AuthorsController')->except('show');
    Route::resource('sections', 'SectionsController')->except('show');
    Route::resource('exhibits', 'ExhibitsController')->except('show');

    Route::resource('posts', 'PostsController')->except('show');
    Route::resource('categories', 'CategoriesController')->except('show');

    Route::resource('cities', 'CitiesController')->except('show');
    Route::resource('places', 'PlacesController')->except('show');
    Route::resource('exhibitions', 'ExhibitionsController')->except('show');

    Route::resource('pages', 'PagesController')->except('show');
    Route::resource('publications', 'PublicationsController')->except('show');

    Route::resource('products', 'ProductsController')->except('show');
    Route::resource('product_categories', 'ProductCategoriesController')->except('show');
    Route::resource('orders', 'OrdersController')->except('create', 'destroy');

    Route::resource('contacts', 'ContactsController')->except('show');
    Route::resource('users', 'UsersController')->except('show');
    Route::post('contacts/{contact}/restore', 'ContactsController@restore')->name('contacts.restore');

    Route::resource('suppliers', 'SuppliersController')->except(['show'])->middleware('role:admin');
    Route::resource('statuses', 'StatusesController')->except(['show'])->middleware('role:admin');

    Route::get('accounting', 'AccountingsController@index')->name('accounting.index')->middleware('role:admin');
    Route::get('accounting/{product}', 'AccountingsController@pdf')->name('accounting.pdf')->middleware('role:admin');

    Route::group([
        'as' => 'media.',
        'prefix' => 'media'
    ], function () {
        Route::get('browser', 'MediaController@all');
        Route::post('browser', 'MediaController@upload');
        Route::post('upload', 'UploadsController@store')->name('store');
        Route::post('wysiwyg', 'MediaController@wysiwyg')->name('wysiwyg');
        Route::delete('{media}', 'UploadsController@destroy')->name('destroy');
    });

    $sortable = [
        'contacts' => 'ContactsController',
        'exhibits' => 'ExhibitsController',
        'sections' => 'SectionsController',
        'products' => 'ProductsController',
        'product_categories' => 'ProductCategoriesController'
    ];

    foreach ($sortable as $name => $controller) {
        Route::group([
            'as' => "sort.{$name}.",
            'prefix' => "sort/{$name}"
        ], function () use ($name, $controller) {
            Route::post('{item}/up', "{$controller}@up")->name('up');
            Route::post('{item}/down', "{$controller}@down")->name('down');
        });
    }
});