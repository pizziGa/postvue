import { defineStore } from 'pinia'
import { ref, watch } from 'vue'
import axios from 'axios'
import router from '@/router'

export const useUserStore = defineStore('UserStore', () => {
  const token = ref()

  const authName = ref()

  const isLoggedIn = ref(false)

  const http = axios.create({
    baseURL: "/api/",
    headers: {
      Authorization: 'Bearer ' + localStorage.getItem('token')
    }
  })

  http.interceptors.request.use(function (config) {
      config.headers.Authorization = 'Bearer ' +  token.value;
      return config;
  });

  if (localStorage.getItem('token') && localStorage.getItem('name')) {
    token.value = localStorage.getItem('token')
    authName.value = localStorage.getItem('name')
    isLoggedIn.value = true
    console.log(import.meta.env.VITE_BACKEND_URL)
  } else {
    router.push({ path: '/login' })
  }

  watch(
    token,
    (tokenVal) => {
      localStorage.setItem('token', tokenVal)
    }
  )

  watch ( 
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
        router.push({ path: '/login' })
      })
      .catch (error => {
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
        router.push({ path: '/' })
      })
      .catch(error => {
        alert(error)
      })
    },

    async fetchUser(username) {
      const response = await http.get('user/profile/'+username)
      return response.data
    },

    async fetchExplorePosts() {
      const response = await http.get('explore/posts')
      return response.data.posts
    },

    async fetchFollowingPosts() {
      const response = await http.get('following/posts')
      return response.data.posts
    },

    async fetchUserPost(username) {
      const response = await http.get('user/'+username+'/posts')
      return response.data.posts
    },

    logout() {
      http.get('user/logout')
      .then(() => {
        isLoggedIn.value = false
        token.value = ''
        localStorage.clear()
        router.push({ path: '/' })
      })
      .catch (error => {
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

    upload(file, content) {
      http.postForm('user/upload', {
        'media': file,
        'content': content
      }).then(() => {
        router.push(`/${authName.value}`)
      })
    },

    likePost(id, isLiked) {
      http.get('post/'+id+'?isLiked='+isLiked)
    },

    uploadComment(id, comment) { 
      http.postForm('post/'+id+'/comment', {
        'content': comment
      })
    },

    deletePost(id) {
      http.delete('post/'+id)
      .then(() => {
        window.location.reload()
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
      const response = await http.get('user/search/'+query)
      return response.data.results
    }
  }

  return {token, isLoggedIn, authName, actions}
})
