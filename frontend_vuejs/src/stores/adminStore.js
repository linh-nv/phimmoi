import { defineStore } from "pinia";

export const useAdminStore = defineStore("admin", {
  state: () => ({
    admin: JSON.parse(localStorage.getItem("admin")) || null,
  }),
  actions: {
    setAdmin(adminData) {
      this.admin = adminData;
      localStorage.setItem("admin", JSON.stringify(adminData));
    },
    clearAdmin() {
      this.admin = null;
      localStorage.removeItem("admin");
    },
  },
  getters: {
    isAuthenticated: (state) => !!state.admin,
    getAdmin: (state) => state.admin,
  },
});
