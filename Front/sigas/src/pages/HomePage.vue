<template>
  <q-page class="flex flex-center">
    <img
      alt="Quasar logo"
      src="~assets/login.png"
      style="width: 400px; height: 400px"
    />
  </q-page>
</template>

<script setup>
import { useAuthStore } from "stores/auth";
import { ref } from "vue";

const datos = ref([]);

const store = useAuthStore();

defineOptions({
  name: "HomePage",
});
</script>
