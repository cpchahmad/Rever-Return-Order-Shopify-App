


<nav class="navbar navbar-default bg-primary" id="top_nav_fixed">
    <div class="navbar-header">
        <div class="decline-item ">
            <a href="{{route('home')}}">
                <img class="display-4 mt-3" src="{{asset('logos/Logo REVER.png')}}" alt="logo" width="100px">
            </a>

        </div>
        <div class="main-menu-overall">
            <ul class="nav navbar-top-links statics" status="">
                <li style="color: white"  class="" ><a class="profile-pic"
                                                       href="{{route('home')}}"> <b
                            class="hidden-xs">DASHBOARD</b></a></li>

                <li style="color: white"  class="" ><a class="profile-pic"
                                                       href="{{route('home')}}"> <b
                            class="hidden-xs">RETURN REQUESTS</b></a></li>
                <li style="color: white" class="" ><a class="profile-pic"
                                                      href="{{route('settings.home')}}"> <b
                            class="hidden-xs">SETTINGS</b></a></li>
                <li style="color: white"  class="" ><a class="profile-pic"
                                                       href="{{route('analytics')}}"> <b
                            class="hidden-xs">ANALYTICS</b></a></li>
                @php
                    $data=\Illuminate\Support\Facades\Auth::user();
                @endphp

                <button style="color: white;float: right" class="btn btn-link btn-link-primary mt-1 dropdown-toggle" id="navbar-dropdown" data-toggle="dropdown">
                    {{$data->name}}
                </button>
                <div class="dropdown" style="float:right">
                    <img class="d-none d-lg-inline rounded-circle ml-1 mt-2" width="32px" src="{{asset('images/user.png')}}" alt="MA">

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="margin-left: 70px;">
                        <a class="dropdown-item" href="{{route('customerlogout')}}">Logout</a>

                    </div>
                </div>




            </ul>
        </div>
    </div>
</nav>
