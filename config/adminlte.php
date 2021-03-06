<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Studio X admin',

    'title_prefix' => 'Studio X - ',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>Studio X</b> ',

    'logo_mini' => '<b>A</b>LT',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'purple',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => '/admin',
    'logout_url' => '/admin/logout',
    'logout_method' => null,
    'login_url' => '/admin/login',
    'register_url' => '/register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */
	
	'menu' => [
		'FŐMENÜ',
		[
			'text' => 'Kezdőlap',
			'route' => 'admin_index',
			'roles' => ['login'],
			'icon' => 'dashboard',
			'active' => ['admin'],
		],
		[
			'text' => 'Tartalmak',
			'roles' => ['contents', 'stock'],
			'icon' => 'newspaper-o',
			'active' => ['admin/contents/*', 'admin/stock/*', 'admin/categories/*'],
			'submenu' => [
				[
					'text' => 'V-Stock-ok',
					'route' => 'admin_stock_list',
					'roles' => ['stock'],
					'icon' => 'video-camera',
					'active' => ['admin/stock/*'],
				],
				[
					'text' => 'Statikus lapok',
					'route' => 'admin_contents_list',
					'roles' => ['contents'],
					'icon' => 'newspaper-o',
					'active' => ['admin/contents/*'],
				],
				[
					'text' => 'Kategóriák',
					'route' => 'admin_categories_list',
					'roles' => ['stock', 'contents'],
					'icon' => 'tags',
					'active' => ['admin/categories/*'],
				],
			]
		],
		[
			'text' => 'Felhasználók',
			'route' => 'admin_users_list',
			'roles' => ['users'],
			'icon' => 'user',
			'active' => ['admin/users/*'],
		],
		[
			'text' => 'Beállítások',
			'roles' => ['roles', 'translates', 'options'],
			'icon' => 'gear',
			'active' => ['admin/roles/*', 'admin/translation', 'admin/translation/*', 'admin/options/*'],
			'submenu' => [
				[
					'text' => 'Jogosultságok',
					'route' => 'admin_roles_list',
					'roles' => ['roles'],
					'active' => ['admin/roles/*'],
					'icon' => 'users'
				],
				[
					'text' => 'Fordítások',
					'route' => 'admin_translation_getindex',
					'roles' => ['translates'],
					'icon' => 'language',
					'active' => ['admin/translation', 'admin/translation/*'],
				],
				[
					'text' => 'Opciók',
					'route' => 'admin_options_list',
					'roles' => ['options'],
					'icon' => 'language',
					'active' => ['admin/options/*'],
				],
			]
		],
		'NYELV VÁLASZTÁS',
	],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
		'wysihtml5' => true,
		'slimscroll' => true,
    ],
	
	'paginator' => [
		'default_length' => 10,
		'lengths' => [10, 25, 50, 100]
	]
];
