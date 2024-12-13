import { registerVueControllerComponents } from '@symfony/ux-vue';
import '../bootstrap.js';
import 'bulma/css/bulma.css'
import '../styles/dashboardPage.css';
import logoPath from '../images/Logo-noJoin.png';
import 'bulma-calendar/dist/css/bulma-calendar.min.css'

let html = `<img src="${logoPath}" alt="ACME logo">`;

registerVueControllerComponents(require.context('../vue/controllers', true, /\.vue$/));

let yesterdayDate = new Date();
yesterdayDate.setDate(yesterdayDate.getDate() - 1);

let acceptModalButton = document.getElementById('acceptModal');

let notesAddTagRef = null
let notesArchiveRef = null
let notesDeleteRef = null

const parentDiv = document.getElementById('parent');
const sectionRef = parentDiv.getAttribute('data-section')


if (sectionRef === "dashboard") {
    notesAddTagRef = document.getElementById('notesAdd-tag');
    notesArchiveRef = document.getElementById('notesAdd-archived');
    notesDeleteRef = document.getElementById('notesRemove-note');
}

else if (sectionRef !== "dashboard") {
    notesAddTagRef = document.getElementById('archiveAdd-tag');
    notesArchiveRef = document.getElementById('archiveRemove-archived');
    notesDeleteRef = document.getElementById('archiveDelete-note');
}

let selectedNotes = [];

//DASHBOARD PART
const notes = document.getElementsByClassName('note');

document.addEventListener('DOMContentLoaded', () => {
    for (let i = 0; i < notes.length; i++) {
        clickAndHold(notes[i]);
    }
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
};


//MODAL LOGIC
let modal = document.getElementById('archiveModal');

notesArchiveRef.children[0].addEventListener('click', (e) => {
    modal.classList.add('is-active');

})

let closeModalButton = document.getElementById('closeModal');
closeModalButton.addEventListener('click', () => {
    modal.classList.remove('is-active');
})

acceptModalButton.addEventListener('click', async e => {
    acceptModalButton.classList.toggle('is-loading');
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
    acceptModalButton.classList.toggle('is-loading');

    modal.classList.remove('is-active');

})