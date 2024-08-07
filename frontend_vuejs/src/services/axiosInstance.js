import axios from "axios";
import { API_BASE_URL } from "@/utils/apisDomain";
import { useAuthStore } from "@/stores/authStore";
import { useLoadingStore } from "@/stores/loadingStore";
import router from "../router";

const axiosInstance = axios.create({
  baseURL: API_BASE_URL,
  timeout: 5000,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

let isRefreshing = false;
let failedQueue = [];

const processQueue = (error, token = null) => {
  failedQueue.forEach((prom) => {
    if (error) {
      prom.reject(error);
    } else {
      prom.resolve(token);
    }
  });

  failedQueue = [];
};

axiosInstance.interceptors.request.use(
  (config) => {
    const loadingStore = useLoadingStore();
    loadingStore.startLoading();

    const token = localStorage.getItem("accessToken");
    if (token) {
      config.headers["Authorization"] = "Bearer " + token;
    }
    return config;
  },
  (error) => {
    const loadingStore = useLoadingStore();
    loadingStore.stopLoading();
    return Promise.reject(error);
  },
);

axiosInstance.interceptors.response.use(
  (response) => {
    const loadingStore = useLoadingStore();
    loadingStore.stopLoading();
    return response;
  },
  async (error) => {
    const loadingStore = useLoadingStore();
    const authStore = useAuthStore();
    const originalRequest = error.config;

    if (error.response.status === 401 && !originalRequest._retry) {
      if (isRefreshing) {
        return new Promise((resolve, reject) => {
          failedQueue.push({ resolve, reject });
        })
          .then((token) => {
            originalRequest.headers["Authorization"] = "Bearer " + token;
            return axiosInstance(originalRequest);
          })
          .catch((err) => {
            loadingStore.stopLoading();
            return Promise.reject(err);
          });
      }

      originalRequest._retry = true;
      isRefreshing = true;

      try {
        const response = await authStore.refreshToken();
        const { access_token } = response.data;
        axiosInstance.defaults.headers.common["Authorization"] =
          "Bearer " + access_token;
        processQueue(null, access_token);
        return axiosInstance(originalRequest);
      } catch (err) {
        processQueue(err, null);
        authStore.clearAuth();
        router.push("/login");
        loadingStore.stopLoading();
        return Promise.reject(err);
      } finally {
        isRefreshing = false;
      }
    }

    if (error.response.status >= 400 && error.response.status < 600) {
        authStore.clearAuth();
        router.push("/login");
    }

    loadingStore.stopLoading();
    return Promise.reject(error);
  },
);

export default axiosInstance;
