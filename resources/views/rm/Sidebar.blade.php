<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll" style="overflow-y: scroll; width: 100%; height: 593px;">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('dashboard.rm') }}">
                        <i class="fa fa-home"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('rm.analytics') }}">
                        <i class="fa fa-user"></i> <span>Analytics</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('rm.patientlist') }}">
                        <i class="fa fa-ticket"></i> <span>Patient Approval List</span>
                    </a>
                </li>

                <li>
                        <a href="{{route('rm.change-password') }}">
                            <i class="fa fa-key"></i>
                            <span>Change Password</span>
                        </a>
                    </li>

                    <li>
                        <form id="logout-form" action="{{ route('rmlogout') }}" method="POST" style="display: none;">
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
