import { registerVueControllerComponents } from '@symfony/ux-vue';
import '../bootstrap.js';
import 'bulma/css/bulma.css'
import '../styles/dashboardPage.css';
import logoPath from '../images/Logo-noJoin.png';
import VanillaTilt from "vanilla-tilt";
import tinycolor from "tinycolor2";
import bulmaCalendar from 'bulma-calendar/dist/js/bulma-calendar.min';
import 'bulma-calendar/dist/css/bulma-calendar.min.css'
import * as yesterday from "date-fns";
import i from "../vendor/typed.js/typed.js.index";

let html = `<img src="${logoPath}" alt="ACME logo">`;

registerVueControllerComponents(require.context('../vue/controllers', true, /\.vue$/));

let controller = new AbortController();
const { signal } = controller;

let userRef = document.getElementById('user');
let userOptionsRef = document.getElementById('userOptions');
let logOutOption = document.getElementById('logOutOption');
let isUserMenuClosed = false;

let notesAddTagRef = document.getElementById('notesAdd-tag');
let notesArchiveRef = document.getElementById('notesAdd-archived');
let notesDeleteRef = document.getElementById('notesRemove-note');

let archiveAddTagRef = document.getElementById('archiveAdd-tag');
let archiveArchiveRef = document.getElementById('archiveRemove-archived');
let archiveDeleteRef = document.getElementById('archiveDelete-note');

let navbarToggler = document.getElementById('navbarHamburger');
let navbar = document.getElementById('navbar');

let yesterdayDate = new Date();
yesterdayDate.setDate(yesterdayDate.getDate() - 1);

let selectedNotes = [];

var defaultOptions = {
    color: 'primary',
    isRange: false,
    allowSameDayRange: true,
    lang: 'en-US',
    endDate: undefined,
    maxDate: null,
    disabledDates: [yesterdayDate],
    disabledWeekDays: undefined,
    highlightedDates: [],
    dateFormat: 'yyyy-MM-dd',
    timeFormat: 'HH:mm:ss',
    enableMonthSwitch: true,
    enableYearSwitch: true,
    displayYearsCount: 50,
    displayMode: 'dialog',
    type: 'datetime',
    validateLabel: 'Set reminder',
    showTodayButton: false,
    minDate: yesterdayDate,
    startDate: new Date(),
    weekStart: 1,
    showButtons: false,

};

const calendars = bulmaCalendar.attach('[type="date"]', defaultOptions);


//DASHBOARD PART
const notes = document.getElementsByClassName('note');

document.addEventListener('DOMContentLoaded', () => {
    for (let i = 0; i < notes.length; i++) {
        clickAndHold(notes[i]);
    }
})



navbarToggler.addEventListener('click', e => {
    navbar.classList.toggle('is-hidden');
    isUserMenuClosed = !isUserMenuClosed;
})

//EVENT LISTENER FOR RESIZING TO SHOW (OR NOT) NAVBAR
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

const clickAndHold = (btnEl) => {
    let timerId;
    const DURATION = 200;

    //Prevents to redirect when clicking the note if there are notes selected
    //Allows to click after all the notes have been unselected
    const preventListening = function (e) {
        e.preventDefault();
        if (selectedNotes.length > 0) {
            return;
        }
        for (let i = 0; i < notes.length; i++) {
            notes[i].removeEventListener('click', preventListening);
        }
        e.stopPropagation();
        console.log("eo")

    }

    //Visual feedback to know note is selected
    //Adding / removing notes from the selectedNotes array
    const onMouseDown = () => {
        timerId = setTimeout(() => {
            if (!btnEl.classList.contains('box')) {
                selectedNotes.push(btnEl.id);
                btnEl.classList.add('box');
            }
            else {
                btnEl.classList.remove('box');
                let indexOfCard = selectedNotes.indexOf(btnEl.id);
                if (indexOfCard > -1) {
                    selectedNotes.splice(indexOfCard, 1);
                }
            }
            console.log(selectedNotes);
        }, DURATION);
    };

    //Showing / removing the navbar options to delete, add tag or archive notes.
    const clearTimer = () => {
        timerId && clearInterval(timerId);

        if (selectedNotes.length > 0) {
            notesAddTagRef.classList.remove('is-hidden');
            notesDeleteRef.classList.remove('is-hidden');
            notesArchiveRef.classList.remove('is-hidden');
            for (let i = 0; i < notes.length; i++) {
                notes[i].addEventListener('click', preventListening);
            }
        }
        else {
            notesAddTagRef.classList.add('is-hidden');
            notesDeleteRef.classList.add('is-hidden');
            notesArchiveRef.classList.add('is-hidden')
        }
    };

    //handle when mouse is clicked
    btnEl.addEventListener("mousedown", onMouseDown);
    //handle when mouse is raised
    btnEl.addEventListener("mouseup", clearTimer);
    //handle mouse leaving the clicked button
    btnEl.addEventListener("mouseout", clearTimer);

    // a callback function to remove listeners useful in libs like react
    // when component or element is unmounted
    return () => {
        btnEl.removeEventListener("mousedown", onMouseDown);
        btnEl.removeEventListener("mouseup", clearTimer);
        btnEl.removeEventListener("mouseout", clearTimer);
    };
};