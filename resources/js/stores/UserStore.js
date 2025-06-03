import {defineStore} from 'pinia'
import {ref, watch} from 'vue'
import {http} from "./http.js";
import router from '@/router'

export const useUserStore = defineStore('UserStore', () => {
    const token = ref()

    const authName = ref()

    const isLoggedIn = ref(false)

    http.interceptors.request.use(function (config) {
        config.headers.Authorization = 'Bearer ' + token.value;
        return config;
    });

    if (localStorage.getItem('token') && localStorage.getItem('name')) {
        token.value = localStorage.getItem('token')
        authName.value = localStorage.getItem('name')
        isLoggedIn.value = true
    } else {
        router.push({path: '/login'})
    }

    watch(
        token,
        (tokenVal) => {
            localStorage.setItem('token', tokenVal)
        }
    )

    watch(
        authName,
        (authNameVal) => {
            localStorage.setItem('name', authNameVal)
        }
    )

    const actions = {
        signup(n, e, p, b) {
            http.post('user/store', {
                name: n,
                email: e,
                password: p,
                birthdate: b
            })
                .then(() => {
                    router.push({path: '/login'})
                })
                .catch(error => {
                    alert(error)
                })
        },

        authenticate(e, p) {
            http.post('user/authenticate', {
                email: e,
                password: p
            })
                .then(response => {
                    token.value = response.data.token
                    isLoggedIn.value = true
                    authName.value = response.data.username
                    router.push({path: '/'})
                })
                .catch(error => {
                    alert(error)
                })
        },

        async fetchUser(username) {
            const response = await http.get('user/' + username)
            return response.data
        },

        logout() {
            http.get('user/logout')
                .then(() => {
                    isLoggedIn.value = false
                    token.value = ''
                    localStorage.clear()
                    router.push({path: '/'})
                })
                .catch(error => {
                    alert(error)
                })
        },

        update(file, name, bio) {
            http.postForm('user/update',
                {
                    name: name,
                    bio: bio,
                    pfp: file,
                })
                .then(() => {
                    authName.value = name
                    router.push(`/${authName.value}`)
                })
                .catch(error => {
                    alert(error)
                })
        },

        followUser(followed) {
            http.post('user/follow',
                {
                    'followed': followed
                })
        },

        unfollowUser(followed) {
            http.post('user/unfollow',
                {
                    'followed': followed
                })
        },

        async searchUser(query) {
            const response = await http.get('user/search/' + query)
            return response.data.results
        }
    }

    return {token, isLoggedIn, authName, actions}
})
