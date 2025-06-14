import axios from "axios";
import { resolvePath } from "react-router-dom";

const axiosClient = axios.create({
    baseURL: import.meta.env.REACT_API_BASE_URL
})

axiosClient.interceptors.request.use((config) => {
    const token = localStorage.get('ACCESS_TOKEN')
    config.headers.Authorization = 'Bearer ${token}'
    return config;
})

axiosClient.interceptors.response.use((response) => {
    return response;
}, (error) => {
    const {response} = error;
    if(response.status == 401) {
        localStorage.removeItem('ACCESS_TOKEN')
    }
    throw error;
})
export default axiosClient;