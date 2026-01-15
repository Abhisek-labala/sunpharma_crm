<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ url('dashboard/admin') }}">
                        <i class="fa fa-home"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="submenu">
                    <a href="#">
                        <span> ADD/DELETE </span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="display: none;">
                        <li><a href="{{ url('admin-Create-Counsellor') }}">Counsellor</a></li>
                        <li><a href="{{ url('admin-Create-RC') }}">RC</a></li>
                        <li><a href="{{ url('admin-Create-Doctor') }}">Doctor</a></li>
                        <li><a href="{{ url('admin-Create-DigitalCounsellor') }}">Digital Counsellor</a></li>
                        <li><a href="{{ url('admin-medicine') }}"> Medicine</a></li>
                        <li><a href="{{ url('admin-compitetor') }}"> Compitetor</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#">
                        <span> Assign </span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="display: none;">
                        <li><a href="{{ url('admin-Assign-EDUCATOR') }}">Counsellor</a></li>
                        <li><a href="{{ url('admin-Assign-HCP') }}">Doctor</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url('admin-Analytics') }}"><i class="fa-solid fa-chart-simple"></i>
                        <span>Analytics</span></a>
                </li>
                <li>
                    <a href="{{ url('admin-Patient-List') }}">
                        <i class="fa fa-user"></i> <span>Feedbacks</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('admin-campreport') }}">
                        <i class="fa fa-ticket"></i> <span>Camp Report</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/attendance-report') }}">
                        <i class="fa fa-calendar-check-o"></i> <span>Attendance Report</span>
                    </a>
                </li>
                <li>
                        <a href="{{ url('admin-feedbackreport') }}"><i class="fa-solid fa-file-excel"></i> <span>Feedback
                                Report</span></a>
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
</div>
