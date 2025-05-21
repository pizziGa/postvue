/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import '../css/app.css'
import './bootstrap';
import { createApp } from 'vue';
import router from '@/router'
import axios from 'axios'
import { createPinia } from 'pinia'


import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faSearch, faBars, faX, faUser, faAdd, faArrowRightToBracket, faUserPlus, faUserMinus, faHeart, faComment, faArrowRight, faPen, faShareNodes } from '@fortawesome/free-solid-svg-icons'
import { faHeart as farHeart, faComment as farComment, faTrashCan } from '@fortawesome/free-regular-svg-icons'
library.add(faSearch, faBars, faX, faUser, faAdd, faArrowRightToBracket, faUserPlus, faUserMinus, faHeart, faComment, farHeart, farComment, faArrowRight, faPen, faTrashCan, faShareNodes)
/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */
const pinia = createPinia()

const app = createApp({});

import App from './App.vue';
app.component('app', App);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.use(pinia).use(router).component('font-awesome-icon', FontAwesomeIcon).mount('#app');
