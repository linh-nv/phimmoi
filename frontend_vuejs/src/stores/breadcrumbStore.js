import { defineStore } from "pinia";

export const useBreadcrumbStore = defineStore("breadcrumb", {
  state: () => ({
    itemTitle: localStorage.getItem("itemTitle") || "",
  }),
  actions: {
    setItemTitle(title) {
      this.itemTitle = title;
      localStorage.setItem("itemTitle", title);
    },
    clearItemTitle() {
      this.itemTitle = "";
      localStorage.removeItem("itemTitle");
    },
  },
});
