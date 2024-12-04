import { registerVueControllerComponents } from '@symfony/ux-vue';
import '../bootstrap.js';
import 'bulma/css/bulma.css'
import '../styles/dashboardPage.css';
import logoPath from '../images/Logo-noJoin.png';
import VanillaTilt from "vanilla-tilt";
import tinycolor from "tinycolor2";

let html = `<img src="${logoPath}" alt="ACME logo">`;

registerVueControllerComponents(require.context('../vue/controllers', true, /\.vue$/));

let notesRef = document.getElementById('notes');
let archivedRef = document.getElementById('archived');
let reminderRef = document.getElementById('reminder');
let addTagsRef = document.getElementById('addTags');
let lastRef = notesRef


let userRef = document.getElementById('user');
let userOptionsRef = document.getElementById('userOptions');
let logOutOption = document.getElementById('logOutOption');
let isUserMenuClosed = false;

let navbarToggler = document.getElementById('navbarHamburger');
let navbar = document.getElementById('navbar');

navbarToggler.addEventListener('click', e => {
    navbar.classList.toggle('is-hidden');
    isUserMenuClosed = !isUserMenuClosed;
})

//EVENT LISTENER FOR RESIZING TO SHOW (OR NOT) NAVBAR
window.addEventListener('resize', () => {
    console.log(navbarToggler.style.width);
    if (window.getComputedStyle(navbarToggler).getPropertyValue('display') === 'none') {
        navbar.classList.remove('is-hidden');
    }
    if (window.getComputedStyle(navbarToggler).getPropertyValue('display') !== 'none') {
        if (isUserMenuClosed) {

            navbar.classList.add('is-hidden');
        }

    }
})

//NOTES, ARCHIVED, REMINDERS AND ADD TAGS PART OF NAVBAR

notesRef.addEventListener('click', e => {
    if (lastRef !== notesRef) {
        notesRef.classList.toggle('is-active');
        lastRef.classList.remove('is-active');
    }
    lastRef = notesRef;
})

archivedRef.addEventListener('click', e => {
    if (lastRef !== archivedRef) {
        archivedRef.classList.toggle('is-active');
        lastRef.classList.remove('is-active');
    }
    lastRef = archivedRef;
})

reminderRef.addEventListener('click', e => {
    if (lastRef !== reminderRef) {
        reminderRef.classList.toggle('is-active');
        lastRef.classList.remove('is-active');
    }
    lastRef = reminderRef;
})

addTagsRef.addEventListener('click', e => {
    if (lastRef !== addTagsRef) {
        addTagsRef.classList.toggle('is-active');
        lastRef.classList.remove('is-active');
    }
    lastRef = addTagsRef;
})

//USER PART OF NAVBAR
userRef.addEventListener('click', (e) => {
    userOptionsRef.classList.toggle('is-hidden');
})

logOutOption.addEventListener('mouseenter', (e) => {
    logOutOption.classList.add('has-background-danger');
    logOutOption.classList.toggle('has-text-white');
})

logOutOption.addEventListener('mouseout', (e) => {
    logOutOption.classList.remove('has-background-danger');
    logOutOption.classList.toggle('has-text-white');
})


