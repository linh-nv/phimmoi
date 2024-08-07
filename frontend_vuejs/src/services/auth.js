import axiosInstance from "@/services/axiosInstance";

const AUTH_ENDPOINTS = {
  LOGIN: '/admin/login',
  REGISTER: '/admin/register',
  REFRESH: '/admin/refresh',
};

export const authService = {
  async login(credentials) {
    const response = await axiosInstance.post(AUTH_ENDPOINTS.LOGIN, credentials);
    return response.data;
  },

  async register(userData) {
    const response = await axiosInstance.post(AUTH_ENDPOINTS.REGISTER, userData);
    return response.data;
  },

  async refreshToken() {
    const response = await axiosInstance.post(AUTH_ENDPOINTS.REFRESH);
    return response.data;
  },
};