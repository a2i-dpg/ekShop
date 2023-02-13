<table id="companyData_view" class="table w-100 nowrap no-footer" role="grid" style="margin-left: 0px; width: 1112.16px;">
    <thead>
        <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Name</th>
            <th>Address</th>
            <th>Mobile Number</th>
            <th>Email</th>
            <th>Date</th>
        </tr>
    </thead>


    <tbody>
        @foreach ($deliveryMan as $key => $data)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $data->user_name }}</td>
                <td>{{ $data->user_full_name }}</td>
                <td>
                   {{ $data->user_address }}
                </td>
                <td>{{ $data->user_mobile_no }}</td>
                <td>{{ $data->email }}</td>
                <td>
                    {{ date("d-m-Y", strtotime($data->created_at)) }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>