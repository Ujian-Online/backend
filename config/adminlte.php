<?php

/**
         * AdminLTE Configuration
         */

return [

    /**
     * Sidebar Title and Logo
     */
    'title' => env('APP_NAME', 'Laravel'),
    'logo'  => 'logo-mini.png',

    /**
     * Sidebar Color
     */
    'color' => [
        'navbar'    => '',
        'logo'      => 'navbar-success',
        'sidebar'   => 'sidebar-dark-success',
    ],

    /**
     * Auth Route Name or URL
     */
    'auth' => [
        'login'     => 'login',
        'logout'    => 'logout'
    ],

    /**
     * Sidebar Menu Based on User Type
     *
     * For Header Name, Just Use String Instead Array
     *
     * Default Array For Menu and Sub Menu
     * [
     *      // Menu Title
     *      'title' => 'Dashboard',
     *
     *      // Fontawesome Icon
     *      'icon'  => 'fas fa-tachometer-alt fa-fw',
     *
     *      // Right Badge (Optional) (Array)
     *      'badge' => [
     *          'class' => 'right badge badge-danger',
     *          'id'    => 'message',
     *          'value' => 0,
     *      ],
     *
     *      // URL Route Name Without function route()
     *      // Optional if have sub_menu
     *      'route' => 'home',
     *
     *      // External URL (Optional)
     *      'url'   => 'https://google.com',
     *
     *      // HREF Link (Optional)
     *      // @see Target: https://www.w3schools.com/tags/att_a_target.asp
     *      'target'=> '_blank',
     *
     *      // Menu Active Detected by isRoute() Function
     *      //
     *      // Value can be string (single menu) or array (with sub_menu)
     *      // string = 'admin.user.*'
     *      //
     *      // use array if have sub_menu
     *      // array = ['admin.user.*', 'admin.other.*']
     *      'active' => 'admin.user.*'
     *
     *      // Sub Menu
     *      // Array Detail Same as Above
     *      // 1 Array Menu Only Support 2 Sub Menu
     *      'sub_menu' => []
     * ]
     */

    'menu_sidebar' => [
        /**
         * Menu For Admin Access
         */
        'admin' => [
            [
                'title'     => 'Dashboard',
                'icon'      => 'fas fa-tachometer-alt fa-fw',
                'route'     => 'home',
                'active'    => 'home',
            ],
            [
                'title'     => 'User',
                'icon'      => 'fas fa-users',
                'active'    => 'admin.user.*',
                'sub_menu'  => [
                    [
                        'title'     => 'User',
                        'icon'      => 'fas fa-users',
                        'route'     => 'admin.user.index',
                        'active'    => [
                            'admin.user.index',
                            'admin.user.create',
                            'admin.user.show',
                            'admin.user.update',
                        ],
                    ],
                    [
                        'title'     => 'Asesor',
                        'icon'      => 'fas fa-user-tie',
                        'route'     => 'admin.user.asesor.index',
                        'active'    => 'admin.user.asesor.*',
                    ],
                    [
                        'title'     => 'TUK',
                        'icon'      => 'fas fa-users-cog',
                        'route'     => 'admin.user.tuk.index',
                        'active'    => 'admin.user.tuk.*',
                    ],
                ],
            ],
            [
                'title'     => 'TUK',
                'icon'      => 'fas fa-house-user',
                'active'    => 'admin.tuk.*',
                'sub_menu'  => [
                    [
                        'title'     => 'TUK',
                        'icon'      => 'fas fa-house-user',
                        'route'     => 'admin.tuk.index',
                        'active'    => [
                            'admin.tuk.index',
                            'admin.tuk.create',
                            'admin.tuk.show',
                            'admin.tuk.update',
                        ],
                    ],
                    [
                        'title'     => 'Bank',
                        'icon'      => 'fas fa-money-check-alt',
                        'route'     => 'admin.tuk.bank.index',
                        'active'    => 'admin.tuk.bank.*',
                    ],
                ],
            ],
            [
                'title'     => 'Sertifikasi',
                'icon'      => 'fas fa-list-ul',
                'active'    => 'admin.sertifikasi.*',
                'sub_menu'  => [
                    [
                        'title'     => 'Sertifikasi',
                        'icon'      => 'fas fa-list-ul',
                        'route'     => 'admin.sertifikasi.index',
                        'active'    => [
                            'admin.sertifikasi.index',
                            'admin.sertifikasi.create',
                            'admin.sertifikasi.show',
                            'admin.sertifikasi.update',
                        ],
                    ],
                    [
                        'title'     => 'TUK',
                        'icon'      => 'fas fa-list-ul',
                        'route'     => 'admin.sertifikasi.tuk.index',
                        'active'    => 'admin.sertifikasi.tuk.*',
                    ],
                    [
                        'title'     => 'Unit Kompetensi',
                        'icon'      => 'fas fa-list-ul',
                        'route'     => 'admin.sertifikasi.uk.index',
                        'active'    => 'admin.sertifikasi.uk.*',
                    ],
                    // [
                    //     'title'     => 'Unit Kompetensi Element',
                    //     'icon'      => 'fas fa-list-ul',
                    //     'route'     => 'admin.sertifikasi.ukelement.index',
                    //     'active'    => 'admin.sertifikasi.ukelement.*',
                    // ],
                ],
            ],
            [
                'title'     => 'Asesi',
                'icon'      => 'fas fa-user',
                'active'    => 'admin.asesi.*',
                'sub_menu'  => [
                    [
                        'title'     => 'Custom Data (APL-01)',
                        'icon'      => 'fas fa-list-ol',
                        'route'     => 'admin.asesi.customdata.index',
                        'active'    => 'admin.asesi.customdata.*',
                    ],
                    [
                        'title'     => 'APL-01',
                        'icon'      => 'fas fa-user',
                        'url'       => '/admin/asesi/apl01?is_verified=false',
                        'active'    => 'admin.asesi.apl01.*',
                    ],
                    // [
                    //     'title'     => 'APL-01 Custom Data',
                    //     'icon'      => 'fas fa-list-ol',
                    //     'route'     => 'admin.asesi.apl01customdata.index',
                    //     'active'    => 'admin.asesi.apl01customdata.*',
                    // ],
                    [
                        'title'     => 'APL-02',
                        'icon'      => 'fas fa-list-ol',
                        'route'     => 'admin.asesi.apl02.index',
                        'active'    => 'admin.asesi.apl02.*',
                    ],
                    // [
                    //     'title'     => 'Unit Kompetensi Element',
                    //     'icon'      => 'fas fa-list-ol',
                    //     'route'     => 'admin.asesi.ukelement.index',
                    //     'active'    => 'admin.asesi.ukelement.*',
                    // ],
                ],
            ],
            [
                'title'     => 'Ujian',
                'icon'      => 'fas fa-book',
                'active'    => 'admin.ujian.*',
                'sub_menu'  => [
                    [
                        'title'     => 'Jadwal Ujian',
                        'icon'      => 'fas fa-book',
                        'route'     => 'admin.ujian.jadwal.index',
                        'active'    => 'admin.ujian.jadwal.*',
                    ],
                    [
                        'title'     => 'Jadwal Ujian Asesi',
                        'icon'      => 'fas fa-book-reader',
                        'route'     => 'admin.ujian.asesi.index',
                        'active'    => 'admin.ujian.asesi.*',
                    ],
                    [
                        'title'     => 'Asesi Jawaban',
                        'icon'      => 'fas fa-book-open',
                        'route'     => 'admin.ujian.jawaban.index',
                        'active'    => 'admin.ujian.jawaban.*',
                    ],
                    [
                        'title'     => 'Asesi Jawaban Pilihan',
                        'icon'      => 'fas fa-list',
                        'route'     => 'admin.ujian.jawabanpilihan.index',
                        'active'    => 'admin.ujian.jawabanpilihan.*',
                    ],
                ],
            ],
            [
                'title'     => 'Soal',
                'icon'      => 'fa fa-book-open',
                'active'    => 'admin.soal.*',
                'sub_menu'  => [
                    [
                        'title'     => 'Daftar Soal',
                        'icon'      => 'fa fa-book-open',
                        'route'     => 'admin.soal.daftar.index',
                        'active'    => 'admin.soal.daftar.*'
                    ],
                    // [
                    //     'title'     => 'Pilihan Ganda',
                    //     'icon'      => 'fas fa-tasks',
                    //     'route'     => 'admin.soal.pilihanganda.index',
                    //     'active'    => 'admin.soal.pilihanganda.*',
                    // ],
                    [
                        'title'     => 'Paket',
                        'icon'      => 'fas fa-cube',
                        'route'     => 'admin.soal.paket.index',
                        'active'    => 'admin.soal.paket.*',
                    ],
                    // [
                    //     'title'     => 'Paket Item',
                    //     'icon'      => 'fas fa-cubes',
                    //     'route'     => 'admin.soal.paketitem.index',
                    //     'active'    => 'admin.soal.paketitem.*',
                    // ],
                    // [
                    //     'title'     => 'Unit Kompetensi',
                    //     'icon'      => 'far fa-bookmark',
                    //     'route'     => 'admin.soal.unitkompetensi.index',
                    //     'active'    => 'admin.soal.unitkompetensi.*'
                    // ],
                ],
            ],
            [
                'title'     => 'Order',
                'icon'      => 'fas fa-cart-plus',
                'active'    => 'admin.order.*',
                'sub_menu'  => [
                    [
                        'title'     => 'List Order',
                        'icon'      => 'fas fa-cart-plus',
                        'route'     => 'admin.order.index',
                        'active'    => 'admin.order.*',
                    ],
                ],
            ],
        ],

        /**
         * Menu For TUK Access
         */
        'tuk' => [],

        /**
         * Menu For Asesor Access
         */
        'assesor' => [],
    ],
];
