<?php

namespace App\Http\Livewire\Admin\Agent;

use App\Exports\DeliveryManData;
use App\Helpers\SendSms;
use App\Helpers\ValidateNumber;
use App\Helpers\Variables;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class AllAgent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $user_full_name, $user_mobile_no, $email, $user_address,
        $current_id, $user_is_active, $deliveryMan_search_text,
        $deliveryManOrderBy = 'id', $asc_desc = false,
        $page_no, $user_password,
        $user_name, $userDeleteId;

    public function render()
    {
        // dd(Variables::companyAgentRole);
        $deliveryMan = User::search($this->deliveryMan_search_text,Variables::companyAgentRole)
            ->where('company_id', session('company_id'))
            ->where('soft_deleted_at', null)
            ->where('role_id', Variables::companyAgentRole) //agent role: 5 
            ->orderBy($this->deliveryManOrderBy, $this->asc_desc ? 'asc' : 'desc')
            ->paginate($this->page_no);

        session()->put('deliveryMan', $deliveryMan);

        return view('livewire.admin.agent.all-agent', ['deliveryMan' => $deliveryMan])
            ->extends('master')
            ->section('content');
    }



    public function deliveryManEdit($id)
    {
        $findDeliveryMan = User::where('id', $id)
            ->where('company_id', session('company_id'))
            ->first();
        $this->current_id = $findDeliveryMan->id;
        $this->user_full_name = $findDeliveryMan->user_full_name;
        $this->user_mobile_no = $findDeliveryMan->user_mobile_no;
        $this->email = $findDeliveryMan->email;
        $this->user_address = $findDeliveryMan->user_address;
        $this->user_is_active = $findDeliveryMan->user_is_active;
        $this->user_name = $findDeliveryMan->user_name;
    }
    public function updateDeliveryMan()
    {
        $this->validate([
            'user_full_name' => 'required',
            'user_mobile_no' => 'required',
            'email' => 'required|email',
        ]);
        // Validate Mobile Number
        $data = ValidateNumber::validNumber($this->user_mobile_no);
        $data = json_decode($data->getContent());
        // Check Mobile Number Validation
        if ($data->code == 200) {
            $data = $data->formatted_number;
        } else {
            return session()->flash('error', $data->reason);
        }

        $inputs = [
            'user_full_name' => $this->user_full_name,
            'user_mobile_no' => $data,
            'email' => $this->email,
            'user_address' => $this->user_address,
            'user_is_active' => $this->user_is_active,
            'user_name' => $this->user_name
        ];
        $updateDeliveryMan = User::where('id', $this->current_id)->update($inputs);

        if (!empty($this->user_password)) {
            $this->validate([
                'user_password' => 'min:5'
            ]);
            $hashedPassword = Hash::make($this->user_password);

            try {
                User::where('id', $this->current_id)->update(array('password' => $hashedPassword));
                $message = "Your iotLocker credential Changed, username: $this->user_name and password: $this->user_password";
                SendSms::sendSms($data, $message);
                return redirect()->route('admin.allAgent')->with('message', 'Update Data Successfully and send sms to '.$data);
            } catch (\Throwable $th) {
                session()->flash('error', "Something went wrong when updating password");
            }
            
        }
        return redirect()->route('admin.allAgent')->with('message', 'Update Data Successfully');
    }
    public function agentDeleteId($userDeleteId)
    {
        $this->userDeleteId = $userDeleteId;
    }
    public function agentDelete()
    {
        try {
            $user = User::where('id', $this->userDeleteId)
            ->delete();
            // dd($user);
            session()->flash('delete', 'Agent Removed Successfully');
        } catch (\Throwable $th) {
            session()->flash('error', 'This User can not be deleted!');
        }
        if (!isset($user)) {
            session()->flash('error', "This User can not be deleted! <br> User have child connections.");
        }

        
    }

    public function deliveryManDataExport()
    {
        return Excel::download(new DeliveryManData, 'Agent list.xlsx');
    }
}