import { store } from "../stores/auth";

export default async ({ router, store }) => {
  router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.libre)) {
      next();
    } else if (
      store.state.usuario &&
      store.state.usuario.rol == "Administrador"
    ) {
      if (to.matched.some((record) => record.meta.administrador)) {
        next();
      }
    } else if (store.state.usuario && store.state.usuario.rol == "Consulta") {
      if (to.matched.some((record) => record.meta.consulta)) {
        next();
      }
    } else if (store.state.usuario && store.state.usuario.rol == "Captura") {
      if (to.matched.some((record) => record.meta.captura)) {
        next();
      }
    } else if (store.state.usuario && store.state.usuario.rol == "Supervisor") {
      if (to.matched.some((record) => record.meta.supervisor)) {
        next();
      }
    } else {
      next({
        name: "login",
      });
    }
  });
};
