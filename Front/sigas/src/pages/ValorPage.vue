<template>
  <div>
    <q-btn
      color="primary"
      label="Loginnnn"
      type="submit"
      @click="ingresar"
      rounded
    ></q-btn>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { api, axios } from "boot/axios";
import { useAuthStore } from "stores/auth";

const datos = ref([]);

const store = useAuthStore();

function ingresar() {
  //alert($store.state.usuario.fecha);
  //alert($store.state.token);
}
</script>

<style></style>
