<?php

namespace App\Filament\Pages\Auth;

class Login extends \Filament\Auth\Pages\Login
{
    public function mount(): void
    {
        parent::mount();

        // Xóa thông tin mặc định - để trống cho user tự nhập
        $this->form->fill([
            'email' => '',
            'password' => '',
            'remember' => false,
        ]);
    }
}
