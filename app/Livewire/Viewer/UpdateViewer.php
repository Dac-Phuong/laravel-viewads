<?php

namespace App\Livewire\Viewer;

use App\Models\Viewers;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UpdateViewer extends Component
{
    public $username;
    public $email;
    public $phone;
    public $account_name;
    public $account_number;
    public $code;
    public $password;
    public $password_bank;
    public $viewer;
    protected $listeners = ['update_viewer' => 'mount'];

    public function mount($id = null)
    {
        $this->viewer = Viewers::find($id);
        if ($this->viewer) {
            $this->username = $this->viewer->username;
            $this->email = $this->viewer->email;
            $this->phone = $this->viewer->phone;
            $this->account_name = $this->viewer->account_name;
            $this->account_number = $this->viewer->account_number;
            $this->code = '';
            $this->password = '';
            $this->password_bank = '';
        }
    }
    public function submit()
    {
        $this->validate(
            [
                'username' => 'required|string|regex:/^[a-zA-Z0-9]+$/',
                'email' => 'required|email',
                'phone' => 'required|numeric|regex:/^\d{10,}$/',
            ],
            [
                'username.required' => 'Trường tên tài khoản là bắt buộc.',
                'username.regex' => 'Định dạng trường tên người dùng không hợp lệ.',
                'email.required' => 'Trường email người dùng là bắt buộc.',
                'email.email' => 'Trường email phải là địa chỉ email hợp lệ.',
                'phone.regex' => 'Định dạng trường điện thoại không hợp lệ.',
                'phone.required' => 'Trường số điện thoại là bắt buộc.',
                'phone.numeric' => 'Vui lòng nhập chính xác số điện thoại',
            ]
        );
        if ($this->code) {
            $check_code = Viewers::where('code', $this->code)->first();
            if (empty($check_code)) {
                $this->dispatch('error', 'Mã giới thiệu không đúng');
                return;
            }
        }
        $this->viewer->username = $this->username;
        $this->viewer->email = $this->email;
        $this->viewer->phone = $this->phone;
        $this->viewer->account_name = $this->account_name;
        $this->viewer->account_number = $this->account_number;
        $this->viewer->presenter_id =   $check_code->id ?? 0;
        $this->viewer->password =  Hash::make($this->password);
        $this->viewer->password_bank =  Hash::make($this->password_bank);
        $this->viewer->save();
        $this->dispatch('success', 'Sửa người xem thành công');
    }
    public function render()
    {
        return view('livewire.viewer.update-viewer');
    }
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
