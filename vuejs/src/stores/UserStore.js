import { defineStore } from 'pinia'
import { ref, watch } from 'vue'
import axios from 'axios'
import router from '@/router'

export const useUserStore = defineStore('UserStore', () => {
  const token = ref()

  const isLoggedIn = ref(false)

  if (localStorage.getItem('token') != '""') {
    let dirtyToken = localStorage.getItem('token');
    token.value = dirtyToken.replaceAll('"', '')
    isLoggedIn.value = true;
  } else {
    router.push({ path: '/login' })
  }

  watch(
    token,
    (tokenVal) => {
      localStorage.setItem('token', JSON.stringify(tokenVal));
    },
    { deep: true }
  )

  const actions = {
    async signup(n, e, p, b) {
      try {
        await axios.post('http://localhost:8000/api/user/store', {
          name: n,
          email: e,
          password: p,
          birthdate: b
        })
        router.push({ path: '/login' })
      } catch (error) {
        alert(error)
      }
    },

    async authenticate(e, p) {
      try {
        const response = await axios.post('http://localhost:8000/api/user/authenticate', {
          email: e,
          password: p
        })
        token.value = response.data.token
        isLoggedIn.value = true
        router.push({ path: '/' })
      } catch (error) {
        alert(error)
      }
    },

    async fetchUser() {
      try {
        let data = await axios.get('http://localhost:8000/api/user', 
        { 
          headers: {
            'Accept':'application/json',
            'Authorization':'Bearer '+token.value
          }
        })
        return data.data.user
      } catch (error) {
        router.push('/login')
      }
    },

    async logout() {
      try {
        await axios.get('http://localhost:8000/api/user/logout', 
        { 
          headers: {
            'Accept':'application/json',
            'Authorization':'Bearer '+token.value
          }
        })
        isLoggedIn.value = false
        token.value = ''
        localStorage.clear()
        router.push({ path: '/' })
      } catch (error) {
        alert(error)
      }
    },

    async update(file, name, bio) {
      try {
        await axios.post('http://localhost:8000/api/user/update',
        { 
          name: name,
          bio: bio,
          pfp: file,
          headers: {
            'Accept':'application/json',
            'Authorization':'Bearer '+token.value
          }
        })
        router.push({ path: '/my-profile' })
      } catch(error) {
        alert(error)
      }
    }
  }

  return {token, isLoggedIn, actions}
})
