<?php

return [

    'fields' => [

        'code_editor' => [

            'actions' => [

                'copy_to_clipboard' => [
                    'label' => 'Sao chép vào clipboard',
                ],

            ],

        ],

        'date_time_picker' => [

            'actions' => [

                'clear' => [
                    'label' => 'Xóa',
                ],

                'now' => [
                    'label' => 'Bây giờ',
                ],

            ],

        ],

        'file_upload' => [

            'editor' => [

                'actions' => [

                    'cancel' => [
                        'label' => 'Hủy',
                    ],

                    'drag_crop' => [
                        'label' => 'Chế độ kéo "cắt"',
                    ],

                    'drag_move' => [
                        'label' => 'Chế độ kéo "di chuyển"',
                    ],

                    'flip_horizontal' => [
                        'label' => 'Lật ngang hình ảnh',
                    ],

                    'flip_vertical' => [
                        'label' => 'Lật dọc hình ảnh',
                    ],

                    'move_down' => [
                        'label' => 'Di chuyển hình ảnh xuống',
                    ],

                    'move_left' => [
                        'label' => 'Di chuyển hình ảnh sang trái',
                    ],

                    'move_right' => [
                        'label' => 'Di chuyển hình ảnh sang phải',
                    ],

                    'move_up' => [
                        'label' => 'Di chuyển hình ảnh lên',
                    ],

                    'reset' => [
                        'label' => 'Đặt lại',
                    ],

                    'rotate_left' => [
                        'label' => 'Xoay hình ảnh sang trái',
                    ],

                    'rotate_right' => [
                        'label' => 'Xoay hình ảnh sang phải',
                    ],

                    'save' => [
                        'label' => 'Lưu',
                    ],

                    'zoom_100' => [
                        'label' => 'Phóng to hình ảnh 100%',
                    ],

                    'zoom_in' => [
                        'label' => 'Phóng to',
                    ],

                    'zoom_out' => [
                        'label' => 'Thu nhỏ',
                    ],

                ],

            ],

        ],

        'key_value' => [

            'actions' => [

                'add' => [
                    'label' => 'Thêm hàng',
                ],

                'delete' => [
                    'label' => 'Xóa hàng',
                ],

                'reorder' => [
                    'label' => 'Sắp xếp lại hàng',
                ],

            ],

            'fields' => [

                'key' => [
                    'label' => 'Khóa',
                ],

                'value' => [
                    'label' => 'Giá trị',
                ],

            ],

        ],

        'markdown_editor' => [

            'toolbar_buttons' => [
                'attach_files' => 'Đính kèm tệp',
                'blockquote' => 'Trích dẫn',
                'bold' => 'Đậm',
                'bullet_list' => 'Danh sách dấu đầu dòng',
                'code_block' => 'Khối mã',
                'heading' => 'Tiêu đề',
                'italic' => 'Nghiêng',
                'link' => 'Liên kết',
                'ordered_list' => 'Danh sách có số thứ tự',
                'redo' => 'Làm lại',
                'strike' => 'Gạch ngang',
                'table' => 'Bảng',
                'undo' => 'Hoàn tác',
            ],

        ],

        'repeater' => [

            'actions' => [

                'add' => [
                    'label' => 'Thêm vào :label',
                ],

                'add_between' => [
                    'label' => 'Chèn giữa',
                ],

                'delete' => [
                    'label' => 'Xóa',
                ],

                'clone' => [
                    'label' => 'Sao chép',
                ],

                'reorder' => [
                    'label' => 'Di chuyển',
                ],

                'move_down' => [
                    'label' => 'Di chuyển xuống',
                ],

                'move_up' => [
                    'label' => 'Di chuyển lên',
                ],

                'collapse' => [
                    'label' => 'Thu gọn',
                ],

                'expand' => [
                    'label' => 'Mở rộng',
                ],

                'collapse_all' => [
                    'label' => 'Thu gọn tất cả',
                ],

                'expand_all' => [
                    'label' => 'Mở rộng tất cả',
                ],

            ],

        ],

        'rich_editor' => [

            'dialogs' => [

                'link' => [

                    'actions' => [
                        'link' => 'Liên kết',
                        'unlink' => 'Hủy liên kết',
                    ],

                    'label' => 'URL',

                    'placeholder' => 'Nhập URL',

                ],

            ],

            'toolbar_buttons' => [
                'attach_files' => 'Đính kèm tệp',
                'blockquote' => 'Trích dẫn',
                'bold' => 'Đậm',
                'bullet_list' => 'Danh sách dấu đầu dòng',
                'code_block' => 'Khối mã',
                'h1' => 'Tiêu đề',
                'h2' => 'Tiêu đề',
                'h3' => 'Tiêu đề phụ',
                'italic' => 'Nghiêng',
                'link' => 'Liên kết',
                'ordered_list' => 'Danh sách có số thứ tự',
                'redo' => 'Làm lại',
                'strike' => 'Gạch ngang',
                'underline' => 'Gạch chân',
                'undo' => 'Hoàn tác',
            ],

        ],

        'select' => [

            'actions' => [

                'create_option' => [

                    'modal' => [

                        'heading' => 'Tạo mới',

                        'actions' => [

                            'create' => [
                                'label' => 'Tạo mới',
                            ],

                            'create_another' => [
                                'label' => 'Tạo & tạo thêm',
                            ],

                        ],

                    ],

                ],

                'edit_option' => [

                    'modal' => [

                        'heading' => 'Chỉnh sửa',

                        'actions' => [

                            'save' => [
                                'label' => 'Lưu',
                            ],

                        ],

                    ],

                ],

            ],

            'boolean' => [
                'true' => 'Có',
                'false' => 'Không',
            ],

            'loading_message' => 'Đang tải...',

            'max_items_message' => 'Chỉ có thể chọn tối đa :count.',

            'no_search_results_message' => 'Không có tùy chọn nào khớp với tìm kiếm của bạn.',

            'placeholder' => 'Chọn một tùy chọn',

            'searching_message' => 'Đang tìm kiếm...',

            'search_prompt' => 'Bắt đầu nhập để tìm kiếm...',

        ],

        'tags_input' => [
            'placeholder' => 'Thẻ mới',
        ],

        'text_input' => [

            'actions' => [

                'hide_password' => [
                    'label' => 'Ẩn mật khẩu',
                ],

                'show_password' => [
                    'label' => 'Hiển thị mật khẩu',
                ],

            ],

        ],

        'toggle_buttons' => [

            'boolean' => [
                'true' => 'Có',
                'false' => 'Không',
            ],

        ],

        'wizard' => [

            'actions' => [

                'previous_step' => [
                    'label' => 'Quay lại',
                ],

                'next_step' => [
                    'label' => 'Tiếp theo',
                ],

            ],

        ],

    ],

];