import axios from "axios";
import { API_BASE_URL } from "@/utils/apisDomain";
import { useUserStore } from "../stores/userStore";
import { useLoadingStore } from "../stores/loadingStore";
import router from "../router";

const axiosInstance = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    "Content-Type": "application/json",
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
  async (config) => {
    const userStore = useUserStore();
    const loadingStore = useLoadingStore();
    const token = userStore.accessToken;
    const tokenExpiration = userStore.tokenExpiration;

    loadingStore.startLoading();

    if (token) {
      // Kiểm tra nếu token hết hạn
      if (tokenExpiration && new Date().getTime() > tokenExpiration) {
        if (!isRefreshing) {
          isRefreshing = true;

          try {
            const response = await axiosInstance.post("/refresh");
            const { access_token, expires_in } = response.data;
            const expirationTime = new Date().getTime() + expires_in * 1000;

            userStore.setAccessToken(access_token);
            userStore.setTokenExpiration(expirationTime);
            axiosInstance.defaults.headers.common[
              "Authorization"
            ] = `Bearer ${access_token}`;

            processQueue(null, access_token);
          } catch (error) {
            processQueue(error, null);
            userStore.setAccessToken(null);
            router.push({ name: "login" });
          } finally {
            isRefreshing = false;
          }
        }

        return new Promise((resolve, reject) => {
          failedQueue.push({ resolve, reject });
        })
          .then((token) => {
            config.headers.Authorization = `Bearer ${token}`;
            return config;
          })
          .catch((err) => {
            return Promise.reject(err);
          });
      }

      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    const loadingStore = useLoadingStore();
    loadingStore.stopLoading();
    return Promise.reject(error);
  }
);

axiosInstance.interceptors.response.use(
  (response) => {
    const loadingStore = useLoadingStore();
    loadingStore.stopLoading();
    return response;
  },
  async (error) => {
    const loadingStore = useLoadingStore();
    loadingStore.stopLoading();

    const {
      config,
      response: { status },
    } = error;
    const userStore = useUserStore();

    if (status === 401 && !config._retry) {
      config._retry = true;

      if (!isRefreshing) {
        isRefreshing = true;

        try {
          const response = await axiosInstance.post("/refresh");
          const { access_token, expires_in } = response.data;
          const expirationTime = new Date().getTime() + expires_in * 1000;

          userStore.setAccessToken(access_token);
          userStore.setTokenExpiration(expirationTime);
          axiosInstance.defaults.headers.common[
            "Authorization"
          ] = `Bearer ${access_token}`;

          processQueue(null, access_token);
        } catch (error) {
          processQueue(error, null);
          userStore.setAccessToken(null);
          router.push({ name: "login" });
        } finally {
          isRefreshing = false;
        }
      }

      return new Promise((resolve, reject) => {
        failedQueue.push({ resolve, reject });
      })
        .then((token) => {
          config.headers.Authorization = `Bearer ${token}`;
          return axiosInstance(config);
        })
        .catch((err) => {
          return Promise.reject(err);
        });
    }

    return Promise.reject(error);
  }
);

export default axiosInstance;
