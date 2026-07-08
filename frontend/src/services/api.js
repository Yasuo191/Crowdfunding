import axios from "axios";

const api = axios.create({

    baseURL: "http://localhost/crowdfunding/backend/api/",

    withCredentials: true

});

export default api;