import { defineStore } from "pinia";
import { authService } from "@/services/auth";
import axiosInstance from "@/services/axiosInstance";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: null,
    accessToken: null,
    refreshToken: null,
  }),
  getters: {
    isAuthenticated: (state) => !!state.user,
  },
  actions: {
    setUser(user) {
      this.user = user;
    },
    setTokens(accessToken, refreshToken) {
      this.accessToken = accessToken;
      this.refreshToken = refreshToken;
      localStorage.setItem("accessToken", accessToken);
      localStorage.setItem("refreshToken", refreshToken);
      axiosInstance.defaults.headers.common["Authorization"] =
        `Bearer ${accessToken}`;
    },
    clearAuth() {
      this.user = null;
      this.accessToken = null;
      this.refreshToken = null;
      localStorage.removeItem("accessToken");
      localStorage.removeItem("refreshToken");
      delete axiosInstance.defaults.headers.common["Authorization"];
    },
    async login(credentials) {
      try {
        const response = await authService.login(credentials);
        this.setUser(response.data.admin);
        this.setTokens(response.data.access_token, response.data.refresh_token);
        return response;
      } catch (error) {
        console.error("Login failed:", error);
        throw error;
      }
    },
    async register(userData) {
      try {
        const response = await authService.register(userData);
        this.setUser(response.data.admin);
        this.setTokens(response.data.access_token, response.data.refresh_token);
        return response;
      } catch (error) {
        console.error("Registration failed:", error);
        throw error;
      }
    },
    async refreshToken() {
      try {
        const response = await authService.refreshToken();
        this.setTokens(response.data.access_token, response.data.refresh_token);
        return response;
      } catch (error) {
        console.error("Token refresh failed:", error);
        this.clearAuth();
        throw error;
      }
    },
    async logout() {
      
      this.clearAuth();
    },
  },
});
