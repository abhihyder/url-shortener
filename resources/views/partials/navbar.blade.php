   <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
       <div class="navbar-container d-flex content">
           <div class="bookmark-wrapper d-flex align-items-center">
               <ul class="nav navbar-nav d-xl-none">
                   <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
               </ul>
           </div>
           <ul class="nav navbar-nav align-items-center ml-auto">

               <li class="nav-item d-lg-block mr-1" data-toggle="tooltip" data-placement="bottom" title="Change Theme Color"><a class="nav-link nav-link-style"><i class="ficon" data-feather="{{$auth->is_dark==1?'sun':'moon'}}"></i></a></li>
               @if($auth)

               @php
               $cached_withdrawal_request=null;
               @endphp
               @if(Cache::has('withdrawal_request'))
               @php
               $cached_withdrawal_request=Cache::get('withdrawal_request');
               @endphp
               @endif
               <li class="nav-item dropdown dropdown-notification mr-1" data-toggle="tooltip" data-placement="bottom" title="Approved Withdrawal Request">
                   <i class="ficon" data-feather="check-circle"></i>
                   @if($auth->role_id == 1)
                   @if($cached_withdrawal_request && $cached_withdrawal_request['approved_request']>0)
                   <span class="badge badge-pill badge-info badge-up">{{$cached_withdrawal_request['approved_request']}}</span>
                   @endif
                   @elseif($auth->role_id == 3)
                   @if($cached_withdrawal_request && ((isset($cached_withdrawal_request['approved_request_by_user'][$auth->id]) && $cached_withdrawal_request['approved_request_by_user'][$auth->id]>0)))
                   <span class="badge badge-pill badge-info badge-up">{{$cached_withdrawal_request['approved_request_by_user'][$auth->id]}}</span>
                   @endif
                   @endif
               </li>
               <li class="nav-item dropdown dropdown-notification mr-25" data-toggle="tooltip" data-placement="bottom" title="Pending Withdrawal Request">
                   <i class="ficon" data-feather="alert-triangle"></i>
                   @if($auth->role_id == 1)
                   @if($cached_withdrawal_request && $cached_withdrawal_request['pending_request']>0)
                   <span class="badge badge-pill badge-warning badge-up">{{$cached_withdrawal_request['pending_request']}}</span>
                   @endif
                   @elseif($auth->role_id == 3)
                   @if($cached_withdrawal_request && ((isset($cached_withdrawal_request['pending_request_by_user'][$auth->id]) && $cached_withdrawal_request['pending_request_by_user'][$auth->id]>0)))
                   <span class="badge badge-pill badge-warning badge-up">{{$cached_withdrawal_request['pending_request_by_user'][$auth->id]}}</span>
                   @endif
                   @endif
               </li>
               @endif
               <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <div class="user-nav d-sm-flex d-none">
                           @if($auth)
                           @if($auth->name)
                           <span class="user-name font-weight-bolder">{{$auth->name}}</span>
                           @endif
                           @if($auth->role)
                           <span class="user-status">{{$auth->role->name}}</span>
                           @endif
                           @endif
                       </div>
                       <span class="avatar">
                           @if($auth)
                           @if($auth->file_path)
                           <img class="round" src="{{asset('/').$auth->file_path}}" alt="avatar" height="40" width="40">
                           @else
                           <img class="round" src="{{asset('app-assets/images/avatars/default.png')}}" alt="avatar" height="40" width="40">
                           @endif
                           @else
                           <img class="round" src="{{asset('app-assets/images/avatars/default.png')}}" alt="avatar" height="40" width="40">
                           @endif
                       </span>
                   </a>
                   <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                       <a class="dropdown-item" href="{{route('user.account')}}"><i class="mr-50" data-feather="user"></i> Profile</a>
                       
                       <form method="POST" action="{{ route('logout') }}">
                           @csrf
                           <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();
                                    this.closest('form').submit();">
                               <i class="mr-50" data-feather="power"></i> Logout
                           </a>
                       </form>
                   </div>
               </li>
           </ul>
       </div>
   </nav>