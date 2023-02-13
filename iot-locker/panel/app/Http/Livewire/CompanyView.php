<?php

namespace App\Http\Livewire;

use App\Exports\Company as ExportsCompany;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class CompanyView extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $company_name,$company_address,$company_contact_person_name,$company_contact_person_number,$company_is_active,$company_email,$company_id,$current_id,$company_search_text,$companyOrderBy='id',$asc_desc = false,$page_no=10;
    
    public function render()
    {
        $companyData = Company::search($this->company_search_text)
                                    ->where('soft_deleted_at',null)
                                    ->orderBy($this->companyOrderBy,$this->asc_desc?'asc':'desc')
                                    ->paginate($this->page_no);
        Session::put('companyData',$companyData);
        return view('livewire.company-view',['companyData'=>$companyData])
                ->extends('master')
                ->section('content');
    }

    public function clearSearch()
    {
        $this->company_search_text = '';
        
    }
    // Excel export company data
    public function companyExport(){
        return Excel::download(new ExportsCompany,'company.xlsx');
    }

    // Company data pdf export

    public function companyExportPdf(){
        return Excel::download(new ExportsCompany,'company.pdf',\Maatwebsite\Excel\Excel::DOMPDF);
    }

    // Company data csv export
    public function companyExportCSV(){
        return Excel::download(new ExportsCompany,'company.csv');
    }
    private function resetInputFields(){
        $this->company_name = '';
        $this->company_address = '';
        $this->company_contact_person_name = '';
        $this->company_contact_person_number = '';
        $this->company_email = '';
    }
    public function companyFind($id){

        $updateData = Company::findOrFail($id);
        $this->current_id = $updateData->id;
        $this->company_name = $updateData->company_name;
        $this->company_contact_person_name = $updateData->company_contact_person_name;
        $this->company_address = $updateData->company_address;
        $this->company_contact_person_number = $updateData->company_contact_person_number;
        $this->company_email = $updateData->company_email;
        $this->company_id = $updateData->company_id;
        $this->company_is_active = $updateData->company_is_active;
    }
    public function company_update(){
        $this->validate([
            'company_name'=>'required',
            'company_address'=>'required',
            'company_contact_person_name'=>'required',
            'company_contact_person_number'=>'required|max:11',
            'company_email'=>'required|email',
        ]);
        $company = Company::findOrFail($this->current_id);
        $company->company_id = $this->company_id;
        $company->company_name = $this->company_name;
        $company->company_address = $this->company_address;
        $company->company_contact_person_name = $this->company_contact_person_name;
        $company->company_contact_person_number = $this->company_contact_person_number;
        $company->company_email = $this->company_email;
        $company->company_is_active = $this->company_is_active;
        User::where('company_id',$this->current_id)->update(array('user_is_active'=>$this->company_is_active));
        if($company->update()){
            $this->resetInputFields();
            return redirect()->route('superAdmin.allCompany')->with('message','Company data update successfully !!');
        }
    }

    public function companyDelete($id){
        $deleteCompany = Company::where('id',$id)
                            ->update(array('soft_deleted_at'=>Carbon::now()));
        
        session()->flash('message', 'Company Removed Successfully'); 
    }
    
}
