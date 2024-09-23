import { defineStore } from "pinia";
import { jwtDecode } from "jwt-decode";
import { api, axios } from "boot/axios";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    token: null,
    usuario: null,
    login: 0,
  }),

  getters: {
    setToken: (state) => state.token,
    setUsuario: (state) => state.usuario,
  },

  actions: {
    async guardarToken(usuariomail, usuariopassword) {
      await api
        .post("usuarios/login", {
          usuariomail: usuariomail,
          usuariopassword: usuariopassword,
        })
        .then((respuesta) => {
          return respuesta.data;
        })
        .then((data) => {
          this.token = data.token;
          this.usuario = jwtDecode(data.token);
          this.login = 1;
          //localStorage.setItem("token", token);
        })
        .catch((err) => {
          this.login = 0;
        });
    },

    // Limpia el token
    async salir() {
      this.token = null;
      this.usuario = null;
      this.login = 0;
      //console.log()

      //localStorage.removeItem("token");
    },
  },
  presist: true,
});
