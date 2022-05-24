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
      {
        path: "/users/edit/:id",
        component: () => import("pages/Users/Edit.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/facultades",
        component: () => import("pages/Facultades/Index.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/facultades/create",
        component: () => import("pages/Facultades/Create.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/facultades/edit/:id",
        component: () => import("pages/Facultades/Edit.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/programs",
        component: () => import("pages/Programas/Index.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/programs/create",
        component: () => import("pages/Programas/Create.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/programs/edit/:id",
        component: () => import("pages/Programas/Edit.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/ciclos",
        component: () => import("pages/Ciclos/Index.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/ciclos/create",
        component: () => import("pages/Ciclos/Create.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/ciclos/edit/:id",
        component: () => import("pages/Ciclos/Edit.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/asignaturas",
        component: () => import("pages/Asignaturas/Index.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/asignaturas/create",
        component: () => import("pages/Asignaturas/Create.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/asignaturas/edit/:id",
        component: () => import("pages/Asignaturas/Edit.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/capitulos",
        component: () => import("pages/Capitulos/Index.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/capitulos/create",
        component: () => import("pages/Capitulos/Create.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/capitulos/edit/:id",
        component: () => import("pages/Capitulos/Edit.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/condiciones/create/:program_id/:program_name",
        component: () => import("pages/Condiciones/Create.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/condiciones/edit/:id",
        component: () => import("pages/Condiciones/Edit.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/evidencias",
        component: () => import("pages/Evidencias/Index.vue"),
        meta: {
          breadcrumbs: {
            label: "Crear usuarios",
            icon: "people",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/evidencias/create",
        component: () => import("pages/Evidencias/Create.vue"),
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
