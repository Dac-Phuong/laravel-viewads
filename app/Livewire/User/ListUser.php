<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;

class ListUser extends Component
{
    public $list_user;
    public function render()
    {
        $this->list_user = User::get();
        return view('livewire.user.list-user');
    }
}
