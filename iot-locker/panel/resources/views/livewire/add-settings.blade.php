<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Setting</a></li>
                        <li class="breadcrumb-item active">Add Setting</li>
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
        <div class="col-lg-6 mt-3 mx-auto">
            <div class="card">
                
                <div class="card-body">
                   
                    <h2 class="text-center mb-4" style="font-size:25px;font-weight:bold">Add Setting</h2>
                    
                    <form wire:submit.prevent="settings_save">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="setting_name" class="form-label">Setting Name</label>
                                <select name='setting_name' class="form-control" id="setting_name" placeholder="Enter setting name" wire:click="getSettings($event.target.value)" wire:model = 'setting_name'>
                                    <option>Please Select</option>
                                    <option value='logo'>Logo</option>
                                    <option value='slider'>Slider</option>
                                    <option value='admin_secret'>Admin Secret Key</option>
                                    <option value='max_pick_time'>Maximum Pickup Time</option>
                                    <option value="appKey">App Key</option>
                                </select>
                                @error('setting_name')
                                    <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($showDivimg)
                            @if ($setting_value_img)
                                <div class="row">
                                    @foreach ($setting_value_img as $images)
                                    <div class="col-3 card me-1 mb-1">
                                        <img src="{{ $images->temporaryUrl() }}">
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="mb-3 col-md-12" id="setting_value_img">
                                <label for="setting_value" class="form-label">Upload Images</label>
                                <input name="setting_value_img" type="file" class="form-control"  value="{{ old('setting_value_img') }}" wire:model = 'setting_value_img' multiple>
                                @error('setting_value_img')
                                <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            @endif
                            @if ($showDiv)
                            <div class="mb-3 col-md-12" id="setting_value_content">
                                <label for="setting_value" class="form-label">Content</label>
                                <input name="setting_value" type="text" class="form-control"  placeholder="Enter Content" value="{{ old('setting_value') }}" wire:model = 'setting_value'>
                                @error('setting_value')
                                <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>  
                            @endif
                            <div class="mb-3 col-md-12">
                                <label>Select locker (optional)</label>
                                <select name="locker_id" id="" class=" form-control" wire:model = 'locker_id'>
                                    <option value="" >Please Select</option>
                                    @foreach ($allLocker as $item)
                                        <option value="{{ $item->locker_id }}">{{ $item->locker_id }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Add Setting</button>
                    </form>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
</div>
