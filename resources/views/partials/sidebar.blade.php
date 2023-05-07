<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{route('home') }}">

                    <img style="max-width:120px;" src="{{ asset('app-assets/images/logo/logo.png')}}" alt="Logo">
                    <!-- <h2 class="brand-text">{{config('app.name')}}</h2> -->
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <br>
            @if($auth)
            @if($auth->role_id == 1)
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{route('admin.dashboard') }}"><i data-feather='home'></i><span class="menu-title text-truncate" data-i18n="Email">Dashboard</span></a>
            </li>
            @endif
            @endif
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{route('shorten-url.index') }}"><i data-feather='link'></i><span class="menu-title text-truncate" data-i18n="Email">Shorten URL</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{route('user.statistics')}}"><i data-feather='trending-up'></i><span class="menu-title text-truncate" data-i18n="Chat">{{$auth->role_id == 1?'My':''}} Statistics</span></a>
            </li>
            @if($auth)
            @if($auth->role_id == 1)
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{route('admin.setting.index')}}"><i data-feather='tool'></i><span class="menu-title text-truncate" data-i18n="Invoice">Settings</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather='user-check'></i><span class="menu-title text-truncate" data-i18n="Invoice">Manage User</a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="{{route('admin.user.index')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">User List</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="{{route('admin.user.create')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Add User</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{route('admin.payment-method.index')}}"><i data-feather='framer'></i><span class="menu-title text-truncate" data-i18n="Invoice">Payment Methods</a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather='dollar-sign'></i><span class="menu-title text-truncate" data-i18n="Invoice">Withdrawal</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="{{route('admin.withdrawal-request.index')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">All Request</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="{{route('admin.withdrawal-request.pending')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Pending Request</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="{{route('admin.withdrawal-request.approved')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Approved Request</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="{{route('admin.withdrawal-request.complete')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Complete Request</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="{{route('admin.withdrawal-request.cancelled')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Cancelled Request</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="{{route('admin.withdrawal-request.returned')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Returned Request</span></a>
                    </li>
                </ul>
            </li>
            @endif
            @if($auth->role_id == 2)
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather='dollar-sign'></i><span class="menu-title text-truncate" data-i18n="Invoice">Withdrawal</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="{{route('moderator.withdrawal-request.index')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">All Request</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="{{route('moderator.withdrawal-request.pending')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Pending Request</span></a>
                    </li>

                </ul>
            </li>
            @endif
         
            <li class=" nav-item"><a class="d-flex align-items-center" href="javascript:;"><i data-feather='users'></i><span class="menu-title text-truncate" data-i18n="Calendar">Referrals</span></a>
            <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="{{route('referral.index')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Referrer</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="{{route('referral.earning')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List"> Earnings</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="{{route('banner.index')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List"> Referral Banner</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather='user'></i><span class="menu-title text-truncate" data-i18n="Invoice">Profile</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="{{route('user.account')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Account</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="{{route('withdrawal-request.index')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Withdrawal Request</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="{{route('withdrawal-method.index')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Withdrawal Methods</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="{{route('withdrawal-method.create')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Add Methods</span></a>
                    </li>
                </ul>
            </li>
            @endif
        </ul>
    </div>
</div>