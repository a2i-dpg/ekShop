<?php

namespace App\Http\Livewire;

use App\Helpers\ValidateNumber;
use App\Jobs\SendCompanyEmail;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Str;

class LocalAdmin extends Component
{   
    public $allAdmin,$user_name,$user_mobile_no,$email;
    public function render()
    {
        $this->allAdmin = User::where('role_id',2)->get();
        return view('livewire.local-admin')
                ->extends('master')
                ->section('content');
    }

    private function clearInput(){
        $this->user_name = '';
        $this->user_mobile_no = '';
        $this->email = '';
    }
    public function addAdmin(){
        $this->validate([
            'user_name'=>'required|unique:users',
            'user_mobile_no'=>'required|unique:users',
            'email'=>'required|unique:users|email'
        ]);
        $input['user_name']=$this->user_name;
        $username = $input['user_name'];
        $input['user_id'] = $this->user_name.''.Str::random(2);
        $data = ValidateNumber::validNumber($this->user_mobile_no);
        $data = json_decode($data->getContent());
        if($data->code == 200){
            $data=$data->formatted_number;
        }
        else{
            return session()->flash('error', $data->reason);
        }
        $input['user_mobile_no'] =$data;
        $input['email'] = $this->email;
        $password = strtolower(str_replace([' '],'',$this->user_name)).''.Str::random(4);
        $input['password'] = Hash::make($password);
        $input['role_id'] = 2;
        $input['created_at'] = Carbon::now();
        $input['updated_at'] = Carbon::now();
        User::insert($input);
         /**
             * 
             * Send Email and Message
             */ 
            $details = [
                'password' => $password,
                'username' => $username,
                'email'=>'ab8f84fef2-a0c25c@inbox.mailtrap.io'
            ];
            SendCompanyEmail::dispatchSync($details);

        session()->flash('success','Admin add successfully');
        $this->clearInput();
    }
    public function adminDelete($id){
        User::where('id',$id)->delete();
        session()->flash('error','Admin delete successfully');
    }
}
