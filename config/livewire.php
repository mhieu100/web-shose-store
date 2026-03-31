<?php

return [
    'temporary_file_upload' => [
        'disk' => 'local',
        'directory' => 'livewire-tmp',
        'rules' => null,
        'max_upload_time' => 60,
        'cleanup' => true,
    ],
];
