<div>
    <div class="row">
        <div class="col-lg-11 mt-3 mx-auto">

            <div class="card">
                <div class="card-header">
                    <div class="button__list d-flex align-items-center justify-content-center gap-3">
                        <div class="button_link">
                            <button wire:click.prevent='showDivision()'
                                class=" btn @if ($showdivision) btn-success @else btn-info @endif">Add
                                Division</button>
                        </div>
                        <div class="button_link">
                            <button wire:click.prevent='showDistrict()'
                                class=" btn @if ($showdistrict) btn-success @else btn-info @endif">Add
                                District</button>
                        </div>
                        <div class="button_link">
                            <button wire:click.prevent='showUpazila()'
                                class=" btn @if ($showUpazila) btn-success @else btn-info @endif">Add
                                Upazila</button>
                        </div>
                        <div class="button_link">
                            <button wire:click.prevent='showUnion()'
                                class=" btn @if ($showUnion) btn-success @else btn-info @endif">Add
                                Union</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            @if ($showdivision)
                                <div class="division row">
                                    <div class="col-md-12 mb-4">
                                        <select name="" id="division_select" class=" form-control">
                                            <option selected value="">Division Lists</option>
                                            @foreach ($division as $item)
                                                <option>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <form wire:submit.prevent="division_add">
                                            <div class="mb-3 col-md-12">
                                                <input type="text" name="div_name" wire:model='div_name'
                                                    class="form-control" placeholder="Type division name">
                                                @error('div_name')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-primary">Add Division</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            @if ($showdistrict)
                                <div class="district row">
                                    <div class="col-md-12">
                                        <form wire:submit.prevent="district_add">
                                            <div class="row">
                                                <div class="col-md-12 mb-4">
                                                    <select name="div_id" id="" class=" form-control"
                                                        wire:model='div_id'>
                                                        <option selected>Select Division</option>
                                                        @foreach ($division as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('div_id')
                                                        <span class=" text-danger text-sm">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3 col-md-12">
                                                        <input type="text" name="dis_name" wire:model='dis_name'
                                                            class="form-control" placeholder="Type district name">
                                                        @error('dis_name')
                                                            <span class=" text-danger text-sm">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Add District</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            @endif
                            @if ($showUpazila)
                                <div class="district row">
                                    <div class="col-md-12">
                                        <form wire:submit.prevent="upazila_add">
                                            <div class="row">
                                                <div class="col-md-12 mb-4">
                                                    <select name="dis_id" id="" class=" form-control"
                                                        wire:model='dis_id'>
                                                        <option selected>Select District</option>
                                                        @foreach ($district as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('dis_id')
                                                        <span class=" text-danger text-sm">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3 col-md-12">
                                                        <input type="text" name="upazila_name"
                                                            wire:model='upazila_name' class="form-control"
                                                            placeholder="Type Upazila name">
                                                        @error('upazila_name')
                                                            <span class=" text-danger text-sm">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Add Upazila</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            @endif
                            @if ($showUnion)
                                <div class="district row">
                                    <div class="col-md-12">
                                        <form wire:submit.prevent="union_add">
                                            <div class="row">
                                                <div class="col-md-12 mb-4">
                                                    <select name="upazilla_id" id="" class=" form-control"
                                                        wire:model='upazilla_id'>
                                                        <option selected>Select Upazila</option>
                                                        @foreach ($upazila as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('upazilla_id')
                                                        <span class=" text-danger text-sm">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3 col-md-12">
                                                        <input type="text" name="uni_name" wire:model='uni_name'
                                                            class="form-control" placeholder="Type Union name">
                                                        @error('uni_name')
                                                            <span class=" text-danger text-sm">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Add Union</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div> <!-- end card -->
        </div>
    </div>
</div>
