import { boot } from "quasar/wrappers";
import axios from "axios";

// const api = axios.create({ baseURL: "http://rutaslaravel:8090/api/" });
const api = axios.create({ baseURL: "http://192.168.1.3:8090/api/" });

export default boot(({ app }) => {
  app.config.globalProperties.$axios = axios;
  app.config.globalProperties.$api = api;
});

export { axios, api };
