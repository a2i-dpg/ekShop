<style>
    .avatar-lg {
        height: 4rem;
        width: 4rem;
    }
</style>
<div class="widget-rounded-circle card">
    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                    <i class="fe-package font-22 avatar-title text-primary"></i>
                </div>
            </div>
            <div class="col-8">
                <div class="text-end">
                    @if (isset($number))
                        @php
                            $totalBooking_formated = App\Helpers\Helper::shortNumber($number);
                        @endphp
                        <h3 class="text-dark mt-1">
                            <span style="font-size: 26px;font-weight:800">
                                <span data-plugin="counterup">{{ $totalBooking_formated['number'] }}</span>
                                {{ $totalBooking_formated['unit'] }}
                            </span>
                            <br>
                            <small class="text-muted">{{ $number }}</small>
                        </h3>
                    @else
                        <h3 class="text-dark mt-1 text-bold font-24"><span data-plugin="counterup"
                                style="font-size: 30px;font-weight:700">0</span></h3>
                    @endif
                    <p class="text-muted mb-1 text-truncate">
                        {{ $label }}
                    </p>
                </div>
            </div>
        </div> <!-- end row-->
    </div>
</div> <!-- end widget-rounded-circle-->
