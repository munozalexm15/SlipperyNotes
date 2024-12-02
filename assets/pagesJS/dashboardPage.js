import { registerVueControllerComponents } from '@symfony/ux-vue';
import '../bootstrap.js';
import 'bulma/css/bulma.css'
import '../styles/dashboardPage.css';
import logoPath from '../images/Logo-noJoin.png';
import VanillaTilt from "vanilla-tilt";

let html = `<img src="${logoPath}" alt="ACME logo">`;

registerVueControllerComponents(require.context('../vue/controllers', true, /\.vue$/));

let notesRef = document.getElementById('notes');
let archivedRef = document.getElementById('archived');
let reminderRef = document.getElementById('reminder');
let addTagsRef = document.getElementById('addTags');
let lastRef = notesRef


let userRef = document.getElementById('user');
let userOptionsRef = document.getElementById('userOptions');
let isUserMenuOpened = false;

userRef.addEventListener('click', (e) => {
    userOptionsRef.classList.toggle('is-hidden');
})

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


