<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Locker</a></li>
                        <li class="breadcrumb-item active">all locker</li>
                    </ol>
                </div>
                <h4 class="page-title">Locker Lists</h4>
                @if (session()->has('delete'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('delete') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif
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
                                <input type="text" wire:model.debounce.300ms='box_search_text'
                                    placeholder="Type anything for search" class=" form-control">
                            </div>
                        </div>
                        {{-- <div class="col-md-3">
                            <div class="filter">
                                <select name="" id="" class=" form-select" wire:model="filter_company">
                                    <option value="">Select Company</option>
                                    @foreach ($company as $item)
                                        <option value="{{ $item->company_id }}">{{ $item->company->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-md-2">
                            <div class="filter">
                                <select name="" id="" class=" form-select" wire:model="boxOrderBy">
                                    <option value="id">ID</option>
                                    <option value="box_no">Box No.</option>
                                    <option value="box_key">Box Key</option>
                                    <option value="box_size">Box Size</option>
                                    <option value="locker_id">Locker Location</option>
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
                    </div>
                    {{-- <div class="row mt-3">
                        <div class="col-md-6 d-flex align-items-center gap-2">
                            <button wire:click="bookExport()" class=" btn btn-sm btn-outline-purple">Excel</button>
                            <button wire:click="bookExportPdf()" class=" btn btn-sm btn-outline-danger">PDF</button>
                            <button wire:click="bookExportCSV()" class=" btn btn-sm btn-outline-info">CSV</button>
                        </div>
                    </div> --}}
                </div>
                <div id="locker_wrap" class="card-body table-responsive">
                    <table id="locker_all" class="table table-striped table-bordered nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Locker ID</th>
                                <th>Locker Code</th>
                                <th>Locker Address</th>
                                <th>Locker Landmark</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($locker_list as $key => $data)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $data->locker_id }}</td>
                                    <td>{{ $data->locker_code }}</td>
                                    <td>{{ $data->location_address }}</td>
                                    @if ($data->location_landmark)
                                        <td>{{ $data->location_landmark }}</td>
                                    @else
                                        <td>N/A</td>
                                    @endif

                                    @if ($data->location_is_active === 1)
                                        <td>
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        </td>
                                    @else
                                        <td>
                                            <span class="badge bg-soft-danger text-danger">Disable</span>
                                        </td>
                                    @endif
                                    <td>
                                        <button wire:click="lockerEdit({{ $data->id }})"
                                            class=" btn btn-xs btn-info lockerEdit" data-bs-toggle="modal"
                                            data-bs-target="#lockerEdit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="deleteID({{ $data->id }})"
                                            class=" btn btn-xs btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    {{-- Locker edit Modal form --}}
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="lockerEdit" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:700px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Locker Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="locker_update" method="POST">
                        
                        <div class="row">
                            {{-- Locker Unique ID --}}
                            <div class="mb-3 col-md-6">
                                <label for="locker_code" class="form-label">
                                    Locker Unique ID <span class="text-danger">*</span> (<small>unique</small>)
                                </label>
                                <input name='locker_id' type="text" class="form-control readonly" id="locker_id"
                                    placeholder="Locker Unique Id" value="{{ old('locker_id') }}" wire:model='locker_id'
                                    readonly required>
                                @error('locker_id')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                                @if ($duplicate_locker)
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @endif
                            </div>
                            {{-- locker code --}}
                            <div class="mb-3 col-md-6">
                                <label for="locker_code" class="form-label">Locker Code <small>(Short Code)</small>
                                </label>
                                <input name='locker_code' type="text" class="form-control readonly" id="locker_code"
                                    placeholder="Locker Code" value="{{ old('locker_code') }}" wire:model='locker_code'>
                                @error('locker_code')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Selection for generating Unique Locker ID --}}
                        <div class="row">
                            <h5 class="text-center">Generate <b>locker unique id</b> by selecting these fields</h5>
                            <hr>
                            {{-- Country --}}
                            <div class="mb-3 col-md-6">
                                <label for="selectedCountryID" class="form-label">
                                    Select Country <span class="text-danger">*</span>
                                </label>
                                <select name="selectedCountryID" id="selectedCountryID" class=" form-control"
                                    wire:change="selectCountry($event.target.value)" wire:model='selectedCountryID'
                                    required>
                                    <option value="">Please select</option>
                                    @foreach ($countries as $item)
                                        <option value="{{ $item->id }}">{{ $item->country_name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedCountryID')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Company --}}
                            <div class="mb-3 col-md-6">
                                <label for="company" class="form-label">
                                    Select Company <span class="text-danger">*</span>
                                </label>
                                <select name="company" id="company" class=" form-control"
                                    wire:change="selectCompany($event.target.value)" wire:model="selectedCompanyID" required>
                                    <option value="">Please select</option>
                                    @foreach ($companies as $item)
                                        <option value="{{ $item->company_id }}">{{ $item->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('company')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Division --}}
                            <div class="mb-3 col-md-6">
                                <label for="division_id" class="form-label">
                                    Select Division <span class="text-danger">*</span>
                                </label>
                                <select name="division_id" id="division_id" class=" form-control"
                                    wire:change="findDistrict($event.target.value)" wire:model='division_id'
                                    required>
                                    <option value="">Please select</option>
                                    @foreach ($division as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('division_id')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Extra Code --}}
                            <div class="mb-3 col-md-6">
                                <label for="extra_code" class="form-label">
                                    Extra Code <span class="text-danger">*</span> (<small>unique</small>)
                                </label>
                                <input name='extra_code' type="text" class="form-control text-uppercase"
                                    id="extra_code" placeholder="ICT-01" value="{{ old('extra_code') }}"
                                    wire:keydown="setExtraCode()" wire:model='extra_code' required>

                                @if ($duplicate_locker)
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @endif
                                @error('extra_code')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Location address & landmark --}}
                        <div class="row">
                            <hr>
                            {{-- Landmark --}}
                            <div class="mb-3 col-md-6">
                                <label for="location_landmark" class="form-label">Locker Landmark
                                    (<small>Optional</small>)</label>
                                <input name='location_landmark' type="text" class="form-control"
                                    id="location_landmark" placeholder="Locker Landmark"
                                    value="{{ old('location_landmark') }}" wire:model='location_landmark'>
                                @error('location_landmark')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Display Resolution --}}
                            <div class="mb-3 col-md-6">
                                <label for="display_resolution_id" class="form-label">
                                    Select Display Resolution <span class="text-danger">*</span> (<small>1024 X
                                        768</small>)
                                </label>
                                <select name="display_resolution_id" id="display_resolution_id"
                                    class=" form-control" wire:model='display_resolution_id' required>
                                    <option value="">Please select</option>
                                    @foreach ($display_resolutions as $item)
                                        <option value="{{ $item->id }}">{{ $item->display_resolution }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('display_resolution_id')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Address --}}
                            <div class="mb-3 col-md-12">
                                <label for="address" class="form-label">
                                    Address <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" name="" id="" cols="20" rows="2"
                                    value="{{ old('address') }}" wire:model='address' placeholder="Enter address detail here, which will be send to the customer by SMS">
                                </textarea>

                                @error('address')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Active status --}}
                            <div class="mb-3 col-md-6">
                                <label for="lockerStatus" class="form-label">
                                    Locker Status <span class="text-danger">*</span>
                                </label>
                                <select name="lockerStatus" id="lockerStatus" class=" form-control"
                                    wire:model="lockerStatus" required>
                                    <option value="1">Active</option>
                                    <option value="0">Suspend</option>
                                </select>
                                @error('lockerStatus')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit form</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal:delete confirmation -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete? <strong>{{$locker_for_dlete}}</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal"
                        data-bs-dismiss="modal">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

</div>
@section('custom_script')
@endsection
