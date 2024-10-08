import axios from "axios";
import { clientCookieService } from "@/services/Client/clientCookieService";
import { clientAuthService } from "@/services/Client/clientAuthService";
import { API_BASE_URL } from "@/utils/apisDomain";
import { useLoadingStore } from "@/stores/loadingStore";
import { useClientStore } from "@/stores/clientStore";

const clientAxiosInstance = axios.create({
  baseURL: API_BASE_URL,
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

clientAxiosInstance.interceptors.request.use(
  async (config) => {
    const loadingStore = useLoadingStore();
    loadingStore.startLoading();
    const clientStore = useClientStore();

    let accessToken = clientCookieService.getAccessToken();
    const accessTokenExpires = clientCookieService.getAccessTokenExpires();
    const now = new Date().getTime();

    if (accessTokenExpires && now > accessTokenExpires) {
      if (!isRefreshing) {
        isRefreshing = true;
        try {
          const response = await clientAuthService.refreshToken();
          accessToken = response.access_token;
          clientCookieService.setToken(response);
          processQueue(null, accessToken);
        } catch (error) {
          processQueue(error, null);
          clientCookieService.removeTokens();
          clientStore.clearClient();

          window.location.href = "/";
          alert("Đã xảy ra lỗi, xin vui lòng thử lại!");
          return Promise.reject(error);
        } finally {
          isRefreshing = false;
        }
      }

      return new Promise((resolve, reject) => {
        failedQueue.push({
          resolve: (token) => {
            config.headers.Authorization = `Bearer ${token}`;
            resolve(config);
          },
          reject: (error) => {
            reject(error);
          },
        });
      });
    }

    if (accessToken) {
      config.headers.Authorization = `Bearer ${accessToken}`;
    }

    return config;
  },
  (error) => {
    const loadingStore = useLoadingStore();
    loadingStore.stopLoading();

    return Promise.reject(error);
  },
);

clientAxiosInstance.interceptors.response.use(
  (response) => {
    const loadingStore = useLoadingStore();
    loadingStore.stopLoading();
    return response;
  },
  async (error) => {
    const loadingStore = useLoadingStore();
    const clientStore = useClientStore();

    if (
      error.response &&
      error.response.status === 401 &&
      !error.config._retry
    ) {
      error.config._retry = true;

      try {
        const response = await clientAuthService.refreshToken();
        clientCookieService.setToken(response);

        error.config.headers.Authorization = `Bearer ${response.access_token}`;

        return clientAxiosInstance(error.config);
      } catch (refreshError) {
        clientCookieService.removeTokens();
        clientStore.clearClient();

        window.location.href = "/";
        alert("Đã xảy ra lỗi, xin vui lòng thử lại!");

        return Promise.reject(refreshError);
      } finally {
        loadingStore.stopLoading();
      }
    }

    loadingStore.stopLoading();
    return Promise.reject(error);
  },
);

export default clientAxiosInstance;
