<div>
    <div class="row">
        <div class="col-lg-11 mt-3 mx-auto">
            <div class="card add_locker">
                <div class="card-body">
                    <h2 class="text-center mb-4" style="font-size:25px;font-weight:bold">Add Locker</h2>

                    <form wire:submit.prevent="locker_save" method="POST">
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
                                    placeholder="Locker Code" value="{{ old('locker_code') }}" wire:model='locker_code' readonly>
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
                                    wire:model='extra_code' required>

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
                                <label for="locker_landmark" class="form-label">Locker Landmark
                                    (<small>Optional</small>)</label>
                                <input name='locker_landmark' type="text" class="form-control"
                                    id="locker_landmark" placeholder="Locker Landmark"
                                    value="{{ old('locker_landmark') }}" wire:model='locker_landmark'>
                                @error('locker_landmark')
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
                        </div>

                        <button class="btn btn-primary" type="submit">Add Locker</button>
                    </form>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
</div>

@section('custom_script')
    <script>
        $(document).ready(function() {
            // $('#selectedCountryID option:contains("Bangladesh")').prop('selected', true);
        });
        // $(document).ready(function () {
        //     window.initSelectCompanyDrop=()=>{
        //         $('#division_id').select2({
        //             placeholder: 'Select a Division',
        //             allowClear: true
        //         });
        //     }

        //     $('#division_id').on('change', function (e) {
        //         livewire.emit('findDistrict', e.target.value)
        //     });

        //     initSelectCompanyDrop();

        //     window.livewire.on('select2',()=>{
        //         initSelectCompanyDrop();
        //     });


        // });

        // $('#division_id').select(function () { 
        //     @this.findDistrict(1);
        // });





        // document.addEventListener('livewire:load', function() {
        //     // Call the livewire increment method in javascript
        //     // $('#division_id').select2();
        //     @this.findDistrict(1);
        // })
    </script>
@endsection
