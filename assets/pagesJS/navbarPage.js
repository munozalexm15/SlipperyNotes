import '../bootstrap.js';
import 'bulma/css/bulma.css'
import '../styles/dashboardPage.css';

let logOutOption = document.getElementById('logOutOption');
let isUserMenuClosed = false;

let navbarToggler = document.getElementById('navbarHamburger');
let navbar = document.getElementById('navbar');

//EVENT LISTENER FOR RESIZING TO SHOW (OR NOT) NAVBAR

document.addEventListener("turbo:load", function() {
    isUserMenuClosed = false;
    navbarToggler = document.getElementById('navbarHamburger');
    navbar = document.getElementById('navbar');
    logOutOption = document.getElementById('logOutOption');
    loadNavConfig()
})

function loadNavConfig() {
    window.addEventListener('resize', () => {
        if (window.getComputedStyle(navbarToggler).getPropertyValue('display') === 'none') {
            navbar.classList.remove('is-hidden');
        }
        if (window.getComputedStyle(navbarToggler).getPropertyValue('display') !== 'none') {
            if (isUserMenuClosed) {

                navbar.classList.add('is-hidden');
            }
        }
    })
    navbarToggler.addEventListener('click', e => {
        navbar.classList.toggle('is-hidden');
        isUserMenuClosed = !isUserMenuClosed;
    })

    logOutOption.addEventListener('mouseenter', (e) => {
        logOutOption.classList.add('has-background-danger');
        logOutOption.classList.toggle('has-text-white');
    })

    logOutOption.addEventListener('mouseout', (e) => {
        logOutOption.classList.remove('has-background-danger');
        logOutOption.classList.toggle('has-text-white');
    })

}