window.toggleDropdown = function(id) {
    const menu = document.getElementById(id);
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
};

document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(event) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (!menu.parentElement.contains(event.target)) {
                menu.style.display = 'none';
            }
        });
    });
});
