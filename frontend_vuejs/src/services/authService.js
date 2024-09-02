import axios from "axios";
import { cookieService } from "@/services/cookieService";
import { AUTH_URL } from "@/utils/apisDomain";
import { useAdminStore } from "@/stores/adminStore";
import axiosInstance from "./axiosInstance";

export const authService = {
  async login(credentials) {
    const response = await axios.post(`${AUTH_URL}/login`, credentials);
    cookieService.setToken(response.data.data);

    const adminStore = useAdminStore();
    adminStore.setAdmin(response.data.data.data);

    return response.data;
  },

  async logout() {
    await axiosInstance.post(`${AUTH_URL}/logout`);
    cookieService.removeTokens();
    const adminStore = useAdminStore();
    adminStore.clearAdmin();
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
