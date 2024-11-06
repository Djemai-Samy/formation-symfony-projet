// Navbar menu interaction
const menuButton = document.querySelector('#navbar-menu-button');
menuButton.addEventListener('click', () => {
    const menu = document.querySelector('#navbar-menu');

    if (menu.style.left == "0%") {
        menu.style.left = "-100%";
    } else {
        menu.style.left = "0%";
    }
})