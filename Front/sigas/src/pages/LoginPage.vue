<template>
  <img src="~assets/wave2.png" class="wave" alt="login-wave" />
  <div class="row" style="height: 90vh">
    <div class="col-0 col-md-6 flex justify-center content-center">
      <img src="~assets/logo3.png" class="responsive" alt="login-image" />
    </div>
    <div
      v-bind:class="{
        'justify-center': $q.screen.md || $q.screen.sm || $q.screen.xs,
      }"
      class="col-12 col-md-6 flex content-center"
    >
      <q-card
        v-bind:style="$q.screen.lt.sm ? { width: '80%' } : { width: '50%' }"
      >
        <q-card-section>
          <q-avatar size="103px" class="absolute-center shadow-10">
            <img src="~assets/avatar.png" alt="avatar" />
          </q-avatar>
        </q-card-section>
        <q-card-section>
          <div class="q-pt-lg">
            <div class="col text-h6 ellipsis flex justify-center">
              <h2 class="text-h2 text-uppercase q-my-none text-weight-regular">
                Login
              </h2>
            </div>
          </div>
        </q-card-section>
        <q-card-section>
          <q-input label="Username" v-model="username"> </q-input>
          <q-input label="Password" type="password" v-model="password">
          </q-input>
          <div class="q-py-lg">
            <q-btn
              class="full-width"
              color="primary"
              label="Login"
              type="submit"
              @click="ingresar"
              rounded
            ></q-btn>
          </div>
        </q-card-section>
      </q-card>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { api, axios } from "boot/axios";
import { useAuthStore } from "stores/auth";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";

const $q = useQuasar();

const router = useRouter();

const datos = ref([{}]);
const username = ref("");
const password = ref("");
const error = ref("");

const store = useAuthStore();

// Computer
const logueado = computed(() => {
  return store.usuario;
});

async function ingresar() {
  if (!username.value || !password.value) {
    $q.notify({
      type: "negative",
      message: "El Usuario o Contraseña Estan Vacios",
      position: "center",
      actions: [
        {
          icon: "close",
          color: "white",
          round: true,
          handler: () => {
            /* ... */
          },
        },
      ],
    });
    return;
  } else {
    try {
      datos.value = await store.guardarToken(username.value, password.value);

      if (store.$state.login == 1) {
        router.push({ name: "home" });
      } else {
        $q.notify({
          type: "negative",
          message: "El Usuario o Contraseña son Incorrectos",
          position: "center",
          actions: [
            {
              icon: "close",
              color: "white",
              round: true,
              handler: () => {
                /* ... */
              },
            },
          ],
        });
      }
    } catch (error) {
      $q.notify({
        type: "negative",
        message: "Error de Conexion",
        position: "center",
        actions: [
          {
            icon: "close",
            color: "white",
            round: true,
            handler: () => {
              /* ... */
            },
          },
        ],
      });
    }
  }
}
</script>

<style scoped>
.wave {
  position: fixed;
  height: 100%;
  left: 0;
  bottom: 0;
  z-index: -1;
  transform: rotateZ(45deg);
}
</style>
