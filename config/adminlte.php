<?php

/**
         * AdminLTE Configuration
         */

return [

    'title' => env('APP_NAME', 'Laravel'),
    'logo'  => 'logo.png',


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
                'active'    => 'admin.user.*',
            ],
            [
                'title'     => 'Assesor',
                'icon'      => 'fas fa-user-tie',
                'route'     => 'admin.assesor.index',
                'active'    => 'admin.assesor.*',
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
