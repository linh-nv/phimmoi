import { defineStore } from "pinia";

export const useClientStore = defineStore("client", {
  state: () => ({
    client: JSON.parse(localStorage.getItem("client")) || null,
  }),
  actions: {
    setClient(clientData) {
      this.client = clientData;
      localStorage.setItem("client", JSON.stringify(clientData));
    },
    clearClient() {
      this.client = null;
      localStorage.removeItem("client");
    },
  },
  getters: {
    isAuthenticated: (state) => !!state.client,
    getClient: (state) => state.client,
  },
});
