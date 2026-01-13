@include('mis.head');

<div class="header">
    @php
        use Illuminate\Support\Facades\Session;
        use App\Models\User;

        $educatorId = Session::get('emp_id');
        $profileData = User::where('emp_id', $educatorId)->first();
        $profileImage = asset('uploads/logo/user_icon.jpg');
    @endphp

    <!-- Logo -->
    <div class="header-left">
        <a href="{{ route('dashboard.mis') }}" class="logo">
            <img src="{{ asset('uploads/logo/logo.png') }}" alt="Logo">
        </a>
        <a href="{{ route('dashboard.mis') }}" class="logo logo-small">
            <img src="{{ asset('uploads/logo/logo.png') }}" alt="Logo" width="30" height="30">
        </a>
    </div>
    <!-- /Logo -->

    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fe fe-text-align-left"></i>
    </a>

    <div class="top-nav-search">
        <form>
            <input type="text" class="form-control" placeholder="Search here">
            <button class="btn" type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>

    <!-- Mobile Menu Toggle -->
    <a class="mobile_btn" id="mobile_btn">
        <i class="fa fa-bars"></i>
    </a>
    <!-- /Mobile Menu Toggle -->

    <!-- Header Right Menu -->
    <ul class="nav user-menu">
        <!-- User Menu -->
        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" src="{{ $profileImage }}" alt="User Image" width="31">
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <img src="{{ $profileImage }}" alt="User Image" class="avatar-img rounded-circle">
                    </div>
                    <div class="user-text">
                        <h6>{{ $profileData->full_name ?? '' }} </h6>
                        <p class="text-muted mb-0">Mis</p>
                    </div>
                </div>
                <form id="logout-form1" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

                <a class="dropdown-item" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form1').submit();">
                    Logout
                </a>
            </div>
        </li>
        <!-- /User Menu -->
    </ul>
    <!-- /Header Right Menu -->
</div>

<style>
    .h25 {
        height: 25px;
    }
    .subheading {
        font-size: 20px;
        color: #000;
        font-weight: 600;
    }
    .thembutton {
        background: linear-gradient(135deg, #1d3557, #6c0636);
        border: 0px;
    }
</style>
