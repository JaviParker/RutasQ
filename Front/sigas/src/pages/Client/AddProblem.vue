<template>
    <q-page class="q-pa-md">
      <q-form @submit="submitProblem" class="q-gutter-md">
        <q-input
          v-model="titulo"
          label="Título"
          outlined
          required
          maxlength="100"
        />
        <q-select
          v-model="tipo"
          :options="tipos"
          label="Tipo de incidencia"
          outlined
          required
        />
        <q-input
          v-model="descripcion"
          label="Descripción"
          type="textarea"
          outlined
          required
          maxlength="255"
        />
        <q-btn
          label="Enviar"
          type="submit"
          color="primary"
          :loading="loading"
        />
      </q-form>
    </q-page>
  </template>
  
  <script>
  import { api } from "src/boot/axios";
  import { useAuthStore } from "stores/auth";
  
  export default {
    name: "AddProblem",
    data() {
      return {
        titulo: "",
        tipo: "",
        descripcion: "",
        tipos: ["Error técnico", "Problema logístico", "Otro"], // Opciones de tipo
        loading: false,
      };
    },
    methods: {
      async submitProblem() {
        try {
          this.loading = true;
  
          // Obtener el usuario actual desde el store
          const store = useAuthStore();
          const usuarioid = store.usuario.usuarioid;
          const usuariorol = store.usuario.rolid;

          // Crear incidencia
          const payload = {
            usuarioid,
            tipo: this.tipo,
            titulo: this.titulo,
            descripcion: this.descripcion,
            estado: 0, // Estado inicial
          };
          
          console.log(payload);
          
          const response = await api.post("/problems", payload);
          console.log(response);
        

          this.$q.notify({
            type: "positive",
            message: "Incidencia subida exitosamente",
          });
  
          // Limpiar el formulario
          this.titulo = "";
          this.tipo = "";
          this.descripcion = "";
          usuariorol == 4 ? this.$router.push({name: 'clientHome'}) : this.$router.push({name: 'deliverHome'}) 
        } catch (error) {
          this.$q.notify({
            type: "negative",
            message: "Error al subir la incidencia",
          });
        } finally {
          this.loading = false;
        }
      },
    },
  };
  </script>
  