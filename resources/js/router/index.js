import {createRouter, createWebHistory} from "vue-router"

import HomepageView from '../views/HomepageView.vue'
import ProfileView from '../views/user/ProfileView.vue'
import SignupForm from '../views/forms/SignupForm.vue'
import LoginForm from '../views/forms/LoginForm.vue'
import LogoutView from '../views/forms/LogoutForm.vue'
import CreatePostForm from '../views/forms/CreatePostForm.vue'
import EditProfileForm from '../views/forms/EditProfileForm.vue'
import CommentSection from "../components/post/CommentSection.vue";

const routes = [
    {
        path: '/',
        component: HomepageView,
        name: 'following'
    },
    {
        path: '/:username',
        component: ProfileView,
        name: 'user-profile'
    },
    {
        path: '/signup',
        component: SignupForm
    },
    {
        path: '/login',
        component: LoginForm
    },
    {
        path: '/logout',
        component: LogoutView,
        name: 'logout'
    },
    {
        path: '/create',
        component: CreatePostForm,
        name: 'create'
    },
    {
        path: '/:username/edit',
        component: EditProfileForm,
        name: 'edit'
    },
    {
        path: '/explore',
        component: HomepageView,
        name: 'explore'
    },
    {
        path: '/test',
        component: CommentSection,
        name: 'test'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;
