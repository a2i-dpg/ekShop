<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="../assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme"
                class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                    data-bs-toggle="dropdown">Geneva Kennedy</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Admin Head</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li>
                    <a href="#sidebarDashboards" data-bs-toggle="collapse">
                        <i data-feather="airplay"></i>
                        <span> Dashboards </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarDashboards">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.home') }}">Home</a>
                            </li>
                            {{-- <li>
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li> --}}
                            {{-- <li>
                                <a href="{{ route('admin.company-report') }}">Report</a>
                            </li> --}}
                            <li>
                                <a href="{{ route('agent.dashboard') }}">Agent Dashboard</a>
                            </li>
                            <li>
                                <a href="{{ route('iotLocker.dashboard') }}">Active/InActive</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarAnalysis" data-bs-toggle="collapse">
                        <i data-feather="airplay"></i>
                        <span> Analysis </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAnalysis">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.analysisBooking') }}">Booking</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.reportAnalysis') }}">Report</a>
                            </li>
                            {{-- <li>
                                <a href="{{ route('admin.analysis-locker') }}">Locker Analysis</a>
                            </li> --}}
                            {{-- <li>
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li> --}}
                            {{-- <li>
                                <a href="{{ route('admin.company-report') }}">Report</a>
                            </li> --}}
                            {{-- <li>
                                <a href="{{ route('agent.dashboard') }}">Agent Dashboard</a>
                            </li> --}}
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarBookings" data-bs-toggle="collapse">
                        <i data-feather="database"></i>
                        <span> Bookings </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBookings">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('agent.exportImportBooking') }}">
                                    
                                    <span> Export-Import Booking </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.company-report') }}">Report</a>
                            </li>
                            <li>
                                <a href="{{ route('agent.allBookingSms') }}">Booking SMS</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarCrmAgent" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> User </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarCrmAgent">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.addAgent') }}">Add User</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.allAgent') }}">Agent List</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.allAdmin') }}">Admin List</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarCrm" data-bs-toggle="collapse">
                        <i data-feather="truck"></i>
                        <span> Delivery Man </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarCrm">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.allDeliveryMan') }}">Delivery Man List</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.addDeliveryMan') }}">Add Delivery Man</a>
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
                {{-- <li>
                    <a href="#sidebarCrmbook" data-bs-toggle="collapse">
                        <i data-feather="calendar"></i>
                        <span> Booking List </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarCrmbook">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.allBooking') }}">All Booking</a>
                            </li>
                            
                        </ul>
                    </div>
                </li> --}}
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
