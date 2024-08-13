import axios from "axios";
import { cookieService } from "@/services/cookieService";
import { AUTH_URL } from "@/utils/apisDomain";
import { useUserStore } from "@/stores/userStore";

export const authService = {
  async login(credentials) {
    const response = await axios.post(`${AUTH_URL}/login`, credentials);
    cookieService.setToken(response.data.data);

    const userStore = useUserStore();
    userStore.setUser(response.data.data.data);

    return response.data;
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
