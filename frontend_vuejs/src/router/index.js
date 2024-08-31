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
          component: () => import("@/views/Admin/HomeView.vue"),
        },
        {
          path: "/account-information",
          name: "account-information",
          component: () => import("@/views/Admin/ChangePassword.vue"),
        },
        {
          path: "/movie",
          children: [
            {
              path: "",
              name: "movie",
              component: () => import("@/views/Admin/Movies/MovieView.vue"),
            },
            {
              path: "form",
              children: [
                {
                  path: "",
                  name: "movie-create",
                  component: () => import("@/views/Admin/Movies/MovieForm.vue"),
                },
                {
                  path: ":slug",
                  name: "movie-update",
                  component: () => import("@/views/Admin/Movies/MovieForm.vue"),
                },
              ],
            },
            {
              path: "detail/:slug",
              name: "movie-detail",
              component: () => import("@/views/Admin/Movies/MovieDetail.vue"),
            },
            
            // Episode
            {
              path: "episode",
              children: [
                {
                  path: ":slug",
                  name: "episode",
                  component: () => import("@/views/Admin/Episodes/EpisodeView.vue"),
                },
                {
                  path: "form",
                  children: [
                    {
                      path: ":slug",
                      name: "episode-create",
                      component: () => import("@/views/Admin/Episodes/EpisodeForm.vue"),
                    },
                    {
                      path: "update/:slug/:id",
                      name: "episode-update",
                      component: () => import("@/views/Admin/Episodes/EpisodeForm.vue"),
                    },
                  ],
                },
              ],
            },
          ],
        },
        {
          path: "/category",
          children: [
            {
              path: "",
              name: "category",
              component: () => import("@/views/Admin/Categories/CategoryView.vue"),
            },
            {
              path: "form",
              children: [
                {
                  path: "",
                  name: "category-create",
                  component: () =>
                    import("@/views/Admin/Categories/CategoryForm.vue"),
                },
                {
                  path: ":slug",
                  name: "category-update",
                  component: () =>
                    import("@/views/Admin/Categories/CategoryForm.vue"),
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
              component: () => import("@/views/Admin/Genres/GenreView.vue"),
            },
            {
              path: "form",
              children: [
                {
                  path: "",
                  name: "genre-create",
                  component: () => import("@/views/Admin/Genres/GenreForm.vue"),
                },
                {
                  path: ":slug",
                  name: "genre-update",
                  component: () => import("@/views/Admin/Genres/GenreForm.vue"),
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
              component: () => import("@/views/Admin/Countries/CountryView.vue"),
            },
            {
              path: "form",
              children: [
                {
                  path: "",
                  name: "country-create",
                  component: () => import("@/views/Admin/Countries/CountryForm.vue"),
                },
                {
                  path: ":slug",
                  name: "country-update",
                  component: () => import("@/views/Admin/Countries/CountryForm.vue"),
                },
              ],
            },
          ],
        },
      ],
    },

    // Auth route
    {
      path: "/",
      component: () => import("@/layouts/AuthLayout.vue"),
      children: [
        {
          path: "/login",
          name: "login",
          component: () => import("@/views/Admin/LoginView.vue"),
        },
        {
          path: "/register",
          name: "register",
          component: () => import("@/views/Admin/RegisterView.vue"),
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
