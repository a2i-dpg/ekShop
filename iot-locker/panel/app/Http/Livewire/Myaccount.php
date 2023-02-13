<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Myaccount extends Component
{
    public $accountInfo,$email,$user_mobile_no,$user_address,$user_full_name,$user_name;
    public function render()
    {
        $this->accountInfo = User::where('id',session('user_id'))->first();
        return view('livewire.myaccount')
                ->extends('master')
                ->section('content');
    }

    public function userFind(){
        $user = User::findOrFail(session('user_id'));
        $this->user_name = $user->user_name;
        $this->user_address = $user->user_address;
        $this->user_mobile_no = $user->user_mobile_no;
        $this->email = $user->email;
        $this->user_full_name = $user->user_full_name;
    }
    public function user_update(){
        User::where('id',session('user_id'))->update(array('email'=>$this->email,'user_mobile_no'=>$this->user_mobile_no,'user_address'=>$this->user_address,'user_full_name'=>$this->user_full_name));

        Session::flash('message','User update successfully');
    }
}
