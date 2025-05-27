/**
 * Bootstrap 5 Component Initialization and Fixes
 * 
 * This file provides fixes for Bootstrap dropdowns and initializes components.
 * It specifically addresses issues with dropdowns not closing properly.
 */
document.addEventListener('DOMContentLoaded', function() {
    // DIRECT APPROACH: Force all dropdowns to close on outside click
    document.addEventListener('click', function(e) {
        // Skip if clicking on a dropdown toggle or inside a dropdown menu
        if (e.target.closest('[data-bs-toggle="dropdown"]') || e.target.closest('.dropdown-menu')) {
            return;
        }
        
        // Select all visible dropdown menus
        var openDropdowns = document.querySelectorAll('.dropdown-menu.show');
        
        // Close each one manually
        openDropdowns.forEach(function(dropdown) {
            dropdown.classList.remove('show');
            
            // Find the corresponding trigger and update aria-expanded
            var triggers = document.querySelectorAll('[data-bs-toggle="dropdown"][aria-expanded="true"]');
            triggers.forEach(function(trigger) {
                trigger.setAttribute('aria-expanded', 'false');
            });
        });
    });

    // Handle the user profile dropdown specifically (it might have custom behavior)
    var profileDropdownToggle = document.getElementById('userProfileDropdown');
    if (profileDropdownToggle) {
        profileDropdownToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Get the dropdown menu
            var dropdownMenu = this.nextElementSibling;
            if (!dropdownMenu) return;
            
            // Toggle dropdown visibility
            if (dropdownMenu.classList.contains('show')) {
                dropdownMenu.classList.remove('show');
                this.setAttribute('aria-expanded', 'false');
            } else {
                // Close any other open dropdowns first
                document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                    menu.classList.remove('show');
                    var toggle = document.querySelector('[aria-expanded="true"]');
                    if (toggle) toggle.setAttribute('aria-expanded', 'false');
                });
                
                // Open this dropdown
                dropdownMenu.classList.add('show');
                this.setAttribute('aria-expanded', 'true');
            }
        });
    }

    // Close dropdowns on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.dropdown-menu.show').forEach(function(dropdown) {
                dropdown.classList.remove('show');
                
                // Reset aria-expanded on all dropdown toggles
                document.querySelectorAll('[data-bs-toggle="dropdown"][aria-expanded="true"]').forEach(function(toggle) {
                    toggle.setAttribute('aria-expanded', 'false');
                });
            });
        }
    });

    // Initialize other Bootstrap components if needed
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    if (tooltipTriggerList.length && bootstrap && bootstrap.Tooltip) {
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
});
