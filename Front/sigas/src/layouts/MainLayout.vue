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

        <q-toolbar-title>{{ nameG }}</q-toolbar-title>

        <q-btn v-if="tipoUsuario === 4" clickable :to="{ name: 'clientNotifications' }" flat round dense icon="notifications" @click="changeTitle('Notificaciones')"></q-btn>
        <q-btn v-if="tipoUsuario === 4" clickable :to="{ name: 'clientCart' }" flat round dense icon="shopping_cart" @click="changeTitle('Carrito')"></q-btn>
        <q-btn v-if="tipoUsuario === 4" clickable :to="{ name: 'clientHome' }" flat round dense icon="home" @click="changeTitle('Inicio')"></q-btn>
        
        <q-btn v-if="tipoUsuario === 5" clickable :to="{ name: 'deliverChat' }" flat round dense icon="chat" @click="changeTitle('Chat de repartidores')"></q-btn>
        <q-btn v-if="tipoUsuario === 5" clickable :to="{ name: 'deliverHome' }" flat round dense icon="home" @click="changeTitle('Inicio')"></q-btn>

        <q-btn v-if="tipoUsuario === 1" clickable :to="{ name: 'adminCreateNotifcation' }" flat round dense icon="notification_add" @click="changeTitle('Notificaciones')"></q-btn>
        <q-btn v-if="tipoUsuario === 1" clickable :to="{ name: 'adminHome' }" flat round dense icon="home" @click="changeTitle('Inicio')"></q-btn>

      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" bordered>
      <strong v-if="tipoUsuario === 1">Administrador</strong>
      <strong v-if="tipoUsuario === 4">Tienda</strong>
      <strong v-if="tipoUsuario === 5">Repartidor</strong>


      <q-list>
        <!-- <q-expansion-item icon="home" label="Menu Principal" header-class="bg-blue text-white"></q-expansion-item> -->
        <q-list v-if="tipoUsuario === 1">
            <q-item clickable v-ripple :to="{ name: 'adminHome' }" @click="changeTitle('Inicio')">
              <q-item-section avatar><q-icon color="primary" name="home"></q-icon></q-item-section>
              <q-item-section>Inicio</q-item-section>
            </q-item>
          </q-list>

          <q-list v-if="tipoUsuario === 1">
            <q-item clickable v-ripple :to="{ name: 'adminInventory' }" @click="changeTitle('Inventario')">
              <q-item-section avatar><q-icon color="primary" name="inventory"></q-icon></q-item-section>
              <q-item-section>Inventario</q-item-section>
            </q-item>
          </q-list>

          <q-list v-if="tipoUsuario === 1">
            <q-item clickable v-ripple :to="{ name: 'adminCreateNotifcation' }" @click="changeTitle('Enviar notificación')">
              <q-item-section avatar><q-icon color="primary" name="add_alert"></q-icon></q-item-section>
              <q-item-section>Enviar notificación</q-item-section>
            </q-item>
          </q-list>

          <q-list v-if="tipoUsuario === 1">
            <q-item clickable v-ripple :to="{ name: 'adminStadistics' }" @click="changeTitle('Historial anual')">
              <q-item-section avatar><q-icon color="primary" name="bar_chart"></q-icon></q-item-section>
              <q-item-section>Historial anual</q-item-section>
            </q-item>
          </q-list>

          <q-list v-if="tipoUsuario === 1">
            <q-item clickable v-ripple :to="{ name: 'adminProblems' }" @click="changeTitle('Incidencias')">
              <q-item-section avatar><q-icon color="primary" name="feedback"></q-icon></q-item-section>
              <q-item-section>Incidencias</q-item-section>
            </q-item>
          </q-list>

        <q-expansion-item v-if="tipoUsuario === 1" icon="settings" label="Parametros">
          <q-list>
            <q-item clickable v-ripple :to="{ name: 'usuario' }" @click="changeTitle('Usuarios')">
              <q-item-section avatar><q-icon color="primary" name="person_add"></q-icon></q-item-section>
              <q-item-section>Usuarios</q-item-section>
            </q-item>
          </q-list>

          <q-list>
            <q-item clickable v-ripple :to="{ name: 'rol' }" @click="changeTitle('Roles')">
              <q-item-section avatar><q-icon color="primary" name="supervisor_account"></q-icon></q-item-section>
              <q-item-section>Roles</q-item-section>
            </q-item>
          </q-list>

          <q-list>
            <q-item clickable v-ripple :to="{ name: 'sucursal' }" @click="changeTitle('Sucursales')">
              <q-item-section avatar><q-icon color="primary" name="apartment"></q-icon></q-item-section>
              <q-item-section>Sucursales</q-item-section>
            </q-item>
          </q-list>

          <q-list>
            <q-item clickable v-ripple :to="{ name: 'adminCheckUsers' }" @click="changeTitle('Clientes')">
              <q-item-section avatar><q-icon color="primary" name="settings_accessibility"></q-icon></q-item-section>
              <q-item-section>Clientes</q-item-section>
            </q-item>
          </q-list>

          <q-list>
            <q-item clickable v-ripple :to="{ name: 'adminInventory' }" @click="changeTitle('Inventario')">
              <q-item-section avatar><q-icon color="primary" name="inventory"></q-icon></q-item-section>
              <q-item-section>Inventario</q-item-section>
            </q-item>
          </q-list>
        </q-expansion-item>

        <q-list v-if="tipoUsuario === 4">
          <q-item clickable v-ripple :to="{ name: 'clientHome' }" @click="changeTitle('Productos')">
            <q-item-section avatar><q-icon color="primary" name="inventory"></q-icon></q-item-section>
            <q-item-section>Productos</q-item-section>
          </q-item>
        </q-list>

        <q-list v-if="tipoUsuario === 4">
          <q-item clickable v-ripple :to="{ name: 'clientCart' }" @click="changeTitle('Carrito')">
            <q-item-section avatar><q-icon color="primary" name="shopping_cart"></q-icon></q-item-section>
            <q-item-section>Carrito</q-item-section>
          </q-item>
        </q-list>

        <!-- <q-list v-if="tipoUsuario === 4">
          <q-item clickable v-ripple :to="{ name: 'clientNotifications' }" @click="changeTitle('Notificaciones y ofertas')">
            <q-item-section avatar><q-icon color="primary" name="notifications"></q-icon></q-item-section>
            <q-item-section>Notificaciones y ofertas</q-item-section>
          </q-item>
        </q-list> -->

        <q-list v-if="tipoUsuario === 4">
          <q-item clickable v-ripple :to="{ name: 'addProblem' }" @click="changeTitle('Crear incidencia')">
            <q-item-section avatar><q-icon color="primary" name="feedback"></q-icon></q-item-section>
            <q-item-section>Crear incidencia</q-item-section>
          </q-item>
        </q-list>

        <q-list v-if="tipoUsuario === 4">
          <q-item clickable v-ripple :to="{ name: 'clientNotifications' }" @click="changeTitle('Crear incidencia')">
            <q-item-section avatar><q-icon color="primary" name="notifications"></q-icon></q-item-section>
            <q-item-section>Ofertas/Marketing</q-item-section>
          </q-item>
        </q-list>

        <q-list v-if="tipoUsuario === 5">
          <q-item clickable v-ripple :to="{ name: 'deliverHome' }" @click="changeTitle('Pedidos')">
            <q-item-section avatar><q-icon color="primary" name="local_shipping"></q-icon></q-item-section>
            <q-item-section>Pedidos</q-item-section>
          </q-item>
        </q-list>

        <q-list v-if="tipoUsuario === 5">
          <q-item clickable v-ripple :to="{ name: 'mapPage' }" @click="changeTitle('Mapa')">
            <q-item-section avatar><q-icon color="primary" name="map"></q-icon></q-item-section>
            <q-item-section>Mapa</q-item-section>
          </q-item>
        </q-list>

        <q-list v-if="tipoUsuario === 5">
          <q-item clickable v-ripple :to="{ name: 'deliverSummary' }" @click="changeTitle('Resumen')">
            <q-item-section avatar><q-icon color="primary" name="summarize"></q-icon></q-item-section>
            <q-item-section>Resumen</q-item-section>
          </q-item>
        </q-list>

        <q-list v-if="tipoUsuario === 5">
          <q-item clickable v-ripple :to="{ name: 'deliverChat' }" @click="changeTitle('Chat')">
            <q-item-section avatar><q-icon color="primary" name="chat"></q-icon></q-item-section>
            <q-item-section>Chat</q-item-section>
          </q-item>
        </q-list>
        
        <q-list v-if="tipoUsuario === 5">
          <q-item clickable v-ripple :to="{ name: 'addProblem' }" @click="changeTitle('Crear incidencia')">
            <q-item-section avatar><q-icon color="primary" name="feedback"></q-icon></q-item-section>
            <q-item-section>Crear incidencia</q-item-section>
          </q-item>
        </q-list>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { useAuthStore } from "stores/auth";
