<?php

namespace App\Http\Livewire\Admin\Agent;

use App\Helpers\SendSms;
use App\Helpers\ValidateNumber;
use App\Helpers\Variables;
use App\Jobs\SendCompanyEmail;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Str;

class AddAgent extends Component
{
    public $user_name,
        $user_full_name,
        $user_mobile_no,
        $email,
        $password,
        $user_address,
        $user_role,
        $admin_agent_roles,
        $passwordType = 'password',
        $authUser,
        $agentRole;

    public function mount()
    {
        $this->authUser = Auth::user();
        $this->agentRole = Role::find(Variables::companyAgentRole);
        
        $this->admin_agent_roles = Role::whereIn('role_slug', ['company-admin', 'company-agent'])->get();
    }

    public function render()
    {
        if($this->authUser->role_id != Variables::superAdminRole ){
            $this->user_role = $this->agentRole->id;
        }
        // dd($this->user_role);
        return view('livewire.admin.agent.add-agent')
            ->extends('master')
            ->section('content');
    }

    public function user_save()
    {
        $this->validate([
            'user_name' => 'required|unique:users',
            // 'user_full_name' => 'required',
            'user_mobile_no' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'user_role' => 'required'
        ]);
        // Validate Mobile Number
        $data = ValidateNumber::validNumber($this->user_mobile_no);
        $data = json_decode($data->getContent());
        $user = new User();
        // Check Mobile Number Validation
        if ($data->code == 200) {
            $data = $data->formatted_number;
        } else {
            return session()->flash('error', $data->reason);
        }
        $user->user_id = substr($this->user_full_name, -2) . '_' . str::random(2);
        // $username = strtolower(preg_replace("/\s+/", "", $this->user_full_name)) . str::random(4);
        $username = $this->user_name; //new line
        $user->user_name = $username;
        $user->user_full_name = $this->user_full_name;
        $user->user_mobile_no = $data;
        $user->email = $this->email;
        $user->user_address = $this->user_address;
        // $password = strtolower(preg_replace("/\s+/", "", $this->user_name)) . '@' . str::random(3);
        $password = $this->password;
        $user->password = Hash::make($password);
        $user->role_id = $this->user_role; //company-agent
        $user->company_id = session('company_id');

        if ($user->save()) {

            // Call The Clear input function
            $this->clearInput();
            $message = "Your iotLocker credential, username: $username and password: $password";
            /**
             * 
             * Send Email and Message
             */
            $details = [
                'password' => $password,
                'username' => $username,
                'email' => $this->email
            ];
            try {
                // SendCompanyEmail::dispatch($details);
                SendSms::sendSms($user->user_mobile_no, $message);
            } catch (Exception $e) {
                session()->flash('error', 'Email Not Send!  <br> ' . $e->getMessage());
            }


            session()->flash(
                'message',
                'New ' . str_replace(' ', '_', $user->role->role_slug) . ' Added Successfully.
            <br> Sent SMS to <b>' . $user->user_mobile_no . '</b>  with credentials'
            );

            // if($user->role->role_slug == "company-agent"){
            //     session()->flash('message', 'New Agent Added Successfully');
            // }elseif($user->role->role_slug == "company-admin"){

            // }

        }
    }
    public function clearInput()
    {
        $this->user_full_name = "";
        $this->user_mobile_no = "";
        $this->email = "";
        $this->user_address = "";
    }

    public function setPassType(){
        ($this->passwordType == "password")? $this->passwordType="text" : $this->passwordType ="password";
    }
}
