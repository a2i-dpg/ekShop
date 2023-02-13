<table class="table table-striped table-bordered" style="width: 100%">
    <style>
        thead th{
            color: #fff;
        }
    </style>
    <thead style="background:#111">
        <tr>
            <th>#</th>
            <th>Company</th>
            <th>Booking ID</th>
            <th>Location</th>
            <th>Box No</th>
            <th>Parcel No</th>
            <th>Customer Mobile</th>
            <th>Booked By</th>
            <th>Booked Time</th>
        </tr>
    </thead>


    <tbody>
        @foreach ($bookingData as $key => $data)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $data->company->company_name }}</td>
                <td>
                    {{ $data->booking_id }}
                </td>
                <td>{{ $data->locker->location_address }}</td>
                <td>
                    {{ $data->box->box_no }}
                </td>
                <td>{{ $data->parcel_no }}</td>
                <td>{{ $data->customer_no }}</td>
                <td>{{ $data->user->user_full_name }}</td>
                <td>{{ $data->booked_at }}</td>
            </tr>  
        @endforeach
    </tbody>
</table>