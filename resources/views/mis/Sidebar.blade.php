<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ url('dashboard/mis') }}">
                        <i class="fa fa-home"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="submenu">
                    <a href="#">
                        <span> ADD/DELETE </span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="display: none;">
                        <li><a href="{{ url('mis-Create-Educator') }}">EDUCATOR</a></li>
                        <li><a href="{{ url('mis-Create-RM') }}">RM</a></li>
                        <li><a href="{{ url('mis-Create-Doctor') }}">HCP</a></li>
                        <li><a href="{{ url('mis-Create-DigitalEducator') }}">Digital Educator</a></li>
                        <li><a href="{{ url('mis-medicine') }}"> Medicine</a></li>
                        <li><a href="{{ url('mis-compitetor') }}"> Compitetor</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#">
                        <span> Assign </span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="display: none;">
                        <li><a href="{{ url('mis-Assign-EDUCATOR') }}">EDUCATOR</a></li>
                        <li><a href="{{ url('mis-Assign-HCP') }}">HCP</a></li>
                        <li><a href="{{ url('mis-Assign-DM') }}">Patient to Digital Educator</a></li>
                        <li><a href="{{ url('mis-Assign-digital-educator-RM') }}">Digital Educator to RM</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url('mis-Analytics') }}"><i class="fa-solid fa-chart-simple"></i>
                        <span>Analytics</span></a>
                </li>
                <li>
                    <a href="{{ url('mis-Patient-List') }}">
                        <i class="fa fa-user"></i> <span>Feedbacks</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('mis-campreport') }}">
                        <i class="fa fa-ticket"></i> <span>Camp Report</span>
                    </a>
                </li>
                <li>
                        <a href="{{ url('mis-feedbackreport') }}"><i class="fa-solid fa-file-excel"></i> <span>Feedback
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
