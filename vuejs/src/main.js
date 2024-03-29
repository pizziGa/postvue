import './assets/main.css'

import { createApp } from 'vue'
import router from '@/router'
import App from './App.vue'
import axios from 'axios'
import { createPinia } from 'pinia'

import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faSearch, faBars, faX, faUser, faAdd, faArrowRightToBracket, faUserPlus, faUserMinus, faHeart, faComment, faArrowRight, faPen, faShareNodes } from '@fortawesome/free-solid-svg-icons'
import { faHeart as farHeart, faComment as farComment, faTrashCan } from '@fortawesome/free-regular-svg-icons'
library.add(faSearch, faBars, faX, faUser, faAdd, faArrowRightToBracket, faUserPlus, faUserMinus, faHeart, faComment, farHeart, farComment, faArrowRight, faPen, faTrashCan, faShareNodes)

axios.defaults.headers.common['Accept'] = 'application/json'

const pinia = createPinia()

createApp(App)
    .use(pinia)
    .use(router)
    .component('font-awesome-icon', FontAwesomeIcon)
    .mount('#app')
