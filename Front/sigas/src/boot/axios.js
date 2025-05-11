import { boot } from "quasar/wrappers";
import axios from "axios";

// Instancia para interactuar con la API de Laravel
const api = axios.create({ baseURL: "http://rutaslaravel:8090/api/" });

// Instancia para interactuar con el servidor Express de Mercado Pago
const mpApi = axios.create({ baseURL: "http://localhost:3000/" });

export default boot(({ app }) => {
  app.config.globalProperties.$axios = axios;
  app.config.globalProperties.$api = api;
  app.config.globalProperties.$mpApi = mpApi; // Añadir la nueva instancia al objeto global de Vue
});

export { axios, api, mpApi };
