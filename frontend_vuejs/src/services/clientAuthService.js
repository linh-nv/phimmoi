import axios from "axios";
import { cookieService } from "@/services/cookieService";
import { API_BASE_URL } from "@/utils/apisDomain";
import { useClientStore } from "@/stores/clientStore";
import axiosInstance from "./axiosInstance";

export const clientAuthService = {
  async login(credentials) {
    const response = await axiosInstance.post(`${API_BASE_URL}/login`, credentials);
    cookieService.setToken(response.data.data);

    const clientStore = useClientStore();
    clientStore.setClient(response.data.data.data);

    return response.data;
  },

  async logout() {
    await axiosInstance.post(`${AUTH_URL}/logout`);
    cookieService.removeTokens();
    const clientStore = useClientStore();
    clientStore.clearClient();
  },

  async changePassword(credentials) {
    await axiosInstance.post(`${AUTH_URL}/change-password`, credentials);
  },

  async register(credentials) {
    const response = await axios.post(`${AUTH_URL}/register`, credentials);

    return response.data;
  },

  async refreshToken() {
    const refreshToken = cookieService.getRefreshToken();
    if (!refreshToken) throw new Error("No refresh token available");

    const response = await axios.post(`${AUTH_URL}/refresh`, {
      refresh_token: refreshToken,
    });
    cookieService.setToken(response.data.data);

    return response.data;
  },
};
