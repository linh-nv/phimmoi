import { defineStore } from "pinia";
import { ref } from "vue";

export const useUserStore = defineStore("user", () => {
  const user = ref(localStorage.getItem("user") || null);
  const accessToken = ref(localStorage.getItem("access_token") || null);
  const tokenExpiration = ref(localStorage.getItem("token_expiration") || null);

  function setUser(newUser) {
    user.value = newUser;
    localStorage.setItem("user", JSON.stringify(newUser));
  }

  function setAccessToken(token) {
    accessToken.value = token;
    localStorage.setItem("access_token", token);
  }

  function setTokenExpiration(expiration) {
    tokenExpiration.value = expiration;
    localStorage.setItem("token_expiration", expiration);
  }

  function clearAuthData() {
    user.value = null;
    accessToken.value = null;
    tokenExpiration.value = null;
    localStorage.removeItem("user");
    localStorage.removeItem("access_token");
    localStorage.removeItem("token_expiration");
  }

  function logout() {
    clearAuthData();
  }

  return {
    user,
    accessToken,
    tokenExpiration,
    setUser,
    setAccessToken,
    setTokenExpiration,
    clearAuthData,
    logout,
  };
});
