<?php

namespace App\Http\Livewire\Admin;

use App\Helpers\SendSms;
use App\Helpers\ValidateNumber;
use App\Jobs\SendCompanyEmail;
use App\Models\Rider;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
class AddDelivery extends Component
{

    public $user_full_name,$user_mobile_no,$email,
    $user_address,
    $passwordType = "password",
    $password,
    $showRoleField = false,
    $user_role,
    $super_admin_slug = 'super-admin',
    $super_admin_role_id,
    $special_rider_slug = 'special-rider',
    $special_rider_role_id,
    $rider_slug = 'delivery-man',
    $rider_role_id,
    $deliveryManRoles,
    $rider_role = 4;

    public function mount()
    {
        $this->user_role = Role::find(Auth::user()->role_id);
        $this->deliveryManRoles = Role::whereIn('role_slug',['delivery-man','special-rider'])->get();

        $this->rider_role_id = Role::where('role_slug',$this->rider_slug)->first()->id;
        $this->special_rider_role_id = Role::where('role_slug',$this->special_rider_slug)->first()->id;

        $rider_role = Role::where('role_slug', $this->rider_slug)->first();
        if(isset($rider_role)){
            $this->rider_role_id = $rider_role->id;
        }
        
        $special_rider_role = Role::where('role_slug', $this->special_rider_slug)->first();
        if(isset($special_rider_role)){
            $this->special_rider_role_id = $special_rider_role->id;
        }


        if($this->user_role->role_slug == $this->super_admin_slug){
            $this->showRoleField = true;
            $this->rider_role = $this->special_rider_role_id;
        }else{
            $this->rider_role = $this->rider_role_id;
        }
    }
    
    public function render()
    {
        // dd(session('company_id'));
        return view('livewire.admin.add-delivery')
                ->extends('master')
                ->section('content');
    }

    public function delivery_man_save(){

        
        $this->validate([
            'user_full_name'=>'required',
            'user_mobile_no'=>'required|unique:riders',
            // 'email'=>'required|email|unique:riders',
            'password'=>'required|min:5',
            // 'user_address'=>'required'
        ]);
        // Validate Mobile Number
        $data = ValidateNumber::validNumber($this->user_mobile_no);
        $data = json_decode($data->getContent());
        
        // dd($data);
        $delivery_man = new Rider();
        // Check Mobile Number Validation
        if($data->code == 200){
            $data=$data->formatted_number;
        }
        else{
            return session()->flash('error', $data->reason);
        }
        $delivery_man->user_id = substr($this->user_full_name,-2).'_'.str::random(2);
        $username = strtolower(preg_replace("/\s+/","", $this->user_full_name)).str::random(4);
        $delivery_man->user_name = $username;
        $delivery_man->user_full_name = $this->user_full_name;
        $delivery_man->user_mobile_no = $data;
        $delivery_man->email = $this->email;
        $delivery_man->user_address = $this->user_address;
        // $password = strtolower(preg_replace("/\s+/","", $this->user_full_name)).''.str::random(5);
        $password = $this->password;
        $delivery_man->password = Hash::make($password);
        $delivery_man->role_id = $this->rider_role;
        $delivery_man->company_id = session('company_id');

        // dd($delivery_man);
        if($delivery_man->save()){
            // dd($delivery_man);
            // Call The Clear input function
            $this->clearInput();
            $message = "Your iotLocker credential, number: $data and password: $password";
            /**
             * Send Email and Message
             */ 
            $details = [
                'password' => $this->password,
                'username' => $username,
                'email'=>'ab8f84fef2-a0c25c@inbox.mailtrap.io'
            ];
            try {
                // SendCompanyEmail::dispatch($details);
                // SendSms::sendSms($delivery_man->user_mobile_no, $message);
                
            } catch (Exception $e) {
                session()->flash('error', 'Email Not Send!  <br> '.$e->getMessage());
            }
            session()->flash(
                'message', 
                'New Delivery Man Added Successfully. <br> Sent SMS to <b>' . $delivery_man->user_mobile_no . '</b>  with credentials'
            );
        }
    }
    public function clearInput(){
        $this->user_full_name = "";
        $this->user_mobile_no = "";
        $this->email = "";
        $this->user_address = "";
        $this->password = "";
    }
    

    public function setPassType(){
        ($this->passwordType == "password")? $this->passwordType="text" : $this->passwordType ="password";
    }
}
