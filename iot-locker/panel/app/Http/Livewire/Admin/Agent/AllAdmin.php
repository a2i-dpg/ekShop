<?php

namespace App\Http\Livewire\Admin\Agent;

use App\Exports\DeliveryManData;
use App\Helpers\ValidateNumber;
use App\Helpers\Variables;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class AllAdmin extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $authUser, $user_full_name, $user_mobile_no, $email, 
    $user_address, 
    $current_id, 
    $user_is_active, 
    $deliveryMan_search_text, 
    $deliveryManOrderBy = 'id', 
    $asc_desc = false, 
    $page_no, 
    $user_password, 
    $user_name,
    $userDeleteId;
    
    public function mount()
    {
        $this->authUser = Auth::user();
        // dd($this->authUser);
    }

    public function render()
    {
        // dd(Variables::companyAdminRole);
        $deliveryMan = User::search($this->deliveryMan_search_text,Variables::companyAdminRole)
            ->where('company_id', session('company_id'))
            ->where('soft_deleted_at', null)
            ->where('role_id',Variables::companyAdminRole) //Company Admin: 3 
            ->orderBy($this->deliveryManOrderBy, $this->asc_desc ? 'asc' : 'desc')
            ->paginate($this->page_no);

        // dd($deliveryMan);   

        session()->put('deliveryMan', $deliveryMan);

        return view('livewire.admin.agent.all-admin', ['deliveryMan' => $deliveryMan])
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
            'user_address' => 'required'
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
            $this->user_password = Hash::make($this->user_password);
            User::where('id', $this->current_id)->update(array('password' => $this->user_password));
        }
        return redirect()->route('admin.allAdmin')->with('message', 'Update Data Successfully');
    }

    public function adminDeleteId($userDeleteId)
    {
        $this->userDeleteId = $userDeleteId;
    }
    public function adminDelete()
    {
        User::where('id', $this->userDeleteId)
            ->delete();

        session()->flash('delete', 'Admin Removed Successfully');
    }

    public function deliveryManDataExport()
    {
        return Excel::download(new DeliveryManData, 'Admin list.xlsx');
    }
    
}
