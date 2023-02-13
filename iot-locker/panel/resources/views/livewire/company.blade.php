<div>
    
    <div class="row">
        <div class="col-lg-11 mt-3 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center mb-4" style="font-size:25px;font-weight:bold">Add Company</h2>
                    @if (session('error'))
                        <div class=" alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form wire:submit.prevent="company_save">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input name='company_name' type="text" class="form-control" id="company_name" placeholder="Enter company name" value="{{ old('company_name') }}" wire:model = 'company_name'>
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
                                <input name="company_contact_person_number" type="text" class="form-control" id="company_contact_person_number" placeholder="Company contact person number" value="{{ old('company_contact_person_number') }}" wire:model = 'company_contact_person_number'>
                                @error('company_contact_person_number')
                                <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="company_email" class="form-label">Company Email</label>
                                <input name="company_email" type="email" class="form-control" id="company_email" placeholder="Company email" value="{{ old('company_email') }}" wire:model = 'company_email'>
                                @error('company_email')
                                <span class=" text-small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Add Company</button>
                    </form>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
</div>
