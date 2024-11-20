import { registerVueControllerComponents } from '@symfony/ux-vue';
import './bootstrap.js';
import 'bulma/css/bulma.css'
import './styles/app.css';
import logoPath from './images/Logo-noJoin.png';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)


let html = `<img src="${logoPath}" alt="ACME logo">`;

registerVueControllerComponents(require.context('./vue/controllers', true, /\.vue$/));

