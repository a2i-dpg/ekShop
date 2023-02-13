<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Company</a></li>
                        <li class="breadcrumb-item active">all company</li>
                    </ol>
                </div>
                <h4 class="page-title">Company Lists</h4>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="search">
                                <input type="text" wire:model.debounce.300ms='company_search_text'
                                    placeholder="Type anything for search" class=" form-control">
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="filter">
                                <select name="" id="" class=" form-select" wire:model="companyOrderBy">
                                    <option value="id">ID</option>
                                    <option value="company_name">Company Name</option>
                                    <option value="company_contact_person_number">Contact Number</option>
                                    <option value="company_email">Email</option>
                                    <option value="company_is_active">Status</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="filter">
                                <select name="" id="" class=" form-select" wire:model="asc_desc">
                                    <option value="1">Ascending</option>
                                    <option value="0">Descending</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="filter">
                                <select name="" id="" class=" form-select" wire:model="page_no">
                                    <option value=10>10</option>
                                    <option value=15>15</option>
                                    <option value=20>20</option>
                                    <option value=25>25</option>
                                    <option value=30>30</option>
                                    <option value=50>50</option>
                                    <option value=100>100</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="" wire:click.prevent = "clearSearch" class=" btn btn-danger">Clear</a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6 d-flex align-items-center gap-2">
                            <button wire:click="companyExport()" class=" btn btn-sm btn-outline-purple">Excel</button>
                            <button wire:click="companyExportPdf()" class=" btn btn-sm btn-outline-danger">PDF</button>
                            <button wire:click="companyExportCSV()" class=" btn btn-sm btn-outline-info">CSV</button>
                        </div>
                    </div>
                </div>
                <div id="company_wrap" class="card-body">
                    <table id="companyData_view" class="table w-100 nowrap no-footer" role="grid" style="margin-left: 0px; width: 1112.16px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Company Name</th>
                                <th>Address</th>
                                <th>Contact Person</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($companyData as $key => $data)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $data->company_name }}</td>
                                    <td>
                                       {{ $data->company_address }}
                                    </td>
                                    <td>{{ $data->company_contact_person_name }}</td>
                                    <td>{{ $data->company_contact_person_number }}</td>
                                    <td>{{ $data->company_email }}</td>
                                    
                                    @if ($data->company_is_active === 1)
                                        <td>
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        </td>
                                    @else
                                        <td>
                                            <span class="badge bg-soft-danger text-danger">Suspend</span>
                                        </td>
                                    @endif
                                    <td>
                                        <button wire:click="companyFind({{ $data->id }})"
                                            class=" btn btn-xs btn-info companyEdit" data-bs-toggle="modal"
                                            data-bs-target="#companyDataEdit"><i class="fas fa-edit"></i></button>
                                        <button wire:click="companyDelete({{ $data->id }})" class=" btn btn-xs btn-danger"><i
                                                class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $companyData->links() }}
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    {{-- Company edit Modal form --}}
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="companyDataEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:700px">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Company Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="company_update">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input class="form-control" name='company_name' type="text" class="form-control" id="company_name" placeholder="Enter company name" value="{{ $company_name }}" wire:model = 'company_name' readonly>
                                @error('company_name')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="company_address" class="form-label">Company Address</label>
                                <input name="company_address" type="text" class="form-control" id="company_address" placeholder="Enter company address" value="{{ old('company_address') }}" wire:model = 'company_address'>
                                @error('company_address')
                                <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="company_contact_person_name" class="form-label">Company Person Name</label>
                                <input name="company_contact_person_name" type="text" class="form-control" id="company_contact_person_name" placeholder="Company contact person name" value="{{ old('company_contact_person_name') }}" wire:model = 'company_contact_person_name'>
                                @error('company_contact_person_name')
                                <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="company_contact_person_number" class="form-label">Company Person Number</label>
                                <input name="company_contact_person_number" type="text" class="form-control" id="company_contact_person_number" placeholder="Company contact person number" value="{{ old('company_contact_person_number') }}" wire:model = 'company_contact_person_number' readonly>
                                @error('company_contact_person_number')
                                <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="company_email" class="form-label">Company Email</label>
                                <input name="company_email" type="email" class="form-control" id="company_email" placeholder="Company email" value="{{ old('company_email') }}" wire:model = 'company_email' readonly>
                                @error('company_email')
                                <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="company_is_active" class="form-label">Company Status</label>
                                <select class=" form-control" name="company_is_active" id="" wire:model = 'company_is_active'>
                                    <option value="1">Active</option>
                                    <option value="0">Suspend</option>
                                </select>
                                @error('company_is_active')
                                <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <input type="hidden" name="company_id" wire:model = 'company_id'>
                        </div>

                        <button class="btn btn-primary" type="submit">Update Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 @section('custom_script')
 
 @endsection