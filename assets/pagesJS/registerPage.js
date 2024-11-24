import { registerVueControllerComponents } from '@symfony/ux-vue';
import '../bootstrap.js';
import 'bulma/css/bulma.css'
import '../styles/loginPage.css';
import logoPath from '../images/Logo-noJoin.png';


let html = `<img src="${logoPath}" alt="ACME logo">`;

var modal = document.getElementById("modal");

var buttonModalOpener = document.getElementById("openModal");
var buttonModalClose = document.getElementById("closeModal");
var modalBackground = document.getElementById("modalBackground");

buttonModalOpener.addEventListener("click", function() {
    modal.classList.add("is-active");
})

buttonModalClose.addEventListener("click", function() {
    modal.classList.remove("is-active");
})

modalBackground.addEventListener("click", function() {
    modal.classList.remove("is-active");
})

registerVueControllerComponents(require.context('../vue/controllers', true, /\.vue$/));