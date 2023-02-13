<?php

namespace App\Http\Livewire;

use App\Models\ApiSecretHeader;
use App\Models\Locker;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class ApiSecret extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $key_title,$api_auth,$current_id,$is_active_edit,$api_auth_edit,$key_title_edit,$allLocker,$locker_id,$locker_id_edit,$secret_search_text,$page_no;
    public function render()
    {
        $allSecret = ApiSecretHeader::search($this->secret_search_text)
                                    ->with('locker')->paginate($this->page_no);
        $this->allLocker = Locker::where('location_is_active',1)->get();
        return view('livewire.api-secret',['allSecret'=>$allSecret])->extends('master')->section('content');
    }
    public function clearSearch(){
        $this->secret_search_text = '';
    }
    private function clearInputs()
    {
        $this->key_title = '';
        $this->api_auth = '';
    }
    private function clearInputs_edit()
    {
        $this->key_title_edit = '';
        $this->api_auth_edit = '';
    }
    public function apiSecret(){
        $this->validate([
            'key_title'=>'required|unique:api_secret_headers',
            'api_auth'=>'required|unique:api_secret_headers',
            'locker_id'=>'required'
        ]);


        $secret = new ApiSecretHeader();
        $secret->key_title = $this->key_title;
        $secret->api_auth = strtolower($this->api_auth);
        $key = 'test'.''.Str::random(5);
        $secret->secret_api_key = $key;
        $secret->locker_id = $this->locker_id;

        if($secret->save()){
            $this->clearInputs();
            session()->flash('success','New secrete add');
        }
    }
    public function secretEdit($id){
        $secretData = ApiSecretHeader::where('id',$id)->first();
        $this->key_title_edit = $secretData->key_title;
        $this->api_auth_edit = $secretData->api_auth;
        $this->is_active_edit = $secretData->is_active;
        $this->current_id = $secretData->id;
        $this->locker_id_edit = $secretData->locker_id_edit;
    }
    public function secretUpdate($id){
        $this->api_auth_edit = strtolower($this->api_auth_edit);
        $key = 'test'.''.Str::random(5);
        $update = ApiSecretHeader::where('id',$id)->update(array(
            'key_title'=>$this->key_title_edit,
            'api_auth'=>$this->api_auth_edit,
            'is_active'=>$this->is_active_edit,
            'secret_api_key'=>$key,
            'locker_id'=>$this->locker_id_edit
        ));
        if($update){
            $this->clearInputs_edit();
            session()->flash('message','Secret data update successfully !');
        }else{
            session()->flash('error','Something wrong');
        }
    }
    public function secretDelete($id)
    {
        $delete = ApiSecretHeader::where('id',$id)->delete();
        if($delete){
            session()->flash('success','Secret Delete Successfully');
        }
    }
    public function changeActive($id)
    {
        $changeSecret = ApiSecretHeader::where('id',$id)->update(array('is_active'=>0));

        if($changeSecret){
            session()->flash('success','Secret Suspend');
        }
    }
    public function changeSuspend($id)
    {
        $changeSecret = ApiSecretHeader::where('id',$id)->update(array('is_active'=>1));

        if($changeSecret){
            session()->flash('success','Secret Activated');
        }
    }
}
