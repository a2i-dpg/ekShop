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
                    </a>
                    <div class="collapse" id="sidebarDashboards">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('superAdmin.home') }}">Home</a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li>
                    <a href="#company" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Company </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="company">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('superAdmin.allCompany') }}">All Company</a>
                            </li>
                            <li>
                                <a href="{{ route('superAdmin.createCompany') }}">New Company</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#locker" data-bs-toggle="collapse">
                        <i class="dripicons-store"></i>
                        <span> Locker </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="locker">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('superAdmin.addLocker') }}">Add Locker</a>
                            </li>
                            <li>
                                <a href="{{ route('superAdmin.allLocker') }}">All Locker</a>
                            </li>
                            <li>
                                <a href="{{ route('superAdmin.createLocation') }}">Location Management</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#booking" data-bs-toggle="collapse">
                        <i class="dripicons-store"></i>
                        <span> Booking Info </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="booking">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('superAdmin.allBookingData') }}">All Booking</a>
                            </li>
                            <li>
                                <a href="{{ route('superAdmin.allBookingSms') }}">Booking SMS</a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Delivery Man --}}
                <li>
                    <a href="#sidebarCrm" data-bs-toggle="collapse">
                        <i data-feather="truck"></i>
                        <span> Delivery Man </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarCrm">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('superAdmin.allDeliveryMan') }}">Delivery Man List</a>
                            </li>
                            <li>
                                <a href="{{ route('superAdmin.addDeliveryMan') }}">Add Delivery Man</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarCrmConnect" data-bs-toggle="collapse">
                        <i data-feather="share-2"></i>
                        <span> Connect </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarCrmConnect">
                        <ul class="nav-second-level">
                            <li>
                                {{-- <a href="{{ route('superAdmin.connectDeliveryMan') }}">Agents with Riders</a> --}}
                            </li>
                            <li>
                                {{-- <a href="{{ route('superAdmin.connectAgentsWithLocations') }}">Agents with Locations</a> --}}
                            </li>
                            <hr class="hr_with_no_margin">
                            <li>
                                <a href="{{ route('agent.connectLockerWithRiders') }}">Locations with Riders</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#settings" data-bs-toggle="collapse">
                        <i data-feather="settings"></i>
                        <span> Settings </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="settings">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('superAdmin.settings') }}">All Settings</a>
                            </li>
                            <li>
                                <a href="{{ route('superAdmin.addImages') }}">Add Images</a>
                            </li>
                            <li>
                                <a href="{{ route('superAdmin.addAssets') }}">General Settings</a>
                            </li>
                            <li>
                                <a href="{{ route('superAdmin.addApiSecret') }}">Api secret</a>
                            </li>
                            <li>
                                <a href="{{ route('superAdmin.addLocalAdmin') }}">Local Admin</a>
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
