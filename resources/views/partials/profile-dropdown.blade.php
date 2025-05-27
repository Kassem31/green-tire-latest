<script>
document.addEventListener('DOMContentLoaded', function() {
    // Direct profile dropdown handling
    const profileToggle = document.getElementById('userProfileDropdown');
    if (profileToggle) {
        profileToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const dropdownMenu = this.nextElementSibling;
            if (dropdownMenu && dropdownMenu.classList.contains('dropdown-menu')) {
                // Toggle the dropdown
                dropdownMenu.classList.toggle('show');
                this.setAttribute('aria-expanded', dropdownMenu.classList.contains('show'));
            }
        });
        
        // Close when clicking elsewhere
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.user-profile-dropdown')) {
                const dropdownMenu = document.querySelector('.user-profile-dropdown .dropdown-menu');
                if (dropdownMenu && dropdownMenu.classList.contains('show')) {
                    dropdownMenu.classList.remove('show');
                    profileToggle.setAttribute('aria-expanded', 'false');
                }
            }
        });
    }
});
</script>
