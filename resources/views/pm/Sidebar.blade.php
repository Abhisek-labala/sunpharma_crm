<div class="sidebar" id="sidebar">
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: 100%; height: 593px;">
        <div class="sidebar-inner slimscroll" style="overflow: hidden; width: 100%; height: 593px;overflow-y: scroll;">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li>
                        <a href="{{ url('dashboard/pm') }}"><i class="fa fa-home"></i> <span>Dashboard</span></a>
                    </li>

                    <li class="submenu">-
                        <a href="#"> <span> ADD/DELETE </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{ url('Pm-Create-Educator') }}">EDUCATOR</a></li>
                            <li><a href="{{ url('Pm-Create-Hcp') }}">HCP</a></li>
                            <li><a href="{{ url('Pm-Create-RM') }}">RM</a></li>
                            <li><a href="{{ url('Pm-Create-DigitalEducator') }}"> Digital Educator</a></li>
                            <li><a href="{{ url('Pm-medicine') }}"> Medicine</a></li>
                            <li><a href="{{ url('Pm-compitetor') }}"> Compitetor</a></li>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"> <span> Assign </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{ url('PM-Assign-EDUCATOR') }}">EDUCATOR</a></li>
                            <li><a href="{{ url('PM-Assign-HCP') }}">HCP</a></li>
                            <li><a href="{{ url('PM-Assign-DM') }}"> Patient to Digital Educator</a></li>
                            <li><a href="{{ url('PM-Assign-digital-educator-RM') }}">Digital Educator to RM</a></li>


                        </ul>
                    </li>

                    <li>
                        <a href="{{ url('pm-Analytics') }}"><i class="fa-solid fa-chart-simple"></i>
                            <span>Analytics</span></a>
                    </li>
                    <li>
                        <a href="{{ url('pm-Patient-List') }}"><i class="fa fa-user"></i> <span>Feedbacks</span></a>
                    </li>
                    <li>
                        <a href="{{ url('pm-campreport') }}"><i class="fa fa-ticket"></i> <span>Camp Report</span></a>
                    </li>
                    <li>
                        <a href="{{ url('pm-feedbackreport') }}"><i class="fa-solid fa-file-excel"></i> <span>Feedback
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
        <div class="slimScrollBar"
            style="background: rgb(204, 204, 204); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 325.903px;">
        </div>
        <div class="slimScrollRail"
            style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;">
        </div>
    </div>
</div>
