<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'RA Alfalah Wahyurejo',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>RA</b>ALFALAH',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'RAALFALAH',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => true,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
//        [
//            'type' => 'sidebar-menu-search',
//            'text' => 'search',
//        ],
        [
            'text' => 'blog',
            'url'  => 'admin/blog',
            'can'  => 'manage-blog',
        ],
        [
            'text'        => 'Dashboard',
            'route'         => 'admin.dashboard.index',
            'icon'        => 'far fas fa-home',
            'label_color' => 'success',
            'can'         => 'admin'
        ],
        [
            'text'        => 'Master User',
            'route'         => 'admin.user.index',
            'icon'        => 'far fa-fw fa-user',
            'label_color' => 'success',
            'can'         => 'admin'
        ],
        ['header' => 'Master Siswa', 'can'=> 'admin'],
        [
            'text'        => 'Data Siswa',
            'route'         => 'admin.siswa.index',
            'icon'        => 'far fas fa-user-graduate',
            'label_color' => 'success',
            'can'         => 'admin'
        ],
//        [
//            'text'        => 'Pendaftaran Siswa',
//            'route'         => 'admin.pendaftaran.index',
//            'icon'        => 'far fas fa-chevron-right',
//            'label_color' => 'success',
//            'can'         => 'admin'
//        ],
        ['header' => 'Master Guru', 'can'=> 'admin'],
        [
            'text'        => 'Data Guru',
            'route'         => 'admin.guru.index',
            'icon'        => 'far fas fa-chalkboard-teacher',
            'label_color' => 'success',
            'can'         => 'admin'
        ],
//        [
//            'text'        => 'Data Kepegawaian',
//            'route'         => 'admin.kepegawaian.index',
//            'icon'        => 'far fas fa-briefcase',
//            'label_color' => 'success',
//            'can'         => 'admin'
//        ],
        [
            'text'        => 'Data Jabatan',
            'route'         => 'admin.jabatan.index',
            'icon'        => 'far fas fa-star',
            'label_color' => 'success',
            'can'         => 'admin'
        ],
        ['header' => 'Master Wali Siswa & Pembayaran', 'can'=> 'admin'],
