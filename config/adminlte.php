<?php

/**
         * AdminLTE Configuration
         */

return [

    'title' => env('APP_NAME', 'Laravel'),
    'logo'  => 'logo-mini.png',


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
        'admin' => [
            [
                'title'     => 'Dashboard',
                'icon'      => 'fas fa-tachometer-alt fa-fw',
                'route'     => 'home',
                'active'    => 'home',
            ],

            // Header Name
            'User',
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
                'title'     => 'Asesi',
                'icon'      => 'fas fa-user',
                'route'     => 'admin.user.asesi.index',
                'active'    => 'admin.user.asesi.*',
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
            'TUK',
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
            'Sertifikasi',
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
            [
                'title'     => 'Unit Kompetensi Element',
                'icon'      => 'fas fa-list-ul',
                'route'     => 'admin.sertifikasi.ukelement.index',
                'active'    => 'admin.sertifikasi.ukelement.*',
            ],
            'Asesi',
            [
                'title'     => 'Custom Data',
                'icon'      => 'fas fa-list-ol',
                'route'     => 'admin.asesi.customdata.index',
                'active'    => 'admin.asesi.customdata.*',
            ],
            [
                'title'     => 'APL-01',
                'icon'      => 'fas fa-list-ol',
                'route'     => 'admin.asesi.apl01.index',
                'active'    => 'admin.asesi.apl01.*',
            ],
            'Ujian',
            [
                'title'     => 'Jadwal Ujian',
                'icon'      => 'fas fa-tachometer-alt fa-fw',
                'active'    => 'home',
                'sub_menu'  => [
                    [
                        'title'     => 'Buat Jadwal',
                        'icon'      => 'fas fa-tachometer-alt fa-fw',
                        'route'     => 'home',
                        'active'    => 'home',
                    ],
                    [
                        'title'     => 'Buat Jadwal',
                        'icon'      => 'fas fa-tachometer-alt fa-fw',
                        'route'     => 'home',
                        'active'    => 'home',
                    ]
                ]
            ]
        ],
        'tuk' => [],
        'assesor' => [],
    ],
];
