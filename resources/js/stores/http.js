import axios from "axios";

export const http = axios.create({
    baseURL: "/api/",
    headers: {
        Authorization: 'Bearer ' + localStorage.getItem('token')
    }
})
