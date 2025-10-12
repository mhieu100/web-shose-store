<?php

return [

    'columns' => [

        'text' => [

            'actions' => [
                'collapse_list' => 'Hiển thị ít hơn :count',
                'expand_list' => 'Hiển thị thêm :count',
            ],

            'more_list_items' => 'và :count khác',

        ],

    ],

    'fields' => [

        'bulk_select_page' => [
            'label' => 'Chọn/bỏ chọn tất cả các mục cho hành động hàng loạt.',
        ],

        'bulk_select_record' => [
            'label' => 'Chọn/bỏ chọn mục :key cho hành động hàng loạt.',
        ],

        'bulk_select_group' => [
            'label' => 'Chọn/bỏ chọn nhóm :title cho hành động hàng loạt.',
        ],

        'search' => [
            'label' => 'Tìm kiếm',
            'placeholder' => 'Tìm kiếm',
            'indicator' => 'Tìm kiếm',
        ],

    ],

    'summary' => [

        'heading' => 'Tóm tắt',

        'subheadings' => [
            'all' => 'Tất cả :label',
            'group' => 'Nhóm :group',
            'page' => 'Trang này',
        ],

        'summarizers' => [

            'average' => [
                'label' => 'Trung bình',
            ],

            'count' => [
                'label' => 'Số lượng',
            ],

            'sum' => [
                'label' => 'Tổng',
            ],

        ],

    ],

    'actions' => [

        'disable_reordering' => [
            'label' => 'Hoàn thành sắp xếp lại bản ghi',
        ],

        'enable_reordering' => [
            'label' => 'Sắp xếp lại bản ghi',
        ],

        'filter' => [
            'label' => 'Lọc',
        ],

        'group' => [
            'label' => 'Nhóm',
        ],

        'open_bulk_actions' => [
            'label' => 'Hành động hàng loạt',
        ],

        'toggle_columns' => [
            'label' => 'Chuyển đổi cột',
        ],

    ],

    'empty' => [

        'heading' => 'Không tìm thấy :model',

        'description' => 'Tạo một :model để bắt đầu.',

    ],

    'filters' => [

        'actions' => [

            'remove' => [
                'label' => 'Xóa bộ lọc',
            ],

            'remove_all' => [
                'label' => 'Xóa tất cả bộ lọc',
                'tooltip' => 'Xóa tất cả bộ lọc',
            ],

            'reset' => [
                'label' => 'Đặt lại',
            ],

        ],

        'heading' => 'Bộ lọc',

        'indicator' => 'Bộ lọc đang hoạt động',

        'multi_select' => [
            'placeholder' => 'Tất cả',
        ],

        'select' => [
            'placeholder' => 'Tất cả',
        ],

        'trashed' => [

            'label' => 'Bản ghi đã xóa',

            'only_trashed' => 'Chỉ bản ghi đã xóa',

            'with_trashed' => 'Với bản ghi đã xóa',

            'without_trashed' => 'Không có bản ghi đã xóa',

        ],

    ],

    'grouping' => [

        'fields' => [

            'group' => [
                'label' => 'Nhóm theo',
                'placeholder' => 'Nhóm theo',
            ],

            'direction' => [

                'label' => 'Hướng nhóm',

                'options' => [
                    'asc' => 'Tăng dần',
                    'desc' => 'Giảm dần',
                ],

            ],

        ],

    ],

    'reorder_indicator' => 'Kéo và thả bản ghi theo thứ tự.',

    'selection_indicator' => [

        'selected_count' => '{1} 1 bản ghi đã chọn.|[2,*] :count bản ghi đã chọn.',

        'actions' => [

            'select_all' => [
                'label' => 'Chọn tất cả :count',
            ],

            'deselect_all' => [
                'label' => 'Bỏ chọn tất cả',
            ],

        ],

    ],

    'sorting' => [

        'fields' => [

            'column' => [
                'label' => 'Sắp xếp theo',
            ],

            'direction' => [

                'label' => 'Hướng sắp xếp',

                'options' => [
                    'asc' => 'Tăng dần',
                    'desc' => 'Giảm dần',
                ],

            ],

        ],

    ],

];