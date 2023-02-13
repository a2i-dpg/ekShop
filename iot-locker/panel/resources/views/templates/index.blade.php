@extends('master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">

                </div>
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Box Data grid -->
    <div class="row">
        <div class="col-md-12 col-xl-12">
            @livewire('box-grid')
        </div> <!-- end col -->
    </div>
    <!-- end row -->

    <!-- Company booking data list -->
    <div class="row p-4 mb-3" style=" background:#fff;border-radius:10px">
        <div class="col-xl-6 mx-auto">
            @livewire('company-booking-lists')
        </div>
        <div class="col-xl-6 mx-auto">
            @livewire('customer-report')
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@section('custom_script')
    {{-- <script>
        let box = $('#company_parcel_count').DataTable({
        responsive:true,
        "lengthMenu": [[5,10,15,20, 25, 50, -1], [5,10,15,20, 25, 50, "All"]],
        "bFilter": true,  
        lengthChange: true,
        // buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
        buttons: [
            'copy', 'excel', 'pdf'
        ]
    })  
    box.buttons().container()
        .appendTo( '#booking_count_wrap .col-md-6:eq(0)' );  
    </script> --}}
@endsection
