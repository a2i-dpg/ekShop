<table id="companyData_view" class="table w-100 nowrap no-footer" role="grid"
    style="margin-left: 0px; width: 1112.16px;">
    <thead>
        <tr>
            <th>#</th>
            <th>location_code</th>
            <th>location_address</th>
            <th>location_landmark</th>
            <th>box_no</th>
            <th>parcel_no</th>
            <th>customer_number</th>
            <th>company_otp</th>
            <th>rider_name</th>
            <th>rider_mobile</th>
            <th>booked_at</th>
            <th>collected_by</th>
            <th>collected_at</th>
            <th>status</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($bookings as $key => $data)
            <?php
            // $bookingStatus = '';
            // if (!is_null($data->booked_at)) {
            //     $bookingStatus = 'Booked';
            // }
            // if (!is_null($data->customer_sms_key)) {
            //     $bookingStatus = $bookingStatus . ' & SMS Sent';
            // }
            // if (!is_null($data->collected_at)) {
            //     $bookingStatus = 'Collected';
            // }
            // if ($data->is_max_pickup_time_passed) {
            //     $bookingStatus = 'Returned';
            // }
            
            $bookingStatus = '';
            if (!is_null($data->booked_at)) {
                $bookingStatus = 'Booked';
            }
            if (!is_null($data->customer_sms_key)) {
                $bookingStatus = $bookingStatus . '& SMS Sent';
            }
            if (!is_null($data->collected_at)) {
                $bookingStatus = 'Collected';
            }
            if ($data->is_max_pickup_time_passed) {
                $bookingStatus = 'Returned';
            }
            if ($data->is_max_pickup_time_passed == 0 && $data->booking_is_returned) {
                $bookingStatus = 'Returned By Agent';
            }
            ?>
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $data->locker->locker_id }}</td>
                <td>{{ $data->locker->location_address }}</td>
                <td>{{ $data->locker->location_landmark }}</td>
                <td>{{ $data->box->box_no }}</td>
                <td>{{ $data->parcel_no }}</td>
                <td>{{ $data->customer_no }}</td>
                <td>{{ $data->booking_company_otp }}</td>
                <td>{{ $data->rider->user_full_name }}</td>
                <td>{{ $data->rider->user_mobile_no }}</td>
                <td>{{ $data->booked_at }}</td>
                <td>
                    @if ($data->is_max_pickup_time_passed || $data->booking_is_returned)
                        @php
                            $rider = App\Models\Rider::where('user_id', $data->collected_by)->first();
                        @endphp
                        @if (isset($rider))
                            Rider: {{ $rider->user_full_name }}
                        @else
                            {{ $data->collected_by }}
                        @endif
                    @else
                        {{ $data->collected_by }}
                    @endif
                </td>
                <td>{{ $data->collected_at }}</td>
                <td>
                    {{ $bookingStatus }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
