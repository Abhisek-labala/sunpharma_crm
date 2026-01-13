<div class="sidebar" id="sidebar">
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: 100%; height: 593px;">
        <div class="sidebar-inner slimscroll" style="overflow: hidden; width: 100%; height: 593px; overflow-y: scroll;">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li>
                        <a href="{{ url('/counsellor/dashboard') }}">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/counsellor/analytics') }}">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>Analytics</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('educator.attendance.index') }}">
                            <i class="fa fa-ticket" aria-hidden="true"></i>
                            <span>Attendance</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('campinfo') }}">
                            <i class="fa-solid fa-snowflake"></i>
                            <span>Camp</span>
                        </a>
                    </li>


                    <li>
                        <a href="{{ url('/counsellor/patientinfo') }}">
                            <i class="fa-solid fa-circle-info"></i>
                            <span>Patient Information</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('counsellor/PatientList') }}">
                            <i class="fa fa-list-ol" aria-hidden="true"></i>
                            <span>Patient List</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/counsellor/change-password') }}">
                            <i class="fa fa-key"></i>
                            <span>Change Password</span>
                        </a>
                    </li>

                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            <span>Logout</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        {{-- SlimScroll elements (optional or include via JS plugin) --}}
    </div>
</div>
