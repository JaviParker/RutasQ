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
        <q-btn v-if="tipoUsuario === 4" clickable :to="{ name: 'clientCart' }" flat round dense icon="shopping_cart" @click="changeTitle('Carrito')">
          <q-badge v-if="badgeCount > 0" color="red" floating>{{ badgeCount }}</q-badge>
        </q-btn>
        <q-btn v-if="tipoUsuario === 4" clickable :to="{ name: 'clientHome' }" flat round dense icon="home" @click="changeTitle('Inicio')"></q-btn>
        
        <!-- Icono de clima si el usuario es tipo 5 -->
        <q-tooltip v-if="tipoUsuario === 5 && weatherInfo" :delay="500">
          {{ weatherInfo.traduccion }}
        </q-tooltip>

        <q-btn
          v-if="tipoUsuario === 5 && weatherInfo"
          :icon="getWeatherIcon()"
          flat
          round
          dense
          :label="weatherInfo.conditionTraducido"
        />


        <q-tooltip v-if="tipoUsuario === 5 && weatherInfo" :delay="500">
          {{ weatherInfo.traduccion }}
        </q-tooltip>


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
import { useCartStore } from "src/stores/cart";
import { useRouter, useRoute } from "vue-router";
import { api } from "src/boot/axios";

// Stores
const authStore = useAuthStore();
const cartStore = useCartStore();

// Vue Router
const router = useRouter();
const route = useRoute();
const weatherInfo = ref(null);


// Reactive data
const nameG = ref("Inicio");
const leftDrawerOpen = ref(false);
const isLoginPage = computed(() => route.name === "login");
const logueado = computed(() => authStore.usuario);

// Computed values
const tipoUsuario = computed(() => authStore.usuario?.rolid);
const clienteId = computed(() => authStore.usuario?.usuarioid);
const badgeCount = computed(() => cartStore.cartItemCount);

// Functions
const changeTitle = (title) => {
  nameG.value = title;
};

const toggleLeftDrawer = () => {
  leftDrawerOpen.value = !leftDrawerOpen.value;
};

const salir = async () => {
  authStore.$reset();
  router.push({ name: "login" });
  leftDrawerOpen.value = false;
};

const fetchCartTotal = async (clienteId) => {
  try {
    const response = await api.get(`/totalEnCarrito/${clienteId}`);
    console.log(response);
    
    const totalEnCarrito = response.data.total;
    // console.log(totalEnCarrito);
    
    cartStore.setCartCount(totalEnCarrito); // Actualizamos en el store de carrito
    
  } catch (error) {
    console.error("Error al cargar el total del carrito:", error);
  }
};

// Watchers
watch(
  () => authStore.usuario,
  (newVal) => {
    if (newVal) {
      console.log("Cambio detectado en store.usuario:", newVal);
      console.log("Rol de usuario:", newVal.rolid);
    } else {
      console.error("Error: Usuario no encontrado en store.");
    }
  }
);

// Lifecycle hooks

// Verificar si el rol está correctamente cargado al montar el componente
onMounted(() => {
  if (tipoUsuario.value === 4) {
    nameG.value = "Tienda";
  } else if (tipoUsuario.value === 1) {
    nameG.value = "Administrador";
  }

  
  // Cargar el total del carrito al montar el componente
  if (clienteId.value) {
    fetchCartTotal(clienteId.value);

});


async function fetchWeather() {
  const url = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/durango?unitGroup=us&include=days%2Ccurrent&key=V9SS255HUXL8BQ7K6JQJ4CXYU&contentType=json";
  try {
    const response = await fetch(url);
    const data = await response.json();

    const condition = data.days[0]?.conditions || "Desconocido";
    const description = data.days[0]?.description || "Sin descripción";

    weatherInfo.value = {
      condition,
      description,
      traduccion: traducirClima(condition, description),
      conditionTraducido: traducirCondition(condition)
    };


    console.log(condition);
    console.log(description);
  } catch (error) {
    console.error("Error al obtener clima:", error);
  }
}

function traducirCondition(condition) {
  const cond = condition?.toLowerCase() || "";

  if (cond.includes("clear")) {
    return "Despejado";
  }
  if (cond.includes("partially") && cond.includes("rain")) {
    return "Lluvia, parcialmente nublado";
  }
  if (cond.includes("partially")) {
    return "Parcialmente nublado";
  }

  return "Clima no especificado";
}

function traducirClima(condition, description) {
  const cond = condition?.toLowerCase() || "";
  const desc = description?.toLowerCase() || "";

  if (cond.includes("partially") || desc.includes("partly")) {
    if (desc.includes("late afternoon rain")) {
      return "Parcialmente nublado con lluvia por la tarde.";
    } else if (desc.includes("clearing in the afternoon")) {
      return "Parcialmente nublado, despejando por la tarde.";
    } else if (desc.includes("throughout the day")) {
      return "Parcialmente nublado durante el día.";
    }
    return "Parcialmente nublado.";
  }

  if (cond.includes("clear")) {
    return "Despejado durante todo el día.";
  }

  return "Condiciones climáticas no especificadas.";
}



function getWeatherIcon() {
  if (weatherInfo.value?.condition === "Partially cloudy") {
    return "cloud_queue"; // ícono de nube
  }
  return "wb_sunny"; // ícono de sol por defecto
}

// Monitorea los cambios en `store.usuario` y actualiza `tipoUsuario` cuando cambie
watch(() => store.usuario, (newVal) => {
  console.log("Cambio detectado en store.usuario:", newVal);
  if (!newVal) {
    console.error("Error: Usuario no encontrado en store.");
  } else {
    console.log("Rol de usuario:", newVal.tipo_usuario);

  }
});
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
