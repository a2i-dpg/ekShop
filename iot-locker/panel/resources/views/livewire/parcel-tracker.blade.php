<div>

    <style>
        @import url("https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600&display=swap");

        *,
        *::after,
        *::before {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        :root {
            --event-container-height: 8rem;
        }
        html {
            /* font-size: 62.5%; */
        }

        /* body {
            color: #2c3e50;
            font-family: 'Montserrat', sans-serif;
            width: 40rem;
            font-weight: 300;
            min-height: 100vh;
            position: relative;
            display: block;
            margin: 2rem auto;
        } */

        h2,
        h4,
        h6 {
            margin: 0;
            padding: 0;
            display: inline-block;
        }

        .root {
            padding: 1rem;
            border-radius: 5px;
            box-shadow: 0 2rem 6rem rgba(0, 0, 0, 0.3);
        }

        figure {
            display: flex;
        }

        figure img {
            width: 8rem;
            height: 8rem;
            border-radius: 15%;
            border: 1.5px solid #f05a00;
            margin-right: 1.5rem;
            padding: 1rem;
        }

        figure figcaption {
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
        }

        figure figcaption h4 {
            font-size: 1.4rem;
            font-weight: 500;
        }

        figure figcaption h6 {
            font-size: 1rem;
            font-weight: 300;
        }

        figure figcaption h2 {
            font-size: 1.6rem;
            font-weight: 500;
        }

        .order-track {
            margin-top: 2rem;
            padding: 0 1rem;
            border-top: 1px dashed #2c3e50;
            padding-top: 2.5rem;
            display: flex;
            flex-direction: column;
            height: 40vh;
            overflow: auto;
        }

        .order-track-step {
            display: flex;
            height: var(--event-container-height);
        }

        .order-track-step:last-child {
            /* overflow: hidden; */
            /* height: 4rem; */
        }

        .order-track-step:last-child .order-track-status span:last-of-type {
            display: none;
        }

        .order-track-status {
            margin-right: 1.5rem;
            position: relative;
        }

        .order-track-status-dot {
            display: block;
            width: 2.2rem;
            height: 2.2rem;
            border-radius: 50%;
            background: #f05a00;
        }

        .order-track-status-line {
            display: block;
            margin: 0 auto;
            width: 2px;
            height: var(--event-container-height);
            background: #f05a00;
        }

        
        .order-track-text-stat {
            font-size: 1.3rem;
            font-weight: 500;
            margin-bottom: 0px;
        }

        .order-track-text-sub {
            font-size: 1rem;
            font-weight: 300;
        }

        .order-track {
            transition: all .3s height 0.3s;
            transform-origin: top center;
        }

        .bold {
            font-weight: bold;
        }

        .search_container {
            padding: 20px;
            
        }

        .search_result .card{
            box-shadow: 1px 1px 1px 1px #000000 inset;
        }

        .search_result .card-body {
            height: 100px;
            overflow-y: auto;
            padding: 0.5rem 1rem;
        }

        .search_result ul {
            padding-left: 0rem;
        }

        .search_result ul li {
            padding: 10px 0;
            list-style: none;
            border-bottom: 1px #00000014 solid;
            cursor: pointer;
        }

        .search_result ul li:hover {
            background-color: #00000014;
        }

        .search_result ul .active {
            background-color: #00000014;
        }


        /*  */

        /* Scrollbar Styling */
        .order-track::-webkit-scrollbar {
            width: 10px;
        }

        .order-track::-webkit-scrollbar-track {
            background-color: #ebebeb;
            -webkit-border-radius: 10px;
            border-radius: 10px;
        }

        .order-track::-webkit-scrollbar-thumb {
            -webkit-border-radius: 10px;
            border-radius: 10px;
            background: #6d6d6d;
        }

        .search_result::-webkit-scrollbar {
            width: 6px;
        }

        .search_result::-webkit-scrollbar-track {
            background-color: #ebebeb;
            -webkit-border-radius: 10px;
            border-radius: 10px;
        }

        .search_result::-webkit-scrollbar-thumb {
            -webkit-border-radius: 10px;
            border-radius: 10px;
            background: #ffe53c;
        }

        @media only screen and (max-width: 600px) {
            figure img {
                width: 4rem;
                height: 4rem;
                padding: 0.5rem;
            }

            figure {
                flex-direction: column;
            }

            figure figcaption h2 {
                font-size: 1rem;
                font-weight: 800;
            }

            h2,
            h3,
            h4,
            h5,
            h6 {
                margin-bottom: 2px;
            }

            .order-track-status-dot {
                width: 1rem;
                height: 1rem;
            }

            .order-track p,
            span {
                font-size: 14px;
            }

            .order-track-text-sub {
                font-size: 14px;
            }
        }
    </style>


    <div class="search_container">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{-- <label for="exampleInputEmail1">Email address</label> --}}
                    <input type="text" class="form-control" wire:model="parcel_no" placeholder="XXX-XXX-XXXXXXXXXX">
                    <small class="form-text text-muted">Search by Parcel by Full / Last 6 Digits.</small>
                    <br>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{-- <label for="exampleInputEmail1">Email address</label> --}}
                    <input type="text" class="form-control" wire:model="mobile_no" placeholder="01685XXXXXX">
                    <small class="form-text text-muted">Search by Mobile Number.</small>
                    <br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @isset($bookings)
                    <span class="form-text text-muted">Search Result: <strong>({{ count($bookings) }})</strong></span>
                @endisset
            </div>
        </div>

        @if ($bookings != null && count($bookings) > 1)
            <div class="search_result">
                <div class="card">
                    <div class="card-body">
                        <ul>
                            @foreach ($bookings as $item)
                                <li wire:click="trackParcel('{{ $item->parcel_no }}')"
                                    class="{{ $trackedParcel == $item->parcel_no ? 'active' : '' }}">
                                    # {{ $item->parcel_no }}
                                    <br>
                                    <small class="text-muted">

                                        {{date('d-M-Y (h:i A) ', strtotime($item->booked_at))}}
                                        {{-- {{ $item->created_at->format('d-M-Y (h:i A) ') }} --}}
                                    </small>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

    </div>


    @if (isset($trackedParcel))
        <div class="row m-2">
            <div class="col-md-12">
                <section class="root">
                    @if (isset($parcel_no))
                        @if (isset($selectedBooking))
                            <figure>
                                <img src="{{ asset('') }}assets/images/parcel place holder.png" alt="">
                                <figcaption>
                                    <h4>Tracking Details</h4>
                                    <h6><strong>Locker:</strong> {{ $selectedBooking->locker->locker_code }}</h6>
                                    <h6><strong>Box:</strong> {{ $selectedBooking->box->box_no }}</h6>
                                    <h2># {{ $selectedBooking->parcel_no }}</h2>
                                </figcaption>
                            </figure>
                            <div class="order-track">
                                @isset($eventLogs)
                                    @foreach ($eventLogs as $item)
                                        @php
                                            $loggedUser = null;
                                            
                                            //get Logged User
                                            $loggedUser = App\Models\Rider::where('user_id', $item->created_by)->first();
                                            $userLabel = 'Rider:';
                                            if (is_null($loggedUser)) {
                                                $loggedUser = App\Models\User::where('user_id', $item->created_by)->first();
                                                $userLabel = 'User:'; //Agent/Admin
                                            }
                                        @endphp
                                        <div class="order-track-step">
                                            <div class="order-track-status">
                                                <span class="order-track-status-dot"></span>
                                                <span class="order-track-status-line"></span>
                                            </div>
                                            <div class="order-track-text">
                                                <p class="order-track-text-stat">
                                                    {{-- {{ str_replace('_', ' ', $item->log_event_subcategory) }} --}}
                                                    <strong>Event: </strong>
                                                    @php
                                                        $logEvent = trim(str_replace('<strong>','',$item->log_event_description));
                                                        $logEvent = trim(str_replace('</strong>','',$logEvent));
                                                        $logEvent = trim(str_replace('<b>','',$logEvent));
                                                        $logEvent = trim(str_replace('</b>','',$logEvent));
                                                        $logEvent = trim(str_replace('<br>','',$logEvent));
                                                    @endphp
                                                    {{$logEvent}}
                                                    
                                                </p>
                                                <p class="order-track-text-stat ">
                                                    @if (!is_null($loggedUser))
                                                        <strong>
                                                            {{ $userLabel }}
                                                        </strong>
                                                        <span class="">{{ $loggedUser->user_full_name }}</span>
                                                        ({{ $loggedUser->user_mobile_no }})
                                                        <br>
                                                    @else
                                                        {{ $item->created_by }}:
                                                        @php
                                                            $logDetails = json_decode($item->log_details);
                                                            // dd($logDetails->contact_no);
                                                        @endphp
                                                        {{ isset($logDetails->contact_no) ? $logDetails->contact_no : 'N/A' }}
                                                        {{-- @if (!is_null($customer_contact_no))
                                                            ({{ $customer_contact_no }})
                                                        @endif --}}
                                                    @endif
                                                </p>
                                                <span class="order-track-text-sub">
                                                    {{-- 1st November, 2019 --}}
                                                    <strong style="font-weight: 500">Time: </strong> {{ $item->created_at->toDayDateTimeString() }}
                                                </span>
                                            </div>
                                            
                                        </div>
                                        
                                    @endforeach
                                @endisset
                            </div>
                        @else
                            <p>Parcel Not Found</p>
                        @endif
                    @else
                        <p>Input Any Parcel No</p>
                    @endif

                </section>
            </div>
        </div>
    @else
        <p>Select Any Parcel</p>
    @endif

    <script>
        $(document).ready(function() {
            // console.log("ready");
            // $("body").children().each(function() {
            //     $(this).html($(this).html().replace(/@/g, "$"));
            // });
        });
    </script>
</div>
