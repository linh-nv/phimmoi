import axios from "axios";
import { getToken, removeToken, isTokenExpired } from "@/services/auth";
import { BASE_API } from "@/utils/apisDomain";

const axiosInstance = axios.create({
  baseURL: BASE_API,
  timeout: 10000,
});

axiosInstance.interceptors.request.use(
  (config) => {
    const token = getToken();
    config.headers.Authorization = `Bearer ${token}`;

    return config;
  },
  (error) => {
    return Promise.reject(error);
  },
);

axiosInstance.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    if (error.response && error.response.status === 401) {
      removeToken();
      window.location.href = "/login";
    }
    return Promise.reject(error);
  },
);

export default axiosInstance;