import { useRouter, useRoute } from "vue-router";

const store = useAuthStore();
const router = useRouter();
const nameG = ref("Inicio");
const route = useRoute();

const isLoginPage = computed(() => route.name === 'login');
const logueado = computed(() => store.usuario);

// Variable para el tipo de usuario actual
const tipoUsuario = computed(() => store.usuario?.rolid);

// Verificar si el rol está correctamente cargado al montar el componente
onMounted(() => {
  if (tipoUsuario.value === 1) {
    nameG.value = "Administrador";
  } else if (tipoUsuario.value === 4) {
    nameG.value = "Tienda";
  } else if (tipoUsuario.value === 5) {
    nameG.value = "Repartidor";
  }
});

// Monitorea los cambios en `store.usuario` y actualiza `tipoUsuario` cuando cambie
watch(() => store.usuario, (newVal) => {
  console.log("Cambio detectado en store.usuario:", newVal);
  if (!newVal) {
    console.error("Error: Usuario no encontrado en store.");
  } else {
    console.log("Rol de usuario:", newVal.tipo_usuario);
  }
});

const changeTitle = (title) => {
  nameG.value = title; // Cambiar el título
};

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
header {
  background-color: whitesmoke;
  color: #001D6C;
}
strong{
  font-size: 2rem;
  display: flex;
  justify-self: center;
  font-weight: bold;
  padding: 20px;
  margin: 10px;
  text-align: center;
}
</style>
