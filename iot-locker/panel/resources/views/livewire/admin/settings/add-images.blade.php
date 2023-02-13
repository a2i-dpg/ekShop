<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Setting</a></li>
                        <li class="breadcrumb-item active">Add Images</li>
                    </ol>
                </div>
                <h4 class="page-title">Settings</h4>
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8"></div>
        <div class="mb-3 col-md-4" id="setting_value_img">
            @if ($setting_value_img)
                <div class="row">
                    @foreach ($setting_value_img as $image)
                        <div class="col-3 card me-1 mb-1">
                            <img src="{{ $image->temporaryUrl() }}" class="image_item">
                        </div>
                    @endforeach
                </div>
            @endif
            <label for="setting_value" class="form-label">Upload images</label>
            <input name="setting_value_img" id="setting_value_img" type="file" class="form-control" value="{{ old('setting_value_img') }}"
                wire:model='setting_value_img' multiple>
            @error('setting_value_img')
                <span class=" text-small text-danger">{{ $message }}</span>
            @enderror

            {{-- wire:click="image_save()" --}}
            <a href="javascript:void(0)" class="btn btn-success btn_asset_submit" onclick="checkRequired()" >Submit</a>

        </div>
    </div>


    <div class="row">
        <div class="col-lg-11 mt-3 mx-auto">
            <div class="card">
                <h2 class=" text-center" style="font-size: 18px;font-weight:bold"> Images </h2>
                <div class="card-header bg-light">
                    {{-- {{$locations}} --}}
                    <div class="row">
                        {{-- <div class="col-md-2">
                            <div class="search">
                                <input type="text" wire:model.debounce.300ms='secret_search_text'
                                    placeholder="Type anything for search" class=" form-control">
                            </div>
                        </div> --}}
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
                        <div class="col-md-4">
                            <select name="" id="selected_location" class="form-select location_select" wire:model="selected_location">
                                <option value="{{ null }}">Select Location</option>
                                <option value="global_assets">Global Assets</option>
                                @foreach ($locations as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="" id="settingTypeForUpload" class="form-select location_select" wire:model="settingTypeForUpload">
                                <option value="{{ null }}">Select Type</option>
                                <option value="logo">logo</option>
                                <option value="slider">slider</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="settingDisplayResolutionForUpload" id="settingDisplayResolutionForUpload" class=" form-control" wire:model='settingDisplayResolutionForUpload'>
                                <option value="{{ null }}">Select Display Resolution</option>
                                @foreach ($display_resolutions as $item)
                                    <option value="{{ $item->id }}">{{ $item->display_resolution }}</option>
                                @endforeach
                            </select>
                            @error('settingDisplayResolutionForUpload')
                                <span class=" text-small text-danger">{{ $message }}</span>
                            @enderror

                            
                        </div>
                        {{-- <div class="col-md-2">
                            <a href="" wire:click.prevent="clearSearch" class=" btn btn-danger">Clear</a>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="" class="table table-striped table-bordered nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th>Images</th>
                                <th>Priority</th>
                                <th>action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @if ($allLogos)
                                @foreach ($allLogos as $index => $item)
                                    <tr>
                                        <td>{{ $index }}</td>
                                        <td>{{ $item->locker_id }}</td>
                                        <td>{{ $item->setting_name }}</td>
                                        <td>
                                            <?php
                                            $imageUrl = stripslashes($item->setting_value);
                                            $imageUrl = $assetsUrlForImages . $imageUrl;
                                            ?>
                                            <img src="{{ $imageUrl }}" alt="" class="assets_image">
                                        </td>
                                        <td>
                                            <div class="priority">{{ $item->priority }}</div>
                                            <div class="priority_form hide">
                                                <input type="number" class="priority_number" value="{{ $item->priority }}">
                                                <button class="btn btn-xs btn-success" onclick="savePriority(this,{{ $item->id }})">
                                                    save
                                                </button>
                                            </div>
                                            
                                        </td>
                                        <td>
                                            <button onclick="editPriority(this)"
                                                class=" btn btn-xs btn-success"><i class="fas fa-edit"></i></button>
                                            <button wire:click="deleteImage({{ $item->id }})"
                                                class=" btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach

                            @endif
                        </tbody>
                    </table>
                    {{ $allLogos->links() }}
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div>
    </div>
</div>

@section('custom_script')
    <script>
        
        function editPriority(elem){
            // let that = $(this);
            let priority = $(elem).closest('tr').find('.priority');
            let priority_form = $(elem).closest('tr').find('.priority_form');
            console.log(priority_form[0]);
            priority.hide();
            priority_form.show();
        }
        function savePriority(elem,id){
            
            let priority = $(elem).closest('tr').find('.priority');
            let priority_form = $(elem).closest('tr').find('.priority_form');
            priority.show();
            priority_form.hide();
            
            let priorityNumber = priority_form.find('.priority_number').val();

            Livewire.emit('save_priority',id,priorityNumber);
        }
        function checkRequired(){
            $imgesForUpload = $("#setting_value_img");
            $location = $("#selected_location");
            $type = $("#settingTypeForUpload");
            $display_resolution = $("#settingDisplayResolutionForUpload");
            
            if(false){
                alert("upload atleast 1 image");
                $imgesForUpload.addClass("required");
                return false;
            }
            if($location.val() == ''){
                alert("location is required");
                $location.addClass("required");
                return false;
            }
            if($type.val() == ''){
                alert("Type is required");
                $type.addClass("required");
                return false;
            }
            if($display_resolution.val() == ''){
                alert("Display Resolution is required");
                $display_resolution.addClass("required");
                return false;
            }

            Livewire.emit('image_save');
            
        }
    </script>
@endsection
