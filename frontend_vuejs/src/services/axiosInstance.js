import axios from "axios";
import { cookieService } from "@/services/cookieService";
import { authService } from "@/services/authService";
import { API_BASE_URL } from "@/utils/apisDomain";
import { useLoadingStore } from "@/stores/loadingStore";

const axiosInstance = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

axiosInstance.interceptors.request.use(
  async (config) => {
    const loadingStore = useLoadingStore();
    loadingStore.startLoading();

    let accessToken = cookieService.getAccessToken();
    const accessTokenExpires = cookieService.getAccessTokenExpires();
    const now = new Date().getTime();

    // Kiểm tra nếu access token đã hết hạn
    if (accessTokenExpires && now > accessTokenExpires) {
      try {
        const response = await authService.refreshToken();
        accessToken = response.data.access_token;
      } catch (error) {
        cookieService.removeTokens();
        window.location.href = "/admin/login";

        loadingStore.stopLoading();

        return Promise.reject(error);
      }
    }

    if (accessToken) {
      config.headers.Authorization = `Bearer ${accessToken}`;
    }

    return config;
  },
  (error) => {
    const loadingStore = useLoadingStore();
    loadingStore.stopLoading();

    alert(error);
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

    try {
      if (error.response.status == 401) {
        await authService.refreshToken();

        return axiosInstance(error.config);
      }
    } catch (refreshError) {
      cookieService.removeTokens();
      window.location.href = "/admin/login";

      return Promise.reject(refreshError);
    } finally {
      loadingStore.stopLoading();
    }

    loadingStore.stopLoading();

    return Promise.reject(error);
  },
);

export default axiosInstance;
