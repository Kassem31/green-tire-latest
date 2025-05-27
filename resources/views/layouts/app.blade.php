<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    @yield('styles')
</head>

<body class="layout-boxed alt-menu" data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="140">
    @include('partials.loader')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        <!--  BEGIN MAIN CONTAINER  -->
        <div class="main-container sidebar-closed sbar-open" id="container">

            <div class="overlay"></div>
            <div class="cs-overlay"></div>
            <div class="search-overlay"></div>

            @include('partials.navbar')

            @include('partials.sidebar')

            <div id="content" class="main-content">
                @yield('content')
                @include('partials.footer')
            </div>
        </div>
    </div>
    <!--  END MAIN CONTAINER  -->

    <!-- Sidebar Menu Scripts -->
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fix for sidebar dropdown menus
            var dropdownMenus = document.querySelectorAll('.dropdown-toggle[data-bs-toggle="collapse"]');

            // Fix for first click issue - remove Bootstrap's default event handlers
            dropdownMenus.forEach(function(menu) {
                // Remove default Bootstrap collapse behavior
                menu.removeAttribute('data-bs-toggle');
                
                // Add our custom click handler
                menu.addEventListener('click', function(e) {
                    // Prevent default behavior
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Handle the dropdown click event
                    let targetId = this.getAttribute('href');
                    
                    // Use getElementById instead of querySelector to avoid CSS selector issues with numeric IDs
                    let targetEl = null;
                    if (targetId && targetId.startsWith('#')) {
                        const idWithoutHash = targetId.substring(1);
                        targetEl = document.getElementById(idWithoutHash);
                    }

                    if (targetEl) {
                        // Toggle the 'show' class
                        if (targetEl.classList.contains('show')) {
                            // Close this menu
                            targetEl.classList.remove('show');
                            this.setAttribute('aria-expanded', 'false');
                        } else {
                            // Close any other open menus first
                            let openMenus = document.querySelectorAll('.collapse.submenu.show');
                            openMenus.forEach(function(openMenu) {
                                if (openMenu.id !== targetEl.id) {
                                    openMenu.classList.remove('show');
                                    const toggle = document.querySelector(`[href="#${openMenu.id}"]`);
                                    if (toggle) {
                                        toggle.setAttribute('aria-expanded', 'false');
                                    }
                                }
                            });

                            // Open this menu
                            targetEl.classList.add('show');
                            this.setAttribute('aria-expanded', 'true');
                        }
                    }
                });
            });
            
            // Add global click handler to close menus when clicking elsewhere
            document.addEventListener('click', function(e) {
                // If not clicking on a dropdown menu or toggle
                if (!e.target.closest('.submenu') && !e.target.closest('.dropdown-toggle')) {
                    // Close any open dropdown menus
                    let openMenus = document.querySelectorAll('.collapse.submenu.show');
                    openMenus.forEach(function(menu) {
                        menu.classList.remove('show');
                        const toggle = document.querySelector(`[href="#${menu.id}"]`);
                        if (toggle) {
                            toggle.setAttribute('aria-expanded', 'false');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
