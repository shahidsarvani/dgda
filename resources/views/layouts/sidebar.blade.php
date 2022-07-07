<!-- Main sidebar -->
<div class="sidebar sidebar-light sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        <span class="font-weight-semibold">Navigation</span>
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user-material">
            <div class="sidebar-user-material-body">
                <div class="card-body text-center">
                    <a href="#">
                        <img src="{{ Auth::user()->profile_photo_url }}"
                            class="img-fluid rounded-circle shadow-1 mb-3" width="80" height="80" alt="">
                    </a>
                    <h6 class="mb-0 text-white text-shadow-dark">{{ auth()->user()->name }}</h6>
                    <span class="font-size-sm text-white text-shadow-dark">{{ auth()->user()->email }}</span>
                </div>

                <div class="sidebar-user-material-footer">
                    <a href="#user-nav"
                        class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle"
                        data-toggle="collapse"><span>My account</span></a>
                </div>
            </div>

            <div class="collapse" id="user-nav">
                <ul class="nav nav-sidebar">
                    <li class="nav-item">
                        <a href="{{ route('profile.show') }}" class="nav-link">
                            <i class="icon-user-plus"></i>
                            <span>My profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); $('.logout-form').submit();"
                            class="nav-link">
                            <i class="icon-switch2"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu"
                        title="Main"></i>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('settings.export_db') }}"
                        class="nav-link @if (Route::is('settings.export_db')) active @endif">
                        <i class="icon-home4"></i>
                        <span>
                            Export DB
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link @if (Route::is('dashboard', 'home')) active @endif">
                        <i class="icon-home4"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('rooms.index') }}"
                        class="nav-link @if (Route::is('rooms.index', 'rooms.edit')) active @endif">
                        <i class="icon-home9"></i>
                        <span>
                            Rooms
                        </span>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('lighting_types.index') }}"
                        class="nav-link @if (Route::is('lighting_types.index', 'lighting_types.edit')) active @endif">
                        <i class="icon-spotlight2"></i>
                        <span>
                            Lighting Types
                        </span>
                    </a>
                </li> --}}
                <li class="nav-item nav-item-submenu @if (Route::is('hardwares.*')) nav-item-open @endif">
                    <a href="#" class="nav-link"><i class="icon-hammer-wrench"></i> <span>Hardwares</span></a>

                    <ul class="nav nav-group-sub @if (Route::is('hardwares.*')) d-block @endif" data-submenu-title="Layouts">
                        <li class="nav-item">
                            <a href="{{ route('hardwares.index') }}" class="nav-link @if (Route::is('hardwares.index','hardwares.edit')) active @endif">Hardware List</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hardwares.create') }}" class="nav-link @if (Route::is('hardwares.create')) active @endif">Add Hardware</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('commands.index') }}"
                        class="nav-link @if (Route::is('commands.index', 'commands.edit')) active @endif">
                        <i class="icon-megaphone"></i>
                        <span>
                            Commands
                        </span>
                    </a>
                </li>
                <li class="nav-item nav-item-submenu @if (Route::is('scenes.*')) nav-item-open @endif">
                    <a href="#" class="nav-link"><i class="icon-traffic-lights"></i> <span>Scenes</span></a>

                    <ul class="nav nav-group-sub @if (Route::is('scenes.*')) d-block @endif" data-submenu-title="Layouts">
                        <li class="nav-item">
                            <a href="{{ route('scenes.index') }}" class="nav-link @if (Route::is('scenes.index','scenes.edit')) active @endif">Scenes List</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('scenes.create') }}" class="nav-link @if (Route::is('scenes.create')) active @endif">Add Scene</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item nav-item-submenu @if (Route::is('light_scenes.*')) nav-item-open @endif">
                    <a href="#" class="nav-link"><i class="icon-traffic-lights"></i> <span>Light Scenes</span></a>

                    <ul class="nav nav-group-sub @if (Route::is('light_scenes.*')) d-block @endif" data-submenu-title="Layouts">
                        <li class="nav-item">
                            <a href="{{ route('light_scenes.index') }}" class="nav-link @if (Route::is('light_scenes.index','light_scenes.edit')) active @endif">Light Scenes List</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('light_scenes.create') }}" class="nav-link @if (Route::is('light_scenes.create')) active @endif">Add Light Scene</a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('scenes.index') }}"
                        class="nav-link @if (Route::is('scenes.index', 'scenes.edit')) active @endif">
                        <i class="icon-traffic-lights"></i>
                        <span>
                            Scenes
                        </span>
                    </a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a href="{{ route('lightings.index') }}"
                        class="nav-link @if (Route::is('lightings.index', 'lightings.edit')) active @endif">
                        <i class="icon-spotlight2"></i>
                        <span>
                            Lightings
                        </span>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('phases.index') }}"
                        class="nav-link @if (Route::is('phases.index', 'phases.edit')) active @endif">
                        <i class="icon-transmission"></i>
                        <span>
                            Phases
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('zones.index') }}"
                        class="nav-link @if (Route::is('zones.index', 'zones.edit')) active @endif">
                        <i class="icon-map"></i>
                        <span>
                            Zones
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('media.index') }}"
                        class="nav-link @if (Route::is('media.index', 'media.create')) active @endif">
                        <i class="icon-film4"></i>
                        <span>
                            Media
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.index') }}"
                        class="nav-link @if (Route::is('settings.index', 'settings.edit')) active @endif">
                        <i class="icon-cog"></i>
                        <span>
                            Settings
                        </span>
                    </a>
                </li>
                <!-- /main -->
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
