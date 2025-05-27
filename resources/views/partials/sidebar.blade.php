    <!--  BEGIN SIDEBAR  -->
    <div class="sidebar-wrapper sidebar-theme">

        <nav id="sidebar">

            <div class="navbar-nav theme-brand flex-row  text-center">
                <div class="nav-logo" style="margin-left: 0.2rem">
                    <div class="nav-item theme-logo" style="font-size: 1.6rem !important;">
                        {{-- <img src="{{ asset('src/default-logo.png') }}" class="navbar-logo" alt="logo"> --}}
                        <a href="{{ route('dashboard') }}">

                            {{-- <img src="{{ asset('src/default-logo.png') }}" class="navbar-logo" alt="logo"> --}}
                            <img src="{{ asset('/src/assets/img/prometeon-icon.png') }}" class="navbar-logo"
                                alt="logo">
                                <span class="mobile-hidden-xs">rometeon</span>
                    </div>
                    <div class="nav-item theme-text">
                        <a href="{{ route('dashboard') }}" class="nav-link"></a>
                    </div>
                </div>
                <div class="nav-item sidebar-toggle">
                    <div class="btn-toggle sidebarCollapse" id="sidebar-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevrons-left">
                            <polyline points="11 17 6 12 11 7"></polyline>
                            <polyline points="18 17 13 12 18 7"></polyline>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="shadow-bottom"></div>
            <ul class="list-unstyled menu-categories" id="accordionExample">

                @php
                    $currentRoute = Route::currentRouteName();
                    $isActive = in_array($currentRoute, ['dashboard']);
                @endphp
                <li class="menu {{ $isActive ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            <span>Dashboard</span>
                        </div>
                    </a>
                </li>

                @foreach ($menus as $menu)
                    @php
                        $currentRoute = Route::currentRouteName();
                        $currentRouteBase = explode('.', $currentRoute)[0];
                        $isActive = $currentRouteBase == $menu->route;
                    @endphp
                    <li class="menu {{ $isActive ? 'active' : '' }}">
                        <a href="#menu_{{ $menu->id }}" data-bs-toggle="collapse" aria-expanded="true"
                            class="dropdown-toggle">
                            <div class="">
                                {!! $menu->svg_content !!}
                                <span style="font-size: smaller">{{ $menu->name }}</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="menu_{{ $menu->id }}"
                            data-bs-parent="#accordionExample">
                            @foreach ($menu->children as $submenu)
                                <li class="{{ $currentRouteBase == explode('.', $submenu->route)[0] ? 'active' : '' }}">
                                    {{-- @permission($submenu->permission) --}}
                                    <!-- Assuming you have permission field -->
                                    <a href="{{ route($submenu->route) }}">{{ $submenu->name }}</a>
                                    {{-- @endpermission --}}
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>

        </nav>
    </div>
    <!--  END SIDEBAR  -->
