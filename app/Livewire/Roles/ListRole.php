<?php

namespace App\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;

class ListRole extends Component
{
    public $list_role;
    public function render()
    {
        $this->list_role = Role::get();
        return view('livewire.roles.list-role');
    }
}
