<?php

namespace App\Services;
use App\Models\Page;
use Talanoff\ImpressionAdmin\Helpers\NavItem;

class Delimiter
{

}

class Navigation
{
    private $exhibits;
    private $book;
    private $publications;

    public function __construct()
    {
        $this->exhibits = app('sections')->filter(function ($section) {
            return $section->type == 'exhibit';
        });
        $this->book = Page::where('slug', 'book')->first();
//        $this->publications = app('sections')->filter(function($section) {
//            return $section->type == 'publication';
//        });
    }

    public function header()
    {
        return [
            (object)[
                'name' => trans('nav.catalog'),
                'link' => route('client.catalog.index'),
            ],
            (object) [
                'name' => __('nav.about'),
                'link' => url('/about')
            ],
            /*(object) [
                'name' => __('nav.collection'),
                'link' => null,
                'children' => $this->exhibits->map(function ($item) {
                    return $this->handleChild($item);
                })
            ],*/
//            (object) [
//                'name' => __('nav.publications'),
//                'link' => null,
//                'children' => $this->publications->map(function ($item) {
//                        return $this->handleChild($item);
//                    })
//            ],
            (object) [
                'name' => __('nav.blog'),
                'link' => route('client.blog.index')
            ],
            (object) [
                'name' => __('nav.expertise'),
                'link' => url('/expertise')
            ],
            /*(object) [
                'name' => __('nav.exhibitions'),
                'link' => route('client.exhibitions.index')
            ],*/
           /* (object) [
                'name' => __('nav.book'),
                'link' => url('/book'),
                'published' => $this->book->published
            ],*/
            (object) [
                'name' => __('nav.contacts'),
                'link' => route('client.contacts.index')
            ]
        ];
    }

    public function footer()
    {
        $items = [
            (object) [
                'name' => __('common.footer.info'),
                'link' => null,
                'children' => [
                    (object) [
                        'name' => __('nav.about'),
                        'link' => url('/about')
                    ],
                    (object) [
                        'name' => __('nav.blog'),
                        'link' => route('client.blog.index')
                    ],
                    (object) [
                        'name' => __('nav.expertise'),
                        'link' => url('/expertise')
                    ],
                    /*(object) [
                        'name' => __('nav.exhibitions'),
                        'link' => route('client.exhibitions.index')
                    ],*/
                    (object) [
                        'name' => __('nav.contacts'),
                        'link' => route('client.contacts.index')
                    ],
                    /*(object) [
                        'name' => __('nav.book'),
                        'link' => url('/book'),
                        'published' => $this->book->published
                    ]*/
                ]
            ],
        ];

        $sections = $this->exhibits->filter(function ($section) {
            return !$section->parent_id;
        });

        foreach ($sections as $section) {
            array_push($items, (object) [
                'name' => $section->title,
                'link' => route('client.collection.index', $section->slug),
                'children' => $this->exhibits->filter(function ($child) use ($section) {
                    return $child->parent_id == $section->id;
                })->map(function($child) use ($section) {
                    return (object)[
                        'name' => $child->title,
                        'link' => route('client.collection.index', [$section->slug, $child->slug])
                    ];
                })
            ]);
        }

        return $items;
    }

    public function backend()
    {
        $items = [
            new NavItem([
                'name' => 'Товары',
                'route' => 'products',
                'icon' => 'i-folder ',
            ]),
            new NavItem([
                'name' => 'Категории товаров',
                'route' => 'product_categories',
                'icon' => 'i-structure',
            ]),
            new NavItem([
                'name' => 'Заказы',
                'route' => 'orders',
                'icon' => 'i-gallery',
            ]),
//            new Delimiter(),
//            new NavItem([
//                'name' => 'Экспонаты',
//                'route' => 'exhibits',
//                'icon' => 'i-gallery',
//            ]),
//            new NavItem([
//                'name' => 'Публикации',
//                'route' => 'publications',
//                'icon' => 'i-layers',
//            ]),
//            new NavItem([
//                'name' => 'Секции',
//                'route' => 'sections',
//                'icon' => 'i-structure',
//            ]),
            /*  new NavItem([
                  'name' => 'Авторы',
                  'route' => 'authors',
                  'icon' => 'i-users',
              ]),*/
            new Delimiter(),
            new NavItem([
                'name' => 'Пресс-центр',
                'route' => 'posts',
                'icon' => 'i-newspaper',
            ]),
            new NavItem([
                'name' => 'Категории',
                'route' => 'categories',
                'icon' => 'i-bullet-list',
            ]),
            /*new Delimiter(),
            new NavItem([
                'name' => 'Выставки',
                'route' => 'exhibitions',
                'icon' => 'i-calendar',
            ]),
            new NavItem([
                'name' => 'Города',
                'route' => 'cities',
                'icon' => 'i-pin',
            ]),
            new NavItem([
                'name' => 'Места проведения',
                'route' => 'places',
                'icon' => 'i-flag',
            ]),*/
            new Delimiter(),
            new NavItem([
                'name' => 'Контакты',
                'route' => 'contacts',
                'icon' => 'i-add-user',
            ]),
            new NavItem([
                'name' => 'Страницы',
                'route' => 'pages',
                'icon' => 'i-clipboard',
            ]),

        ];
        $admin = [];
        if(\Auth::user()->hasRole('admin')){
            $admin= [
                new Delimiter(),
                new NavItem([
                    'name' => 'Пользователи',
                    'route' => 'users',
                    'icon' => 'i-users',
                ]),
                new Delimiter(),
                new NavItem([
                    'name' => 'Статусы',
                    'route' => 'statuses',
                    'icon' => 'i-versions'
                ]),
                new NavItem([
                    'name' => 'Поставщики',
                    'route' => 'suppliers',
                    'icon' => 'i-book'
                ]),
                new NavItem([
                    'name' => 'Бухгалтерия',
                    'route' => 'accounting',
                    'icon' => 'i-diagram'
                ]),
            ];
        }
        return array_merge($items, $admin);
    }

    /**
     * @param $item
     * @return object
     */
    private function handleChild($item)
    {
        $sections = [$item];

        if ($item->parent_id) {
            array_unshift($sections, $item->parent);
        }

        return (object) [
            'name' => $item->title,
            'link' => route('client.collection.index', $sections),
            'is_parent' => is_null($item->parent_id)
        ];
    }
}
