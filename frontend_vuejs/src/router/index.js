import { createRouter, createWebHistory } from "vue-router";
import { cookieService } from "@/services/cookieService";

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
              path: "",
              name: "movie",
              component: () => import("@/views/Movies/MovieView.vue"),
            },
            {
              path: "form",
              name: "movie-form",
              component: () => import("@/views/Movies/MovieForm.vue"),
              children: [
                {
                  path: ":slug",
                  name: "movie-update",
                }
              ]
            },
            {
              path: "detail/:slug",
              name: "movie-detail",
              component: () => import("@/views/Movies/MovieDetail.vue"),
            }
          ],
        },
        {
          path: "/category",
          children: [
            {
              path: "",
              name: "category",
              component: () => import("@/views/Categories/CategoryView.vue"),
            },
            {
              path: "form",
              name: "category-form",
              component: () => import("@/views/Categories/CategoryForm.vue"),
            },
          ],
        },
        {
          path: "/genre",
          children: [
            {
              path: "",
              name: "genre",
              component: () => import("@/views/Movies/MovieView.vue"),
            },
            {
              path: "form",
              name: "genre-form",
              component: () => import("@/views/Movies/MovieForm.vue"),
            },
          ],
        },
        {
          path: "/country",
          children: [
            {
              path: "",
              name: "country",
              component: () => import("@/views/Movies/MovieView.vue"),
            },
            {
              path: "form",
              name: "country-form",
              component: () => import("@/views/Movies/MovieForm.vue"),
            },
          ],
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
  const token = cookieService.getRefreshToken();

  if (token) {
    if (to.name === "login") {
      next("/");
    } else {
      next();
    }
  } else {
    if (to.name !== "login") {
      next({ name: "login", query: { redirect: to.fullPath } });
    } else {
      next();
    }
  }
});

export default router;
