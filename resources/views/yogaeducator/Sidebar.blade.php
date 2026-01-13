<div class="sidebar" id="sidebar">
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: 100%; height: 593px;">
        <div class="sidebar-inner slimscroll" style="overflow: hidden; width: 100%; height: 593px; overflow-y: scroll;">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>

                    <li>
                        <a href="{{ route('dashboard.yogaeducator') }}">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>



                    <li>
                        <a href="{{ route('yoga.patientlist') }}">
                            <i class="fa fa-list-ol" aria-hidden="true"></i>
                            <span>Patient List</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('yoga.changepassword') }}">
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

        <!-- Optional slimScrollBar elements if used by JS -->
        <div class="slimScrollBar" style="background: rgb(204, 204, 204); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 325.903px;"></div>
        <div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
    </div>
</div>
