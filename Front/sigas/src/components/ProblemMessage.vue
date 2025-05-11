<template>
    <q-card class="q-mb-md q-pa-md card">
      <q-card-section>
        <div class="text-h6 text-bold">{{ problem.titulo }}</div>
        <div class="text-subtitle2">
          Publicado por: {{ problem.user.usuarionombre }} ({{ problem.user.rolid == 4 ? "Tienda" : "Repartidor" }})
        </div>
      </q-card-section>
  
      <q-card-section>
        <div>{{ problem.descripcion }}</div>
      </q-card-section>
      <q-btn
          v-if="problem.estado == 0"
          push
          label='Marcar como resuelto'
          color="primary"
          class="q-mt-md"
          @click="markAsResolved"
      />    
  
    <q-card-actions align="right">
        <q-badge :color="problem.estado == 0 ? 'warning' : 'positive'">{{ problem.estado == 0 ? "Pendiente" : "Resuelto" }}</q-badge>
    </q-card-actions>
    </q-card>
  </template>
  
  <script>
    import { api } from 'src/boot/axios';

    var rolName = '';

  export default {
    name: "ProblemMessage",
    props: {
      problem: {
        type: Object,
        required: true,
      },
    },
    methods: {
        async markAsResolved() {
            try {
                const response = await api.put(`/problems/${this.problem.id}`, { estado: 1 });
                console.log(response);
                
                this.$emit("updated");
                this.$q.notify({
                type: "positive",
                message: "Incidencia marcada como resuelta",
                });
            } catch (error) {
                this.$q.notify({
                type: "negative",
                message: "Error al marcar la incidencia como resuelta",
                });
            }
        },
    },
  };
  </script>
  
  <style scoped>
  .text-bold {
    font-weight: bold;
  }
  .card{
    background-color: #DCDCDC;
  }
  </style>
  