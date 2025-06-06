import { createRouter, createWebHistory } from "vue-router";
import { cookieService } from "@/services/cookieService";
import { updateMetaTitle } from "@/utils/updateMetaTitle";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/admin",
      meta: { requiresAuth: true, title: "Admin" },
      children: [
        {
          path: "",
          component: () => import("@/layouts/AdminLayout.vue"),
          children: [
            {
              path: "",
              name: "home",
              component: () => import("@/views/Admin/HomeView.vue"),
            },
            {
              path: "/account-information",
              name: "account-information",
              component: () => import("@/views/Admin/ChangePassword.vue"),
            },
            {
              path: "movie",
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
                      component: () =>
                        import("@/views/Admin/Movies/MovieForm.vue"),
                    },
                    {
                      path: ":slug",
                      name: "movie-update",
                      component: () =>
                        import("@/views/Admin/Movies/MovieForm.vue"),
                    },
                  ],
                },
                {
                  path: "detail/:slug",
                  name: "movie-detail",
                  component: () =>
                    import("@/views/Admin/Movies/MovieDetail.vue"),
                },

                // Episode
                {
                  path: "episode",
                  children: [
                    {
                      path: ":slug",
                      name: "episode",
                      component: () =>
                        import("@/views/Admin/Episodes/EpisodeView.vue"),
                    },
                    {
                      path: "form",
                      children: [
                        {
                          path: ":slug",
                          name: "episode-create",
                          component: () =>
                            import("@/views/Admin/Episodes/EpisodeForm.vue"),
                        },
                        {
                          path: "update/:slug/:id",
                          name: "episode-update",
                          component: () =>
                            import("@/views/Admin/Episodes/EpisodeForm.vue"),
                        },
                      ],
                    },
                  ],
                },
              ],
            },
            {
              path: "category",
              children: [
                {
                  path: "",
                  name: "category",
                  component: () =>
                    import("@/views/Admin/Categories/CategoryView.vue"),
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
              path: "genre",
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
                      component: () =>
                        import("@/views/Admin/Genres/GenreForm.vue"),
                    },
                    {
                      path: ":slug",
                      name: "genre-update",
                      component: () =>
                        import("@/views/Admin/Genres/GenreForm.vue"),
                    },
                  ],
                },
              ],
            },
            {
              path: "country",
              children: [
                {
                  path: "",
                  name: "country",
                  component: () =>
                    import("@/views/Admin/Countries/CountryView.vue"),
                },
                {
                  path: "form",
                  children: [
                    {
                      path: "",
                      name: "country-create",
                      component: () =>
                        import("@/views/Admin/Countries/CountryForm.vue"),
                    },
                    {
                      path: ":slug",
                      name: "country-update",
                      component: () =>
                        import("@/views/Admin/Countries/CountryForm.vue"),
                    },
                  ],
                },
              ],
            },
          ],
        },
        // Auth route
        {
          path: "",
          component: () => import("@/layouts/BaseLayout.vue"),
          children: [
            {
              path: "login",
              name: "login",
              component: () => import("@/views/Admin/LoginView.vue"),
            },
            {
              path: "register",
              name: "register",
              component: () => import("@/views/Admin/RegisterView.vue"),
            },
          ],
        },
      ],
    },
    {
      path: "/",
      meta: { requiresAuth: false, title: "Linhphim" },
      component: () => import("@/layouts/HomeLayout.vue"),
      children: [
        {
          path: "",
          name: "trangchu",
          component: () => import("@/views/Client/HomePage.vue"),
          meta: { title: "Trang chủ" },
        },
        {
          path: "dangky",
          name: "dangky",
          component: () => import("@/views/Client/RegisterPage.vue"),
          meta: { title: "Đăng ký" },
        },
      ],
    },
    {
      path: "/",
      meta: { requiresAuth: false, title: "Linhphim" },
      component: () => import("@/layouts/ClientLayout.vue"),
      children: [
        {
          path: "favorite",
          name: "favorite",
          component: () => import("@/views/Client/FavoritePage.vue"),
          meta: { title: "Tủ phim" },
        },
        {
          path: "change-password",
          name: "changepassword",
          component: () => import("@/views/Client/ChangePassword.vue"),
          meta: { title: "Cập nhật thông tin" },
        },
        {
          path: "the-loai/:slug",
          name: "theloai",
          component: () => import("@/views/Client/CategoryPage.vue"),
          meta: { title: "Thể loại" },
        },
        {
          path: "danh-muc/:slug",
          name: "danhmuc",
          component: () => import("@/views/Client/GenrePage.vue"),
          meta: { title: "Danh mục" },
        },
        {
          path: "quoc-gia/:slug",
          name: "quocgia",
          component: () => import("@/views/Client/CountryPage.vue"),
          meta: { title: "Quốc gia" },
        },
        {
          path: "phim/:slug",
          name: "phim",
          component: () => import("@/views/Client/MoviePage.vue"),
          meta: { title: "Xem phim" },
        },
        {
          path: "xem-chung",
          name: "xemchung",
          component: () => import("@/views/Client/PremiereRoom.vue"),
          meta: { title: "Xem chung" },
        },
        {
          path: "xem-chung/:slug",
          name: "xemchung-detail",
          component: () => import("@/views/Client/CreatePremiereRoom.vue"),
          meta: { title: "Tạo phòng xem chung" },
        },
      ],
    },
  ],
});

router.afterEach((to) => {
  const newTitle = to.query.title;
  updateMetaTitle(newTitle);
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    const token = cookieService.getRefreshToken();

    if (token) {
      if (to.name === "login") {
        next({ name: "home" });
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
  } else {
    next();
  }
});

export default router;
