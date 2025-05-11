<template>
  <div class="q-pa-md products-grid">
    <div align="center" class="q-mb-lg">
      <strong style="font-size: 1.5rem;">Puntos: {{ usuarioPuntos }}</strong>
    </div>
    <!-- Lista de notificaciones -->
    <div v-for="(notification, index) in notifications" :key="index" class="q-mb-md">
      <NotificationOffer :offer="notification" :puntos="usuarioPuntos" @add-to-cart="handleAddToCart" />
    </div>
  </div>
</template>

<script>
// Importamos el componente NotificationOffer
import NotificationOffer from "components/NotificationOffer.vue";
import { api } from '../../boot/axios';
import { useAuthStore } from "stores/auth";

const store = useAuthStore();
export default {
  name: "NotificationsPage",
  components: {
    NotificationOffer,
  },
  data() {
    return {
      // Arreglo de notificaciones simuladas
      notifications: [],
      usuarioPuntos: 0,
    };
  },
  mounted() {
    this.fetchNotifications(); // Llama a la función cuando el componente se monta
  },
  methods: {
    async fetchNotifications() {
      try {
        // Hacer una solicitud GET a la API de productos
        const response = await api.get('http://localhost:8090/api/notifications');
        const response2 = await api.get(`/usuarios/${store.usuario.usuarioid}/puntos`);
        this.usuarioPuntos = response2.data.puntos;
        // Asignar los productos recibidos al array products
        this.notifications = response.data;
        console.log(this.notifications);
        
      } catch (error) {
        console.error('Error al obtener notificaciones:', error);
      }
    },
  },
};
</script>

<style scoped>
h2 {
  margin-bottom: 20px;
  font-size: 1em;
}

.notification-list {
  display: flex;
  flex-direction: column;
}

.notification{
  max-width: 450px;
  min-width: 360px;
  background-color: #DCDCDC;
  border-radius: 12px;
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(450px, 1fr)); /* Define el tamaño mínimo de los elementos y los distribuye automáticamente */
  grid-gap: 0px;
  width: 100%;
  max-width: 1200px;
  margin: 20px auto; /* Centra la cuadrícula horizontalmente */
}

@media (max-width: 768px) {
  .products-grid {
    grid-template-columns: 1fr; /* En pantallas pequeñas, se muestran como lista */
  }
}
</style>
