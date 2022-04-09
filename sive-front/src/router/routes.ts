import { RouteRecordRaw } from "vue-router";

const routes: RouteRecordRaw[] = [
  {
    path: "/login",
    component: () => import("pages/Login.vue"),
  },
  {
    path: "/",
    component: () => import("layouts/MainLayout.vue"),
    children: [
      {
        path: "/dashboard",
        component: () => import("pages/IndexPage.vue"),
        meta: {
          breadcrumbs: {
            label: "Inicio",
            icon: "home",
            destination: "/",
          },
        },
      },
      {
        path: "/users",
        component: () => import("pages/Users/Index.vue"),
        meta: {
          breadcrumbs: {
            label: "Usuarios",
            icon: "people",
            destination: "/users",
          },
        },
      },
      {
        path: "/users/create",
        component: () => import("pages/Users/Create.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
];

export default routes;