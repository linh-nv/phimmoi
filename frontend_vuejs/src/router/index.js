import { createRouter, createWebHistory } from "vue-router";
import { useUserStore } from "@/stores/userStore";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      component: () => import("@/layouts/DefaultLayout.vue"),
      children: [
        {
          path: "/",
          name: "home",
          component: () => import("@/views/HomeView.vue"),
        },
        {
          path: "/movie",
          children: [
            {
              path:"",
              name: "movie",
              component: () => import("../views/Movies/MovieView.vue"),
            },
            {
              path:"/form",
              name: "movie-form",
              component: () => import("../views/Movies/MovieForm.vue"),
            }
          ]
        },
      ],
    },
    {
      path: "/",
      component: () => import("@/layouts/AuthLayout.vue"),
      children: [
        {
          path: "/login",
          name: "login",
          component: () => import("@/views/LoginView.vue"),
        },
        {
          path: "/register",
          name: "register",
          component: () => import("@/views/RegisterView.vue"),
        },
      ],
    },
  ],
});

router.beforeEach((to, from, next) => {
  const userStore = useUserStore();
  const isAuthenticated = !!userStore.accessToken;

  if (to.name !== "login" && !isAuthenticated) {
    return next({ name: "login" });
  }

  if (to.name === "login" && isAuthenticated) {
    return next({ name: "home" });
  }

  return next();
});

export default router;
