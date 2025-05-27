/**
 * Responsive JS functions for Green Tire Application
 * Supporting screens from iPhone 5 (320px) and up
 * Last updated: May 20, 2025
 */

document.addEventListener('DOMContentLoaded', function() {
    // Auto-collapse sidebar on small screens
    function handleResponsiveSidebar() {
        const windowWidth = window.innerWidth;
        const container = document.getElementById('container');
        
        if (windowWidth < 768) {
            if (container && !container.classList.contains('sidebar-closed')) {
                // Find and trigger sidebar collapse button
                const sidebarCollapseBtn = document.querySelector('.sidebarCollapse');
                if (sidebarCollapseBtn && !container.classList.contains('sidebar-closed')) {
                    sidebarCollapseBtn.click();
                }
            }
            
            // Add mobile-specific classes
            document.body.classList.add('mobile-view');
        } else {
            document.body.classList.remove('mobile-view');
        }
    }
    
    // Fix dropdown behavior on mobile
    function enhanceDropdownsForMobile() {
        // Handle clicks outside of dropdown to close it - desktop complementary behavior
        document.addEventListener('click', function(event) {
            // If clicking on a dropdown toggle, let Bootstrap handle it
            if (event.target.closest('[data-bs-toggle="dropdown"]')) {
                return;
            }
            
            // If clicking outside a dropdown and its toggle, close any open dropdowns
            if (!event.target.closest('.dropdown-menu')) {
                const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
                openDropdowns.forEach(function(dropdown) {
                    dropdown.classList.remove('show');
                    
                    // Find the corresponding toggle and update aria-expanded
                    const dropdownId = dropdown.getAttribute('aria-labelledby');
                    if (dropdownId) {
                        const toggle = document.getElementById(dropdownId);
                        if (toggle) {
                            toggle.setAttribute('aria-expanded', 'false');
                        }
                    }
                });
            }
        });
    }
    
    // Make tables more responsive
    function enhanceResponsiveTables() {
        const tables = document.querySelectorAll('table:not(.table-responsive)');
        tables.forEach(table => {
            // Make sure all tables are inside responsive wrappers
            if (!table.parentElement.classList.contains('table-responsive')) {
                const wrapper = document.createElement('div');
                wrapper.classList.add('table-responsive');
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);
            }
        });
        
        // Add special handling for datatables
        enhanceDataTables();
    }
      // Special handling for DataTables
    function enhanceDataTables() {
        // Apply specific adjustments for DataTables responsive features
        
        // Add classes to improve responsive DataTables appearance
        document.querySelectorAll('table.dataTable').forEach(table => {
            // Add nowrap class to make horizontal scrolling work better
            if (!table.classList.contains('nowrap')) {
                table.classList.add('nowrap');
            }
            
            // Fix action button layout in responsive mode
            table.querySelectorAll('td:last-child').forEach(cell => {
                if (!cell.querySelector('.d-flex')) {
                    const buttons = cell.querySelectorAll('.btn');
                    if (buttons.length > 0) {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'd-flex flex-wrap justify-content-center gap-1';
                        buttons.forEach(button => wrapper.appendChild(button.cloneNode(true)));
                        cell.innerHTML = '';
                        cell.appendChild(wrapper);
                    }
                }
            });
        });
        
        // Improve DataTable responsive details display on small screens
        if (window.innerWidth < 576) {
            document.querySelectorAll('.dtr-data').forEach(data => {
                if (data.offsetWidth > 250) {
                    data.style.wordBreak = 'break-word';
                }
            });
            
            // Make sure mobile-only content is displayed correctly
            document.querySelectorAll('.mobile-only').forEach(el => {
                el.style.display = 'block';
            });
        }
    }
    
    // Make input groups responsive
    function enhanceResponsiveInputGroups() {
        // When on small screens, automatically add the responsive class to input groups
        if (window.innerWidth < 576) {
            const inputGroups = document.querySelectorAll('.input-group:not(.responsive-input-group)');
            inputGroups.forEach(group => {
                group.classList.add('responsive-input-group');
            });
        }
    }
    
    // Fix card headers on mobile
    function fixCardHeaders() {
        if (window.innerWidth < 576) {
            const cardHeaders = document.querySelectorAll('.card-header.d-flex.justify-content-between');
            cardHeaders.forEach(header => {
                if (!header.classList.contains('flex-column')) {
                    header.classList.add('flex-column', 'align-items-start', 'gap-2');
                }
            });
        }
    }
    
    // Fix responsive forms on mobile screens
    function enhanceResponsiveForms() {
        if (window.innerWidth < 576) {
            // Convert inline forms to stacked on mobile
            document.querySelectorAll('.row > .col-md-4, .row > .col-lg-4').forEach(col => {
                col.classList.add('mb-3');
            });
            
            // Improve filter forms layout
            document.querySelectorAll('form.mb-3 .row').forEach(row => {
                row.classList.add('flex-column');
                
                // Adjust spacing and alignment
                const filterButton = row.querySelector('.filter-button');
                if (filterButton) {
                    const buttonWrapper = filterButton.closest('.col-md-4');
                    if (buttonWrapper) {
                        buttonWrapper.style.marginLeft = '0';
                        buttonWrapper.classList.add('d-flex', 'justify-content-center');
                    }
                }
            });
        }
    }
    
    // Fix mobile buttons in tables
    function enhanceMobileButtons() {
        if (window.innerWidth < 768) {
            // Make sure all action buttons have consistent size and spacing
            document.querySelectorAll('.btn-sm').forEach(button => {
                // Ensure proper display for touch targets
                if (button.offsetWidth < 35) {
                    button.style.minWidth = '35px';
                }
                
                // Make sure button icons are nicely centered
                const icon = button.querySelector('i.fas');
                if (icon && button.querySelector('.d-none.d-md-inline')) {
                    button.style.display = 'inline-flex';
                    button.style.alignItems = 'center';
                    button.style.justifyContent = 'center';
                }
            });
            
            // Make button wrappers have proper spacing
            document.querySelectorAll('.d-flex.justify-content-center').forEach(wrapper => {
                if (!wrapper.classList.contains('mobile-button-wrapper')) {
                    wrapper.classList.add('mobile-button-wrapper');
                    wrapper.style.gap = '0.25rem';
                }
            });
        }
    }
    
    // Handle mobile button interactions
    function setupMobileButtonInteractions() {
        if (window.innerWidth < 768) {
            document.querySelectorAll('.button-group .btn-sm').forEach(button => {
                // Add touch feedback
                button.addEventListener('touchstart', function(e) {
                    this.style.transform = 'scale(0.95)';
                }, { passive: true });

                button.addEventListener('touchend', function(e) {
                    this.style.transform = 'scale(1)';
                }, { passive: true });

                // Manage hover states
                button.addEventListener('touchstart', function(e) {
                    // Remove hover state from other buttons
                    document.querySelectorAll('.button-group .btn-sm').forEach(btn => {
                        if (btn !== this) {
                            btn.classList.remove('hover');
                        }
                    });
                    this.classList.add('hover');
                }, { passive: true });

                // Ensure tooltip works on first touch
                if (button.hasAttribute('title')) {
                    const title = button.getAttribute('title');
                    let firstTouch = true;

                    button.addEventListener('touchstart', function(e) {
                        if (firstTouch) {
                            e.preventDefault();
                            firstTouch = false;
                        }
                    }, { passive: false });
                }
            });

            // Remove hover states when touching outside buttons
            document.addEventListener('touchstart', function(e) {
                if (!e.target.closest('.button-group')) {
                    document.querySelectorAll('.button-group .btn-sm').forEach(btn => {
                        btn.classList.remove('hover');
                        btn.style.transform = 'scale(1)';
                    });
                }
            }, { passive: true });
        }
    }
      // Run functions on page load
    handleResponsiveSidebar();
    enhanceResponsiveTables();
    enhanceResponsiveInputGroups();
    fixCardHeaders();
    enhanceResponsiveForms();
    enhanceMobileButtons();
    setupMobileButtonInteractions();
    enhanceDropdownsForMobile();
    
    // Run functions on resize
    window.addEventListener('resize', function() {
        handleResponsiveSidebar();
        enhanceResponsiveInputGroups();
        fixCardHeaders();
        enhanceResponsiveForms();
        enhanceDataTables();
        enhanceMobileButtons();
        setupMobileButtonInteractions();
    });
});