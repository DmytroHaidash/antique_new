<?php


namespace App\Traits;


trait SortableTrait
{
    use \Spatie\EloquentSortable\SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort_order'
    ];
}