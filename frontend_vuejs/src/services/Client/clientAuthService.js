import axios from "axios";
import { clientCookieService } from "./clientCookieService";
import { API_BASE_URL } from "@/utils/apisDomain";
import { useClientStore } from "@/stores/clientStore";
import clientAxiosInstance from "./clientAxiosInstance";

export const clientAuthService = {
  async login(credentials) {
    const response = await clientAxiosInstance.post(`${API_BASE_URL}/login`, credentials);
    
    clientCookieService.setToken(response.data.data);

    const clientStore = useClientStore();
    clientStore.setClient(response.data.data.data);

    return response.data;
  },

  async logout() {
    await clientAxiosInstance.post(`/logout`);
    clientCookieService.removeTokens();
    const clientStore = useClientStore();
    clientStore.clearClient();
  },

  async changePassword(credentials) {
    await clientAxiosInstance.post(`/change-password`, credentials);
  },

  async register(credentials) {
    const response = await axios.post(`/register`, credentials);

    return response.data;
  },

  async refreshToken() {
    const refreshToken = clientCookieService.getRefreshToken();
    if (!refreshToken) throw new Error("No refresh token available");

    const response = await axios.post(`/refresh`, {
      refresh_token: refreshToken,
    });
    clientCookieService.setToken(response.data.data);

    return response.data;
  },
};
