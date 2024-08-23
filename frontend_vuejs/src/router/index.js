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
              children: [
                {
                  path: "",
                  name: "movie-create",
                  component: () => import("@/views/Movies/MovieForm.vue"),
                },
                {
                  path: ":slug",
                  name: "movie-update",
                  component: () => import("@/views/Movies/MovieForm.vue"),
                },
              ],
            },
            {
              path: "detail/:slug",
              name: "movie-detail",
              component: () => import("@/views/Movies/MovieDetail.vue"),
            },
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
              children: [
                {
                  path: "",
                  name: "category-create",
                  component: () => import("@/views/Categories/CategoryForm.vue"),
                },
                {
                  path: ":slug",
                  name: "category-update",
                  component: () => import("@/views/Categories/CategoryForm.vue"),
                },
              ],
            },
          ],
        },
        {
          path: "/genre",
          children: [
            {
              path: "",
              name: "genre",
              component: () => import("@/views/Genres/GenreView.vue"),
            },
            {
              path: "form",
              children: [
                {
                  path: "",
                  name: "genre-create",
                  component: () => import("@/views/Genres/GenreForm.vue"),
                },
                {
                  path: ":slug",
                  name: "genre-update",
                  component: () => import("@/views/Genres/GenreForm.vue"),
                },
              ],
            },
          ],
        },
        {
          path: "/country",
          children: [
            {
              path: "",
              name: "country",
              component: () => import("@/views/Countries/CountryView.vue"),
            },
            {
              path: "form",
              children: [
                {
                  path: "",
                  name: "country-create",
                  component: () => import("@/views/Countries/CountryForm.vue"),
                },
                {
                  path: ":slug",
                  name: "country-update",
                  component: () => import("@/views/Countries/CountryForm.vue"),
                },
              ],
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
