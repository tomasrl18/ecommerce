<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class CreateUser extends Component
{
    public $name, $email, $password, $password2;

    protected $rules = [
        'name' => 'required',
        'email' => 'email|required|unique:users,email',
        'password' => 'required|same:password2',
        'password2' => 'required|same:password',
    ];

    public function addUser()
    {
        $this->validate();

        $user = new User([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        $user->save();

        $this->redirect(route('admin.users.index'));
    }

    public function render()
    {
        return view('livewire.admin.create-user')
            ->layout('layouts.admin');
    }
}
