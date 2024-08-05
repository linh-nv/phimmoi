import axiosInstance from "./axiosInstance";
import { useUserStore } from "../stores/userStore";

export async function login(credentials) {
  try {
    const response = await axiosInstance.post("/login", credentials);
    const { access_token, expires_in, admin } = response.data.data;
    const userStore = useUserStore();

    const expirationTime = new Date().getTime() + expires_in * 1000;

    userStore.setUser(admin);
    userStore.setAccessToken(access_token);
    userStore.setTokenExpiration(expirationTime);

    axiosInstance.defaults.headers.common["Authorization"] =
      `Bearer ${access_token}`;

    return response;
  } catch (error) {
    handleError(error);
    throw error;
  }
}

export async function register(userData) {
  try {
    const response = await axiosInstance.post("/register", userData);
    return response;
  } catch (error) {
    handleError(error);
    throw error;
  }
}

export async function refreshToken() {
  try {
    const response = await axiosInstance.post("/refresh");
    return response;
  } catch (error) {
    handleError(error);
    throw error;
  }
}

export function initializeAuth() {
  const userStore = useUserStore();
  if (userStore.accessToken) {
    axiosInstance.defaults.headers.common["Authorization"] =
      `Bearer ${userStore.accessToken}`;

    // Set up token refresh if necessary
    const expirationTime =
      parseInt(userStore.tokenExpiration) - new Date().getTime();
    if (expirationTime > 0) {
      setTimeout(refreshToken, expirationTime - 60000); // refresh 1 minute before expiration
    }
  }
}

function handleError(error) {
  if (error.response) {
    console.error(error.response.data.error || "Request failed.");
  } else {
    console.error("An unexpected error occurred.", error.response);
  }
}
