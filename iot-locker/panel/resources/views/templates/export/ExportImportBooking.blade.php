<table id="companyData_view" class="table w-100 nowrap no-footer" role="grid"
    style="margin-left: 0px; width: 1112.16px;">
    <thead>
        <tr>
            <th>#</th>
            <th>parcel_number</th>
            <th>customer_number</th>
            <th>rider</th>
            <th>rider_mobile</th>
            <th>booked_at</th>
            <th>collected_at</th>
            <th>sync_date</th>
        </tr>
    </thead>


    <tbody>
        @foreach ($companyBookingDataFromSession as $key => $data)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $data->parcel_no }}</td>
                <td>{{ $data->customer_no }}</td>
                <td>{{ $data->rider->user_full_name }}</td>
                <td>{{ $data->rider->user_mobile_no }}</td>
                <td>{{ $data->booked_at }}</td>
                <td>{{ $data->collected_at }}</td>
                <td>
                    {{ date('d-m-Y', strtotime($data->created_at)) }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
