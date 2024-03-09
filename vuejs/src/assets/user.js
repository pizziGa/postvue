import axios from 'axios'
import router from '@/router'


export class User {
  async signup(n, e, p, b) {
    try {
      await axios.post('http://localhost:8000/api/user/store', {name: n, email: e, password: p, birthdate: b})
      router.push({ path: '/login' })
    } catch (error) {
      alert(error)
    }
  }

  async authenticate(e, p) {
    try {
      await axios.post('http://localhost:8000/api/user/authenticate', {email: e, password: p})
      router.push({ path: '/' })
    } catch (error) {
      alert(error)
    }
  }

  async fetchUser() {
    try {
      let data = await axios.get('http://localhost:8000/api/user')
      return data.data.user
    } catch (error) {
      router.push('/login')
    }
    
  }

  async logout() {
    try {
      await axios.get('http://localhost:8000/api/user/logout')
      router.push({ path: '/' })
    } catch (error) {
      alert(error)
    }
  }
}
