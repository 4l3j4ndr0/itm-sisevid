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
        path: "/",
        component: () => import("pages/IndexPage.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Dashboard inicial",
            destination: "/",
          },
        },
      },
      {
        path: "/users",
        component: () => import("pages/Users/Index.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Listar usuarios",
            destination: "/users",
          },
        },
      },
      {
        path: "/users/create",
        component: () => import("pages/Users/Create.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Crear usuarios",
            destination: "/users/create",
          },
        },
      },
      {
        path: "/users/edit/:id",
        component: () => import("pages/Users/Edit.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Editar usuarios",
            destination: "/users/edit/:id",
          },
        },
      },
      {
        path: "/facultades",
        component: () => import("pages/Facultades/Index.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Listar facultades",
            destination: "/facultades",
          },
        },
      },
      {
        path: "/facultades/create",
        component: () => import("pages/Facultades/Create.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Crear facultades",
            destination: "/facultades/create",
          },
        },
      },
      {
        path: "/facultades/edit/:id",
        component: () => import("pages/Facultades/Edit.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Editar facultades",
            destination: "/facultades/edit/:id",
          },
        },
      },
      {
        path: "/programs",
        component: () => import("pages/Programas/Index.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Listar programas académicos",
            destination: "/programs",
          },
        },
      },
      {
        path: "/programs/create",
        component: () => import("pages/Programas/Create.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Crear programas académicos",
            destination: "/programs/create",
          },
        },
      },
      {
        path: "/programs/edit/:id",
        component: () => import("pages/Programas/Edit.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Editar programas académicos",
            destination: "/programs/edit/:id",
          },
        },
      },
      {
        path: "/ciclos",
        component: () => import("pages/Ciclos/Index.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Listar ciclos",
            destination: "/ciclos",
          },
        },
      },
      {
        path: "/ciclos/create",
        component: () => import("pages/Ciclos/Create.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Crear ciclos",
            destination: "/ciclos/create",
          },
        },
      },
      {
        path: "/ciclos/edit/:id",
        component: () => import("pages/Ciclos/Edit.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Editar ciclos",
            destination: "/ciclos/edit/:id",
          },
        },
      },
      {
        path: "/asignaturas",
        component: () => import("pages/Asignaturas/Index.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Listar asignaturas",
            destination: "/asignaturas",
          },
        },
      },
      {
        path: "/asignaturas/create",
        component: () => import("pages/Asignaturas/Create.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Crear asignaturas",
            destination: "/asignaturas/create",
          },
        },
      },
      {
        path: "/asignaturas/edit/:id",
        component: () => import("pages/Asignaturas/Edit.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Editar asignaturas",
            destination: "/asignaturas/edit/:id",
          },
        },
      },
      {
        path: "/capitulos",
        component: () => import("pages/Capitulos/Index.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Listar capitulos",
            destination: "/capitulos",
          },
        },
      },
      {
        path: "/capitulos/create",
        component: () => import("pages/Capitulos/Create.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Crear capitulos",
            destination: "/capitulos/create",
          },
        },
      },
      {
        path: "/capitulos/edit/:id",
        component: () => import("pages/Capitulos/Edit.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Editar capitulos",
            destination: "/capitulos/edit/:id",
          },
        },
      },
      {
        path: "/condiciones/create/:program_id/:program_name",
        component: () => import("pages/Condiciones/Create.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Crear condiciones",
            destination: "/condiciones/create/:program_id/:program_name",
          },
        },
      },
      {
        path: "/condiciones/edit/:id",
        component: () => import("pages/Condiciones/Edit.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Editar condiciones",
            destination: "/condiciones/edit/:id",
          },
        },
      },
      {
        path: "/evidencias",
        component: () => import("pages/Evidencias/Index.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Listar evidencias",
            destination: "/evidencias",
          },
        },
      },
      {
        path: "/evidencias/create",
        component: () => import("pages/Evidencias/Create.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Crear evidencias",
            destination: "/evidencias/create",
          },
        },
      },
      {
        path: "/evidencias/edit/:id",
        component: () => import("pages/Evidencias/Edit.vue"),
        meta: {
          breadcrumbs: {
            titulo: "Editar evidencias",
            destination: "/evidencias/edit/:id",
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
