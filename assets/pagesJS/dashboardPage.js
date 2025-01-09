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

let notesAddTagRef = null
let notesArchiveRef = null
let notesDeleteRef = null

let archiveModal = document.getElementById('archive-modal');
let acceptArchiveButton = document.getElementById('acceptModal archive-modal');
let denyArchiveButton = document.getElementById('closeModal archive-modal');

let parentDiv = document.getElementById('parent');
let sectionRef = parentDiv.getAttribute('data-section')

let notes = document.getElementsByClassName('note');
let addTagRefs = document.getElementsByClassName('add-tag');

let tagModal = document.getElementById('tag-modal');
let acceptTagButton = document.getElementById('acceptModal tag-modal');
let denyTagButton = document.getElementById('closeModal tag-modal');

document.addEventListener("turbo:load", function() {
    notes = document.getElementsByClassName('note');
    parentDiv = document.getElementById('parent');
    sectionRef = parentDiv.getAttribute('data-section')

    archiveModal = document.getElementById('archive-modal');
    acceptArchiveButton = document.getElementById('acceptModal archive-modal');
    denyArchiveButton = document.getElementById('closeModal archive-modal');

    if (sectionRef === "dashboard") {
        notesAddTagRef = document.getElementById('notesAdd-tag');
        notesArchiveRef = document.getElementById('notesAdd-archived');
        notesDeleteRef = document.getElementById('notesRemove-note');
    }

    else if (sectionRef === "archived") {
        notesAddTagRef = document.getElementById('archiveAdd-tag');
        notesArchiveRef = document.getElementById('archiveRemove-archived');
        notesDeleteRef = document.getElementById('archiveDelete-note');
    }

    addTagRefs = document.getElementsByClassName('add-tag');

    tagModal = document.getElementById('tag-modal');
    acceptTagButton = document.getElementById('acceptModal tag-modal');
    denyTagButton = document.getElementById('closeModal tag-modal');

    selectedNotes = []
    if (sectionRef === "reminders") {
        return
    }
    for (let i = 0; i < notes.length; i++) {
        clickAndHold(notes[i]);
    }

    for (let j = 0; j < addTagRefs.length; j++) {
        addTagRefs[j].addEventListener('click', (e) => {
            tagModal.classList.add('is-active');

            selectedNotes.push(addTagRefs[j].id);
        })
    }

    setModalTagConfig(notesAddTagRef, denyTagButton, acceptTagButton, tagModal);
    setNavButtonsBehavior()
});

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


let html = `<img src="${logoPath}" alt="ACME logo">`;

registerVueControllerComponents(require.context('../vue/controllers', true, /\.vue$/));

let controller = new AbortController();
const { signal } = controller;

let yesterdayDate = new Date();
yesterdayDate.setDate(yesterdayDate.getDate() - 1);

let acceptModalButton = document.getElementById('acceptModal');

if (sectionRef === "dashboard") {
    notesAddTagRef = document.getElementById('notesAdd-tag');
    notesArchiveRef = document.getElementById('notesAdd-archived');
    notesDeleteRef = document.getElementById('notesRemove-note');

}

else if (sectionRef === "archived") {
    notesAddTagRef = document.getElementById('archiveAdd-tag');
    notesArchiveRef = document.getElementById('archiveRemove-archived');
    notesDeleteRef = document.getElementById('archiveDelete-note');
}

let selectedNotes = [];

//DASHBOARD PART
function clickAndHold(btnEl) {
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
    }

    //Visual feedback to know note is selected
    //Adding / removing notes from the selectedNotes array
    const onMouseDown = () => {
        timerId = setTimeout(() => {
            if (!btnEl.classList.contains('box')) {
                selectedNotes.push(btnEl.id)
                btnEl.classList.add('box');
            }
            else {
                btnEl.classList.remove('box');
                let indexOfCard = selectedNotes.indexOf(btnEl.id);
                if (indexOfCard > -1) {
                    selectedNotes.splice(indexOfCard, 1);
                }
            }
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
}

//ARCHIVE MODAL LOGIC
archiveModal = document.getElementById('archive-modal');
acceptArchiveButton = document.getElementById('acceptModal archive-modal');
denyArchiveButton = document.getElementById('closeModal archive-modal');

setNavButtonsBehavior()

function setNavButtonsBehavior() {
    //MOVE - REMOVE FROM ARCHIVED

    notesArchiveRef.children[0].addEventListener('click', (e) => {
        archiveModal.classList.add('is-active');
    })

    denyArchiveButton.addEventListener('click', () => {
        archiveModal.classList.remove('is-active');
    })

    acceptArchiveButton.addEventListener('click', async e => {
        acceptArchiveButton.classList.toggle('is-loading');

        if (sectionRef === "dashboard") {
            const response = await fetch('http://localhost:8000/archiveNotes', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    selectedNotes
                })
            });
            const responseJSON = await response;
            if (responseJSON.ok) {
                location.reload();
            }
        }
        else {
            const response = await fetch('http://localhost:8000/unarchiveNotes', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    selectedNotes
                })
            });
            const responseJSON = await response;
            if (responseJSON.ok) {
                location.reload();
            }
        }
        acceptArchiveButton.classList.toggle('is-loading');
        archiveModal.classList.remove('is-active');
    })

//REMOVE NOTES LOGIC

    let deleteModal = document.getElementById('delete-modal');
    let acceptDeleteButton = document.getElementById('acceptModal delete-modal');
    let denyDeleteButton = document.getElementById('closeModal delete-modal');

    notesDeleteRef.children[0].addEventListener('click', (e) => {
        deleteModal.classList.add('is-active');
    })

    denyDeleteButton.addEventListener('click', () => {
        deleteModal.classList.remove('is-active');
    })

    acceptDeleteButton.addEventListener('click', async e => {
        acceptDeleteButton.classList.toggle('is-loading');
        const response = await fetch('http://localhost:8000/deleteNotes', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                selectedNotes
            })
        });
        const responseJSON = await response;
        if (responseJSON.ok) {
            location.reload();
        }
        acceptDeleteButton.classList.toggle('is-loading');
        deleteModal.classList.remove('is-active');
    })
}

//MODAL ADD TAG LOGIC
setModalTagConfig(notesAddTagRef, denyTagButton, acceptTagButton, tagModal);

function setModalTagConfig(notesAddTagRef, denyTagButton, acceptTagButton, tagModal) {
    notesAddTagRef.children[0].addEventListener('click', (e) => {
        tagModal.classList.add('is-active');
    })

    denyTagButton.addEventListener('click', () => {
        tagModal.classList.remove('is-active');
    })

    acceptTagButton.addEventListener('click', async e => {
        let selectedTag = document.getElementById('selectedTag tag-modal').value;
        acceptTagButton.classList.toggle('is-loading');
        const response = await fetch('http://localhost:8000/TagNotes', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                selectedNotes: selectedNotes,
                selectedTag: selectedTag

            })
        });
        const responseJSON = await response;
        if (responseJSON.ok) {
            location.reload();
        }
        acceptTagButton.classList.toggle('is-loading');
        tagModal.classList.remove('is-active');
    })
}