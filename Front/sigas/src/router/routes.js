import { createRouter } from "vue-router";

const routes = [
  {
    path: "/",
    component: () => import("layouts/MainLayout.vue"),
    children: [
      {
        name: "login",
        path: "/login",
        component: () => import("pages/LoginPage.vue"),
        meta: {
          libre: true,
        },
      },
      {
        name: "valor",
        path: "/valor",
        component: () => import("pages/ValorPage.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
        },
      },
      {
        name: "home",
        path: "/home",
        component: () => import("pages/Client/ClientHome.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
        },
      },
      {
        name: "parametro",
        path: "/parametro",
        component: () => import("pages/ParametroPage.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
        },
      },
      {
        name: "usuario",
        path: "/usuario",
        component: () => import("pages/UsuarioPage.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
        },
      },
      {
        name: "clientHome",
        path: "/clientHome",
        component: () => import("src/pages/Client/ClientHome.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
        },
      },
      {
        name: "clientNotifications",
        path: "/clientNotifications",
        component: () => import("src/pages/Client/ClientNotificationsPage.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
        },
      },
      {
        name: "clientCart",
        path: "/clientCart",
        component: () => import("src/pages/Client/ClientCartPage.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
        },
      },
      {
        name: "clientPay",
        path: "/clientPay",
        component: () => import("src/pages/Client/ClientPayPage.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
        },
      },
      {
        name: "deliverHome",
        path: "/deliverHome",
        component: () => import("src/pages/Deliver/DeliverHome.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
        },
      },
      {
        name: "orderDetails",
        path: "/orderDetails",
        component: () => import("src/pages/Deliver/DeliverOrderDetails.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
        },
      },
      {
        name: "mapPage",
        path: "/mapPage",
        component: () => import("src/pages/Deliver/MapPage.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
        },
      },
      {
        name: "deliverSummary",
        path: "/deliverSummary",
        component: () => import("src/pages/Deliver/DeliverSummary.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
        },
      },
      {
        name: "deliverInventory",
        path: "/deliverInventory",
        component: () => import("src/pages/Deliver/DeliverInventory.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
        },
      },
      {
        name: "deliverChat",
        path: "/deliverChat",
        component: () => import("src/pages/Deliver/DeliverChat.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
        },
      },
      {
        name: "rol",
        path: "/rol",
        component: () => import("pages/RolPage.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
        },
      },
      {
        name: "sucursal",
        path: "/sucursal",
        component: () => import("pages/SucursalPage.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
        },
      },
      {
        name: "cliente",
        path: "/cliente",
        component: () => import("pages/ClientePage.vue"),
        meta: {
          administrador: true,
          consulta: true,
          captura: true,
          supervisor: true,
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

/*
router.beforeEach((to) => {
  if (to.meta.requiresAuth && !authStore.authUser) {
    // for example here if the route needs authentication and if the user isn't authenticated
    return { name: "login" };
  }

  if (to.name == "login" && authStore.authUser) {
    return { name: "dashboard" };
  }

  if (to.meta.notfound) {
    if (authStore.authUser) {
      return { name: "dashboard" };
    } else {
      return { name: "home" };
    }
  }
});

*/

/*
routes.beforeEach((to, from, next) => {
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
*/

export default routes;
