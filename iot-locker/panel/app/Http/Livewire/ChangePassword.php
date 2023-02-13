<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ChangePassword extends Component
{
    public $new_password,$confirm_password;
    public function render()
    {
        return view('livewire.change-password')->extends('master')->section('content');
    }
    public function clearInput(){
        $this->new_password = '';
        $this->confirm_password ='';
    }
    public function change_password(){
        $this->validate([
            'new_password'=>'required|min:5',
        ]);
        if($this->new_password != $this->confirm_password){
            Session::flash('message','New password and confirm password not match');
        }else{
            $new_password = Hash::make($this->confirm_password);
            User::where('id',session('user_id'))->update(array('password'=>$new_password));
            $this->clearInput();
            Session::flash('message','Password update successfully');
        }
    }
}
