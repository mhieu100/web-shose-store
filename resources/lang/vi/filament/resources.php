<?php

return [

    'shared' => [

        'actions' => [

            'cancel' => [
                'label' => 'Hủy',
            ],

            'create' => [
                'label' => 'Tạo mới',
            ],

            'create_another' => [
                'label' => 'Lưu & tạo thêm',
            ],

            'delete' => [
                'label' => 'Xóa',
            ],

            'edit' => [
                'label' => 'Chỉnh sửa',
            ],

            'save' => [
                'label' => 'Lưu',
            ],

            'view' => [
                'label' => 'Xem',
            ],

        ],

        'breadcrumb' => [

            'home' => [
                'label' => 'Trang chủ',
            ],

        ],

        'dates' => [

            'date_format' => 'd/m/Y',
            'date_time_format' => 'd/m/Y H:i:s',
            'time_format' => 'H:i:s',

        ],

        'table' => [

            'actions' => [

                'bulk_actions' => [
                    'label' => 'Hành động hàng loạt',
                ],

                'delete' => [
                    'label' => 'Xóa',
                ],

                'edit' => [
                    'label' => 'Chỉnh sửa',
                ],

                'export' => [
                    'label' => 'Xuất',
                ],

                'filter' => [
                    'label' => 'Lọc',
                ],

                'open_bulk_actions' => [
                    'label' => 'Mở hành động',
                ],

                'toggle_columns' => [
                    'label' => 'Chuyển đổi cột',
                ],

                'view' => [
                    'label' => 'Xem',
                ],

            ],

            'bulk_actions' => [

                'delete' => [
                    'label' => 'Xóa đã chọn',
                ],

            ],

            'columns' => [

                'text' => [
                    'actions' => [
                        'collapse_list' => 'Hiển thị ít hơn :count',
                        'expand_list' => 'Hiển thị thêm :count',
                    ],
                ],

            ],

            'fields' => [

                'bulk_select_page' => [
                    'label' => 'Chọn/bỏ chọn tất cả các mục cho hành động hàng loạt.',
                ],

                'bulk_select_record' => [
                    'label' => 'Chọn/bỏ chọn mục :key cho hành động hàng loạt.',
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

        ],

    ],

    'create' => [

        'form' => [

            'actions' => [

                'cancel' => [
                    'label' => 'Hủy',
                ],

                'create' => [
                    'label' => 'Tạo mới',
                ],

                'create_another' => [
                    'label' => 'Lưu & tạo thêm',
                ],

            ],

        ],

        'notifications' => [

            'created' => [
                'title' => 'Đã tạo',
            ],

        ],

    ],

    'delete' => [

        'notifications' => [

            'deleted' => [
                'title' => 'Đã xóa',
            ],

        ],

    ],

    'edit' => [

        'form' => [

            'actions' => [

                'cancel' => [
                    'label' => 'Hủy',
                ],

                'save' => [
                    'label' => 'Lưu thay đổi',
                ],

            ],

        ],

        'notifications' => [

            'saved' => [
                'title' => 'Đã lưu',
            ],

        ],

    ],

    'index' => [

        'notifications' => [

            'deleted' => [
                'title' => 'Đã xóa',
            ],

        ],

    ],

    'relation_managers' => [

        'actions' => [

            'attach' => [
                'label' => 'Đính kèm',
            ],

            'attach_and_associate' => [
                'label' => 'Đính kèm & liên kết',
            ],

            'create' => [
                'label' => 'Tạo mới',
            ],

            'delete' => [
                'label' => 'Xóa',
            ],

            'detach' => [
                'label' => 'Tách ra',
            ],

            'dissociate' => [
                'label' => 'Hủy liên kết',
            ],

            'edit' => [
                'label' => 'Chỉnh sửa',
            ],

            'view' => [
                'label' => 'Xem',
            ],

        ],

        'modals' => [

            'attach' => [

                'heading' => 'Đính kèm :label',

                'fields' => [

                    'record_select' => [
                        'placeholder' => 'Chọn một bản ghi',
                    ],

                ],

                'actions' => [

                    'attach' => [
                        'label' => 'Đính kèm',
                    ],

                    'attach_and_associate' => [
                        'label' => 'Đính kèm & liên kết',
                    ],

                ],

            ],

            'create' => [

                'heading' => 'Tạo :label',

                'actions' => [

                    'create' => [
                        'label' => 'Tạo mới',
                    ],

                    'create_and_create_another' => [
                        'label' => 'Tạo & tạo thêm',
                    ],

                ],

            ],

            'delete' => [

                'heading' => 'Xóa :label',

                'actions' => [

                    'delete' => [
                        'label' => 'Xóa',
                    ],

                ],

            ],

            'detach' => [

                'heading' => 'Tách :label',

                'actions' => [

                    'detach' => [
                        'label' => 'Tách ra',
                    ],

                ],

            ],

            'dissociate' => [

                'heading' => 'Hủy liên kết :label',

                'actions' => [

                    'dissociate' => [
                        'label' => 'Hủy liên kết',
                    ],

                ],

            ],

            'edit' => [

                'heading' => 'Chỉnh sửa :label',

                'actions' => [

                    'save' => [
                        'label' => 'Lưu thay đổi',
                    ],

                ],

            ],

        ],

        'notifications' => [

            'attached' => [
                'title' => 'Đã đính kèm',
            ],

            'created' => [
                'title' => 'Đã tạo',
            ],

            'deleted' => [
                'title' => 'Đã xóa',
            ],

            'detached' => [
                'title' => 'Đã tách ra',
            ],

            'dissociated' => [
                'title' => 'Đã hủy liên kết',
            ],

            'saved' => [
                'title' => 'Đã lưu',
            ],

        ],

    ],

];