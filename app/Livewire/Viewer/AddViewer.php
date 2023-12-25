<?php

namespace App\Livewire\Viewer;

use App\Models\Viewers;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Str;

class AddViewer extends Component
{
    public $username;
    public $email;
    public $phone;
    public $account_name;
    public $account_number;
    public $code;
    public $password;
    public $password_bank;

    public function submit()
    {
        $this->validate(
            [
                'username' => 'required|string|regex:/^[a-zA-Z0-9]+$/',
                'email' => 'required|email|unique:viewers,email',
                'phone' => 'required|numeric|regex:/^\d{10,}$/|unique:viewers,phone',
                'password' => 'required|min:6',
            ],
            [
                'username.required' => 'Trường tên tài khoản là bắt buộc.',
                'username.regex' => 'Định dạng trường tên người dùng không hợp lệ.',
                'email.required' => 'Trường email người dùng là bắt buộc.',
                'email.unique' => 'Email đã tồn tại.',
                'email.email' => 'Trường email phải là địa chỉ email hợp lệ.',
                'phone.unique' => 'Số điện thoại đã tồn tại.',
                'phone.regex' => 'Định dạng trường điện thoại không hợp lệ.',
                'phone.required' => 'Trường số điện thoại là bắt buộc.',
                'phone.numeric' => 'Vui lòng nhập chính xác số điện thoại',
                'password.required' => 'Trường mật khẩu là bắt buộc.',
                'password.min' => 'Trường mật khẩu tối thiểu 6 chữ số.',
            ]
        );
        if ($this->code) {
            $check_code = Viewers::where('code', $this->code)->first();
            if (empty($check_code)) {
                $this->dispatch('error', 'Mã giới thiệu không đúng');
                return;
            }
        }
        $shortenedUsername = substr($this->username, 0, 3);

        $create_viewer = Viewers::create(
            [
                'username' => $this->username,
                'email' => $this->email,
                'phone' => $this->phone,
                'account_name' => $this->account_name,
                'presenter_id'  => $check_code->id ?? 0,
                'account_number' => $this->account_number,
                'code' => $shortenedUsername . Str::random(5),
                'password' => Hash::make($this->password),
                'password_bank' => Hash::make($this->password_bank),
            ]
        );
        $create_viewer->save();
        $this->dispatch('success', 'Tạo người xem mới thành công');
        $this->reset(['username', 'email', 'phone', 'account_name', 'account_number', 'password', 'password_bank', 'code']);
    }
    public function render()
    {
        return view('livewire.viewer.add-viewer');
    }
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