//        [
//            'text'        => 'Data Wali',
//            'route'         => 'admin.wali.index',
//            'icon'        => 'far fas fa-user-friends',
//            'label_color' => 'success',
//            'can'         => 'admin'
//        ],
        [
            'text'        => 'Jenis Wali',
            'route'         => 'admin.jeniswali.index',
            'icon'        => 'far fas fa-users-cog',
            'label_color' => 'success',
            'can'         => 'admin'
        ],
        [
            'text'        => 'Data Laporan Pembayaran',
            'route'         => 'admin.laporan_pembayaran.index',
            'icon'        => 'far fas fa-money-bill-wave-alt',
            'label_color' => 'success',
            'can'         => 'admin'
        ],
        ['header' => 'Master Kelas', 'can'=> 'admin'],
        [
            'text'        => 'Data Kelas',
            'route'         => 'admin.kelas.index',
            'icon'        => 'far fas fa-fan',
            'label_color' => 'success',
            'can'         => 'admin'
        ],
        ['header' => 'Informasi Lembaga', 'can'=> 'admin'],
        [
            'text'        => 'Data Lembaga',
            'route'         => 'admin.lembaga.index',
            'icon'        => 'far fas fa-school',
            'label_color' => 'success',
            'can'         => 'admin'
        ],
        [
            'text'        => 'Sarana Prasarana',
            'route'         => 'admin.sarpras.index',
            'icon'        => 'far fas fa-route',
            'label_color' => 'success',
            'can'         => 'admin'
        ],
        [
            'text'        => 'Surat Keterangan',
            'route'         => 'admin.surat_keterangan.index',
            'icon'        => 'far fas fa-envelope',
            'label_color' => 'success',
            'can'         => 'admin'
        ],
        ['header' => 'Alokasi Dana', 'can'=> 'admin'],
        [
            'text'        => 'Dana Masuk',
            'route'         => 'admin.dana_masuk.index',
            'icon'        => 'far fas fa-hand-holding-usd',
            'label_color' => 'success',
            'can'         => 'admin'
        ],
        [
            'text'        => 'Dana Keluar',
            'route'         => 'admin.dana_keluar.index',
            'icon'        => 'far fas fa-file-invoice-dollar',
            'label_color' => 'success',
            'can'         => 'admin'
        ],
        [
            'text'        => 'Sumber Dana',
            'route'         => 'admin.sumber_dana.index',
            'icon'        => 'far fas fa-coins',
            'label_color' => 'success',
            'can'         => 'admin'
        ],
        [
            'text'        => 'Jenis Pengeluaran',
            'route'         => 'admin.jenis_pengeluaran.index',
            'icon'        => 'far fas fa-comment-dollar',
            'label_color' => 'success',
            'can'         => 'admin'
        ],
        [
            'text'    => 'Inventory',
            'icon'    => 'fas fa-fw fa-share',
            'can'     => 'admin',
            'submenu' => [
                [
                    'text' => 'Data Inventory Barangg',
                    'route'  => 'admin.inventory.index',
                    'can'     => 'admin'
                ],
                [
                    'text'    => 'Kategori Barang',
                    'route'     => 'admin.kategori_barang.index',
                    'can'     => 'admin'
                ],
                [
                    'text' => 'Jenis Inventaris',
                    'route'  => 'admin.jenis_inventaris.index',
                    'can'     => 'admin'
                ],
            ],
        ],
        [
            'text'        => 'Arsip Surat',
            'route'         => 'admin.arsip_surat.index',
            'icon'        => 'far fas fa-archive',
            'label_color' => 'success',
            'can'         => 'admin'
        ],
        // Bendahara
        [
            'text'        => 'Dashboard',
            'route'         => 'bendahara.dashboard.index',
            'icon'        => 'far fas fa-home',
            'label_color' => 'success',
            'can'         => 'bendahara'
        ],
        [
            'text'        => 'Dana Masuk',
            'route'         => 'bendahara.dana_masuk.index',
            'icon'        => 'far fas fa-hand-holding-usd',
            'label_color' => 'success',
            'can'         => 'bendahara'
        ],
        [
            'text'        => 'Dana Keluar',
            'route'         => 'bendahara.dana_keluar.index',
            'icon'        => 'far fas fa-file-invoice-dollar',
            'label_color' => 'success',
            'can'         => 'bendahara'
        ],
        [
            'text'        => 'Sumber Dana',
            'route'         => 'bendahara.sumber_dana.index',
            'icon'        => 'far fas fa-coins',
            'label_color' => 'success',
            'can'         => 'bendahara'
        ],
        [
            'text'        => 'Jenis Pengeluaran',
            'route'         => 'bendahara.jenis_pengeluaran.index',
            'icon'        => 'far fas fa-comment-dollar',
            'label_color' => 'success',
            'can'         => 'bendahara'
        ],
        // Kepala Sekolah
        [
            'text'        => 'Dashboard',
            'route'         => 'kepsek.dashboard.index',
            'icon'        => 'far fas fa-home',
            'label_color' => 'success',
            'can'         => 'kepsek'
        ],
        [
            'text'        => 'Dana Masuk',
            'route'         => 'kepsek.dana_masuk.index',
            'icon'        => 'far fas fa-hand-holding-usd',
            'label_color' => 'success',
            'can'         => 'kepsek'
        ],
        [
            'text'        => 'Arsip Surat',
            'route'         => 'kepsek.arsip_surat.index',
            'icon'        => 'far fas fa-archive',
            'label_color' => 'success',
            'can'         => 'kepsek'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'TempusDominusBs4' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/moment/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.full.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css',
                ],
            ],
        ],
        'BsCustomFileInput' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bs-custom-file-input/bs-custom-file-input.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
