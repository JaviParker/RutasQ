import { route } from "quasar/wrappers";
import {
  createRouter,
  createMemoryHistory,
  createWebHistory,
  createWebHashHistory,
} from "vue-router";
import routes from "./routes";

import { useAuthStore } from "stores/auth";

//import { store } from "stores/auth";

/*
 * If not building with SSR mode, you can
 * directly export the Router instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Router instance.
 */

export default route(function (/* { store, ssrContext } */) {
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

  const store = useAuthStore();

  Router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.libre)) {
      next();
    } else if (store.usuario && store.usuario.rol == "Administrador") {
      if (to.matched.some((record) => record.meta.administrador)) {
        next();
      }
    } else if (store.usuario && store.usuario.rol == "Consulta") {
      if (to.matched.some((record) => record.meta.consulta)) {
        next();
      }
    } else if (store.usuario && store.usuario.rol == "Captura") {
      if (to.matched.some((record) => record.meta.captura)) {
        next();
      }
    } else if (store.usuario && store.usuario.rol == "Supervisor") {
      if (to.matched.some((record) => record.meta.supervisor)) {
        next();
      }
    } else {
      next({
        name: "login",
      });
    }
  });

  return Router;
});
