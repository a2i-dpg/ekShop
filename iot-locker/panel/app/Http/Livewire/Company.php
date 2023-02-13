<?php

namespace App\Http\Livewire;

use App\Helpers\ValidateNumber;
use App\Jobs\SendCompanyEmail;
use App\Mail\CompanyMail;
use App\Models\Company as ModelsCompany;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class Company extends Component
{

    /**
     * 
     * Company Create Functionality
     */
    public $company_name,$company_address,$company_contact_person_name,$company_email,$company_contact_person_number;
    public function company_save(){
        $this->validate([
            'company_name'=>'required',
            'company_address'=>'required',
            'company_contact_person_name'=>'required',
            'company_contact_person_number'=>'required|unique:users',
            'company_email'=>'required|email|unique:companies',
        ]);
        $company = new ModelsCompany();
        $company->company_id = substr($this->company_name,-2).'_'.rand(2,2);
        $company->company_name = $this->company_name;
        $company->company_address = $this->company_address;
        $data = ValidateNumber::validNumber($this->company_contact_person_number);
        $data = json_decode($data->getContent());
        if($data->code == 200){
            $data=$data->formatted_number;
        }
        else{
            return session()->flash('error', $data->reason);
        }
        $company->company_contact_person_name = $this->company_contact_person_name;
        $company->company_contact_person_number = $data;
        $company->company_email = $this->company_email;

        if($company->save()){
            $user = new User();
            $username = strtolower(preg_replace("/\s+/", "", $company->company_name));
            $user->user_name =  $username;
            $user->user_id = substr($user->user_name,-2).'_'.rand(2,2);
            $user->user_full_name = $this->company_contact_person_name;
            $user->user_mobile_no = $this->company_contact_person_number;
            $user->email = $this->company_email;
            $user->user_address = $this->company_address;
            $password = $username.''.Str::random(2);
            $user->password = Hash::make($password);
            $user->role_id = 3;
            $user->company_id = $company->company_id;
            $user->save();
    
            /**
             * 
             * Send Email and Message
             */ 
            $details = [
                'password' => $password,
                'username' => $username,
                'email'=>'ab8f84fef2-a0c25c@inbox.mailtrap.io'
            ];
            SendCompanyEmail::dispatch($details);
            return redirect()->route('superAdmin.createCompany')->with('message','Company create successfully !!');
        }else{
            return redirect()->route('superAdmin.createCompany')->with('message','Error');
        }
        
    }
    public function render()
    {
        return view('livewire.company')
                ->extends('master')
                ->section('content');
    }
}
