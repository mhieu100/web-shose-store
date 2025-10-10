<?php

return [

    'breadcrumbs' => [

        'home' => [
            'label' => 'Trang chủ',
        ],

    ],

    'pagination' => [

        'label' => 'Điều hướng phân trang',

        'overview' => '{1} Hiển thị 1 kết quả|[2,*] Hiển thị :first đến :last trong :total kết quả',

        'fields' => [

            'records_per_page' => [

                'label' => 'mỗi trang',

                'options' => [
                    'all' => 'Tất cả',
                ],

            ],

        ],

        'actions' => [

            'first' => [
                'label' => 'Đầu',
            ],

            'go_to_page' => [
                'label' => 'Đi đến trang :page',
            ],

            'last' => [
                'label' => 'Cuối',
            ],

            'next' => [
                'label' => 'Tiếp',
            ],

            'previous' => [
                'label' => 'Trước',
            ],

        ],

    ],

    'section' => [

        'collapse' => [
            'label' => 'Thu gọn',
        ],

        'expand' => [
            'label' => 'Mở rộng',
        ],

    ],

];