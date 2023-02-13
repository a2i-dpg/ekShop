<table id="companyData_view" class="table w-100 nowrap no-footer" role="grid" style="margin-left: 0px; width: 1112.16px;">
    <thead>
        <tr>
            <th>#</th>
            <th>Company Name</th>
            <th>Address</th>
            <th>Contact Person</th>
            <th>Contact Number</th>
            <th>Email</th>
        </tr>
    </thead>


    <tbody>
        @foreach ($companyData as $key => $data)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $data->company_name }}</td>
                <td>
                   {{ $data->company_address }}
                </td>
                <td>{{ $data->company_contact_person_name }}</td>
                <td>{{ $data->company_contact_person_number }}</td>
                <td>{{ $data->company_email }}</td>
            </tr>
        @endforeach
    </tbody>
</table>