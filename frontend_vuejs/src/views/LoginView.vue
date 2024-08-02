<template>
  <div>
    <h1>hehe</h1>
    <button @click="login">Login</button>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axiosInstance from "@/services/axiosInstance";
import { setToken, getToken, removeToken } from "@/services/auth";

const token = ref(getToken());
const login = async () => {
  try {
    const response = await axiosInstance.post("/admin/login", {
      email: "admin@gmail.com",
      password: "12345678",
    });
    const tokenData = response.data.data;
    setToken(tokenData.access_token, tokenData.expires_in);
    token.value = tokenData.access_token;
  } catch (error) {
    console.error("Login failed", error);
  }
};
</script>
