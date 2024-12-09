import { registerVueControllerComponents } from '@symfony/ux-vue';
import '../bootstrap.js';
import 'bulma/css/bulma.css'
import '../styles/dashboardPage.css';
import logoPath from '../images/Logo-noJoin.png';
import VanillaTilt from "vanilla-tilt";
import tinycolor from "tinycolor2";
import bulmaCalendar from 'bulma-calendar/dist/js/bulma-calendar.min';
import 'bulma-calendar/dist/css/bulma-calendar.min.css'

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

var defaultOptions = {
    color: 'primary',
    isRange: false,
    allowSameDayRange: true,
    lang: 'en-US',
    endDate: undefined,
    maxDate: null,
    disabledDates: [],
    disabledWeekDays: undefined,
    highlightedDates: [],
    dateFormat: 'yyyy-MM-dd',
    timeFormat: 'HH:mm:ss',
    enableMonthSwitch: true,
    enableYearSwitch: true,
    displayYearsCount: 50,
    displayMode: 'inline',
    type: 'datetime',
    validateLabel: 'Set reminder',
    showTodayButton: false,
    minDate: new Date(),
    startDate: new Date(),
    weekStart: 1,
    showButtons: false,

};

// Initialize all input of date type.
const calendars = bulmaCalendar.attach('[type="date"]', defaultOptions);



// Loop on each calendar initialized
calendars.forEach(calendar => {
    // Add listener to select event
    calendar.on('select', date => {
        console.log(date);
    });
});

// To access to bulmaCalendar instance of an element
const element = document.querySelector('#my-element');
if (element) {
    // bulmaCalendar instance is available as element.bulmaCalendar
    element.bulmaCalendar.on('select', datepicker => {
        console.log(datepicker.data.value());
    });
}


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


