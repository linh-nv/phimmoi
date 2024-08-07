import "./assets/main.css";

import { createApp } from "vue";
import { createPinia } from "pinia";

import App from "./App.vue";
import router from "./router";
import { initializeAuth } from "@/services/auth";

const app = createApp(App);

app.use(createPinia());
app.use(router);
initializeAuth();
app.mount("#app");
