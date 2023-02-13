<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li>
                    <a href="{{ route('agent.dashboard') }}">
                        <i data-feather="airplay"></i>
                        <span> Dashboards </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('agent.connectLockerWithRiders') }}">
                        <i data-feather="users"></i>
                        <span> Connect </span>
                    </a>
                </li>

                <li>
                    <a href="#sidebarDashboards" data-bs-toggle="collapse">
                        <i data-feather="database"></i>
                        <span> Bookings </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarDashboards">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('agent.exportImportBooking') }}">
                                    
                                    <span> Export-Import Booking </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('agent.company-report') }}">Report</a>
                            </li>
                            <li>
                                <a href="{{ route('agent.allBookingSms') }}">Booking SMS</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="{{ route('parcelTracker') }}">
                        <i data-feather="package"></i>
                        <span> Parcel History </span>
                    </a>
                </li>
                

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
