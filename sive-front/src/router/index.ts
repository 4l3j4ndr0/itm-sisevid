import { route } from "quasar/wrappers";
import {
  createMemoryHistory,
  createRouter,
  createWebHashHistory,
  createWebHistory,
} from "vue-router";
import ApiService from "src/Helpers/ApiService";
import routes from "./routes";
import { useUserStore } from "../stores/User";
import { useQuasar } from "quasar";
/*
 * If not building with SSR mode, you can
 * directly export the Router instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Router instance.
 */

export default route(function ({ store }) {
  const user = useUserStore();
  const $q = useQuasar();
  const createHistory = process.env.SERVER
    ? createMemoryHistory
    : process.env.VUE_ROUTER_MODE === "history"
    ? createWebHistory
    : createWebHashHistory;

  const Router = createRouter({
    scrollBehavior: () => ({ left: 0, top: 0 }),
    routes,

    // Leave this as is and make changes in quasar.conf.js instead!
    // quasar.conf.js -> build -> vueRouterMode
    // quasar.conf.js -> build -> publicPath
    history: createHistory(process.env.VUE_ROUTER_BASE),
  });

  Router.beforeEach((to, from, next) => {
    if (to.path !== "/login") {
      if (user.bearer_token) {
        //Validar permisos
        const pathEnd = to.matched[to.matched.length - 1].path;
        const existe = user.permisosUser.find((u) => u.path === pathEnd);
        if (existe && existe !== undefined) next();
        else next(from.path);
      } else {
        next({
          path: "/login",
        });
      }
    } else {
      if (to.path === "/login" && user.bearer_token) {
        next({
          path: "/dashboard",
        });
      }
      next();
    }
  });

  return Router;
});
