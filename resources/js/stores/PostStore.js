import { defineStore } from 'pinia'
import { http } from "./http.js";
import router from '@/router'

export const usePostStore = defineStore('PostStore', () => {
    const authName = localStorage.getItem('name')

    const actions = {
        async fetchExplorePosts() {
            const response = await http.get('post/explore')
            return response.data
        },

        async fetchFollowingPosts() {
            const response = await http.get('post/following')
            return response.data
        },

        async fetchUserPost(username) {
            const response = await http.get('post/profile/' + username)
            return response.data
        },

        upload(file, content) {
            http.postForm('post', {
                'media': file,
                'content': content
            }).then(() => {
                router.push(`/${authName}`)
            })
        },

        likePost(id, isLiked) {
            http.get('post/' + id + '?isLiked=' + isLiked)
        },

        deletePost(id) {
            http.delete('post/' + id)
                .catch(error => {
                    alert(error)
                })
        },
    }

    return {actions}
})
