<template>
    <q-page class="q-pa-md">
      <div class="q-gutter-md">
        <ProblemMessage
          v-for="problem in problems"
          :key="problem.id"
          :problem="problem"
          @updated="fetchProblems"
        />
      </div>
    </q-page>
  </template>
  
  <script>
  import ProblemMessage from "src/components/ProblemMessage.vue";
  import { api } from "src/boot/axios";
  
  export default {
    name: "adminProblems",
    components: {
      ProblemMessage,
    },
    data() {
      return {
        problems: [],
      };
    },
    methods: {
      async fetchProblems(){
        try {
            const response = await api.get("/problems");
            this.problems = response.data;
            console.log(this.problems);
            
        } catch (error) {
            console.error("Error al obtener problemas:", error);
        }
      }
    },
    mounted() {
        this.fetchProblems();
    },
  };
  </script>
  