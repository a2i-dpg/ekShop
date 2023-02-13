<?php

namespace App\Http\Livewire\Admin;

use App\Exports\DeliveryManData;
use App\Helpers\SendSms;
use App\Helpers\ValidateNumber;
use App\Models\Rider;
use App\Models\Role;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class AllDeliveryMan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $user_full_name,
        $user_mobile_no,
        $email,
        $user_address,
        $current_id,
        $user_is_active,
        $deliveryMan_search_text,
        $deliveryManOrderBy = 'id',
        $asc_desc = false,
        $page_no,
        $user_password,
        $user_name,
        $showSpecialRider = false,
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
        $this->deliveryManRoles = Role::whereIn('role_slug', ['delivery-man', 'special-rider'])->get();

        $rider_role = Role::where('role_slug', $this->rider_slug)->first();
        if (isset($rider_role)) {
            $this->rider_role_id = $rider_role->id;
        }

        $special_rider_role = Role::where('role_slug', $this->special_rider_slug)->first();
        if (isset($special_rider_role)) {
            $this->special_rider_role_id = $special_rider_role->id;
        }

        if ($this->user_role->role_slug == $this->super_admin_slug) {
            $this->showRoleField = true;
            $this->rider_role = $this->special_rider_role_id;
        } else {
            $this->rider_role = $this->rider_role_id;
        }
    }
    // public function mount()
    // {
    //     $this->user_role = Role::find(Auth::user()->role_id);
    //     $this->special_rider_role_id = Role::where('role_slug', $this->special_rider_slug)->first()->id;
    // }

    public function render()
    {
        if ($this->user_role->role_slug == $this->super_admin_slug) {
            $this->showSpecialRider = true;

            $deliveryMan = Rider::search($this->deliveryMan_search_text)
                // ->where('company_id', session('company_id'))
                ->where('soft_deleted_at', null)
                // ->where('role_id',4)
                ->orderBy($this->deliveryManOrderBy, $this->asc_desc ? 'asc' : 'desc')
                ->paginate($this->page_no);
        } else {

            // dd("company Admin",$this->special_rider_role_id);
            $this->showSpecialRider = false;
            //company Admin
            $deliveryMan = Rider::search($this->deliveryMan_search_text)
                ->where('company_id', session('company_id'))
                ->where('soft_deleted_at', null)
                ->whereNotIn('role_id', [$this->special_rider_role_id])
                ->orderBy($this->deliveryManOrderBy, $this->asc_desc ? 'asc' : 'desc')
                ->paginate($this->page_no);
            // dd($this->special_rider_role_id ,$deliveryMan);
        }



        session()->put('deliveryMan', $deliveryMan);
        return view('livewire.admin.all-delivery-man', ['deliveryMan' => $deliveryMan])
            ->extends('master')
            ->section('content');
    }

    public function deliveryManEdit($id)
    {
        if ($this->user_role->role_slug == $this->super_admin_slug) {
            $findDeliveryMan = Rider::where('id', $id)
                ->first();
            $this->current_id = $findDeliveryMan->id;
            $this->user_full_name = $findDeliveryMan->user_full_name;
            $this->user_mobile_no = $findDeliveryMan->user_mobile_no;
            $this->email = $findDeliveryMan->email;
            $this->user_address = $findDeliveryMan->user_address;
            $this->user_is_active = $findDeliveryMan->user_is_active;
            $this->user_name = $findDeliveryMan->user_name;
        } else {
            $findDeliveryMan = Rider::where('id', $id)
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
    }
    public function updateDeliveryMan()
    {
        $this->validate([
            'user_full_name' => 'required',
            'user_mobile_no' => 'required',
            // 'email' => 'required|email',
            // 'user_address' => 'required'
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
        $updateDeliveryMan = Rider::where('id', $this->current_id)->update($inputs);

        if (!empty($this->user_password)) {
            $this->validate([
                'user_password' => 'min:5'
            ]);
            $hashedPassword = Hash::make($this->user_password);

            try {
                $delivery_man = Rider::where('id', $this->current_id)->update(array('password' => $hashedPassword));

                // dd("send sms",$data);
                $message = "Your iotLocker credential Changed, number: $data and password: $this->user_password";
                SendSms::sendSms($data, $message);
                // session()->flash(
                //     'message',
                //     'Delivery Man Updated Successfully. <br> Sent SMS to <b>' . $data . '</b>  with New credentials'
                // );
                if ($this->user_role->role_slug == $this->super_admin_slug) {
                    return redirect()->route('superAdmin.allDeliveryMan')->with('message', 'Update Data Successfully and send sms to ' . $data);
                }
                return redirect()->route('admin.allDeliveryMan')->with('message', 'Update Data Successfully and send sms to ' . $data);
            } catch (\Throwable $th) {
                session()->flash('error', "Something went wrong when updating password");
            }
        }

        // dd("edit");

        if ($this->user_role->role_slug == $this->super_admin_slug) {
            return redirect()->route('superAdmin.allDeliveryMan')->with('message', 'Update Data Successfully');
        }
        return redirect()->route('admin.allDeliveryMan')->with('message', 'Update Data Successfully');
    }
    public function deliveryManDelete($id)
    {
        $rider = Rider::where('id', $id)->with('bookings')->first();

        // dd(count($rider->bookings), count($rider->lockers));
        if (count($rider->bookings)) {
            session()->flash('delete', 'Can not Delete Cause This rider connected with ' . count($rider->bookings) . ' bookings.');
        }
        if (count($rider->lockers)) {
            session()->flash('delete', 'Can not Delete Cause This rider connected with ' . count($rider->lockers) . ' Locations.');
            return 0;
        }

        try {
            $rider = $rider->delete();
            // dd($user);
            session()->flash('delete', 'Delivery Man Removed Successfully');
        } catch (\Throwable $th) {
            session()->flash('error', 'This delivery man can not be deleted!');
        }
        if (!isset($rider)) {
            session()->flash('error', "This delivery man can not be deleted! <br> User have child connections.");
        }

        // session()->flash('delete', 'Delivery Man Removed Successfully');
    }

    public function deliveryManDataExport()
    {
        return Excel::download(new DeliveryManData, 'deliveryMan.xlsx');
    }
}
