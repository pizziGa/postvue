import { defineStore } from 'pinia'
import { http } from "./http.js";

export const useCommentStore = defineStore('CommentStore', () => {
    const actions = {
        async fetchPostComments(post_id) {
            const response = await http.get('post/' + post_id + '/comments')
            return response.data
        },

        async uploadComment(id, comment) {
            await http.post('comment', {
                'content': comment,
                'post_id': id
            })
        },
    }

    return { actions }
})
