<template>
  <q-layout view="hHh lpR lFf">
    <q-header elevated v-if="!isLoginPage">
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
          v-if="logueado"
        />

        <q-toolbar-title>{{nameG}}</q-toolbar-title>

        <q-btn clickable :to="{ name: 'clientNotifications' }" flat round dense icon="notifications" @click="changeTitle('Notificaciones')"></q-btn>
        <q-btn clickable :to="{ name: 'clientCart' }" flat round dense icon="shopping_cart" @click="changeTitle('Carrito')"></q-btn>
        <q-btn clickable :to="{ name: 'home' }" flat round dense icon="home" @click="changeTitle('Inicio')"></q-btn>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" bordered>
      <q-list>
        <q-expansion-item
          icon="home"
          label="Menu Principal"
          header-class="bg-blue text-white"
        >
        </q-expansion-item>

        <q-expansion-item icon="settings" label="Parametros">
          <q-card>
            <q-card-section>
              <q-list>
                <q-item
                  clickable
                  v-ripple
                  :to="{ name: 'parametro' }"
                  @click="vermenu"
                >
                  <q-item-section avatar>
                    <q-icon color="primary" name="settings"></q-icon>
                  </q-item-section>
                  <q-item-section>Parametros Generales</q-item-section>
                </q-item>
              </q-list>

              <q-list>
                <q-item
                  clickable
                  v-ripple
                  :to="{ name: 'usuario' }"
                  @click="vermenu"
                >
                  <q-item-section avatar>
                    <q-icon color="primary" name="person_add"></q-icon>
                  </q-item-section>
                  <q-item-section>Usuarios</q-item-section>
                </q-item>
              </q-list>

              <q-list>
                <q-item
                  clickable
                  v-ripple
                  :to="{ name: 'rol' }"
                  @click="vermenu"
                >
                  <q-item-section avatar>
                    <q-icon color="primary" name="supervisor_account"></q-icon>
                  </q-item-section>
                  <q-item-section>Roles</q-item-section>
                </q-item>
              </q-list>

              <q-list>
                <q-item
                  clickable
                  v-ripple
                  :to="{ name: 'clientHome' }"
                  @click="vermenu"
                >
                  <q-item-section avatar>
                    <q-icon color="primary" name="inventory"></q-icon>
                  </q-item-section>
                  <q-item-section>Productos</q-item-section>
                </q-item>
              </q-list>

              <q-list>
                <q-item
                  clickable
                  v-ripple
                  :to="{ name: 'sucursal' }"
                  @click="vermenu"
                >
                  <q-item-section avatar>
                    <q-icon color="primary" name="apartment"></q-icon>
                  </q-item-section>
                  <q-item-section>Sucursales</q-item-section>
                </q-item>
                <q-item
                  clickable
                  v-ripple
                  :to="{ name: 'cliente' }"
                  @click="vermenu"
                >
                  <q-item-section avatar>
                    <q-icon
                      color="primary"
                      name="settings_accessibility"
                    ></q-icon>
                  </q-item-section>
                  <q-item-section>Clientes</q-item-section>
                </q-item>
              </q-list>
              
              <q-list>
                <q-item
                  clickable
                  v-ripple
                  :to="{ name: 'deliverHome' }"
                  @click="vermenu"
                >
                  <q-item-section avatar>
                    <q-icon color="primary" name="local_shipping"></q-icon>
                  </q-item-section>
                  <q-item-section>Repartidor</q-item-section>
                </q-item>
              </q-list>

              <q-list>
                <q-item
                  clickable
                  v-ripple
                  :to="{ name: 'mapPage' }"
                  @click="vermenu"
                >
                  <q-item-section avatar>
                    <q-icon color="primary" name="map"></q-icon>
                  </q-item-section>
                  <q-item-section>Mapa</q-item-section>
                </q-item>
              </q-list>

              <q-list>
                <q-item
                  clickable
                  v-ripple
                  :to="{ name: 'deliverSummary' }"
                  @click="vermenu"
                >
                  <q-item-section avatar>
                    <q-icon color="primary" name="summarize"></q-icon>
                  </q-item-section>
                  <q-item-section>Resumen</q-item-section>
                </q-item>
              </q-list>

              <q-list>
                <q-item
                  clickable
                  v-ripple
                  :to="{ name: 'deliverChat' }"
                  @click="vermenu"
                >
                  <q-item-section avatar>
                    <q-icon color="primary" name="chat"></q-icon>
                  </q-item-section>
                  <q-item-section>Chat</q-item-section>
                </q-item>
              </q-list>

            </q-card-section>
          </q-card>
        </q-expansion-item>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>

    <!-- <q-footer elevated class="bg-grey-8 text-white">
      <q-toolbar> </q-toolbar>
    </q-footer> -->
  </q-layout>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUpdate } from "vue";
import EssentialLink from "components/EssentialLink.vue";
import { useAuthStore } from "stores/auth";
import { useRouter, useRoute } from "vue-router";


const store = useAuthStore();
const router = useRouter();
const nameG = ref("Distribuidora");
const route = useRoute();

const isLoginPage = computed(() => {
  return route.name === 'login';
});

defineOptions({
  name: "MainLayout",
});

const logueado = computed(() => {
  return store.usuario;
});

onBeforeUpdate(async () => {
  //vermenu();
});

function changeTitle(name){
  nameG.value = name; // Actualiza el título dinámicamente
}

function vermenu() {
  //leftDrawerOpen.value = false;
}

function vermenu1() {
  if (store.$state.login == 1) {
    leftDrawerOpen.value = true;
  } else {
    leftDrawerOpen.value = false;
  }
}

const leftDrawerOpen = ref(false);

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}

async function salir() {
  store.$reset();
  router.push({ name: "login" });
  leftDrawerOpen.value = false;
}
</script>

<style scoped>
  header{
    background-color: whitesmoke;
    color: #001D6C;
  }
</style>
