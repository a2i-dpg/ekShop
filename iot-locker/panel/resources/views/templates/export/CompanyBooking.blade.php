<table id="companyData_view" class="table w-100 nowrap no-footer" role="grid" style="margin-left: 0px; width: 1112.16px;">
    <thead>
        <tr>
            <th>#</th>
            <th>Company Name</th>
            <th>Address</th>
            <th>Contact Person Name</th>
            <th>Contact Number</th>
            <th>Email</th>
            <th>Parcel Number</th>
            <th>Customer Number</th>
            <th>Book By</th>
            <th>Booked at</th>
            <th>Collected at</th>
            <th>Date</th>
        </tr>
    </thead>


    <tbody>
        @foreach ($companyBookingData as $key => $data)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $data->company->company_name }}</td>
                <td>
                   {{ $data->company->company_address }}
                </td>
                <td>{{ $data->company->company_contact_person_name }}</td>
                <td>{{ $data->company->company_contact_person_number }}</td>
                <td>{{ $data->company->company_email }}</td>
                <td>{{ $data->parcel_no }}</td>
                <td>{{ $data->customer_no }}</td>
                <td>{{ $data->user->user_full_name }}</td>
                <td>{{ $data->booked_at }}</td>
                <td>{{ $data->collected_at }}</td>
                <td>
                    {{ date("d-m-Y", strtotime($data->created_at)) }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>