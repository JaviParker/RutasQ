<template>
  <div class="q-pa-md">
    <!-- Lista de notificaciones -->
    <div v-for="(notification, index) in notifications" :key="index" class="q-mb-md">
      <NotificationOffer :offer="notification" @add-to-cart="handleAddToCart" />
    </div>
  </div>
</template>

<script>
// Importamos el componente NotificationOffer
import NotificationOffer from "components/NotificationOffer.vue";

export default {
  name: "NotificationsPage",
  components: {
    NotificationOffer,
  },
  data() {
    return {
      // Arreglo de notificaciones simuladas
      notifications: [
        {
          type: "Oferta",
          name: "Paquetes de jabones",
          products: [
            "Jabón Foca 1kg - 3 unidades",
            "Jabón Roma 1kg - 3 unidades",
          ],
          description:
            "Llévate 3 unidades de jabón Roma de 1kg y 3 unidades de jabón Foca de 1kg por $150 pesos.",
          image: "https://via.placeholder.com/150",
          cost: "145.00"
        },
        {
          type: "Oferta",
          name: "Descuento en Detergentes",
          products: [
            "Detergente Ace 500g - 2 unidades",
            "Detergente Ariel 500g - 2 unidades",
          ],
          description:
            "Obtén 2 unidades de Detergente Ace y 2 unidades de Detergente Ariel por solo $120 pesos.",
          image: "https://via.placeholder.com/150",
          cost: "350.00"
        },
        {
          type: "Aviso",
          name: "Nuevas promociones de limpieza",
          products: [],
          description:
            "Mantente atento a nuestras nuevas promociones en productos de limpieza. ¡No te las pierdas!",
          image: "https://via.placeholder.com/150", 
          cost: "84.00"
        },
        {
          type: "Oferta",
          name: "Promoción en productos lácteos",
          products: [
            "Leche Lala 1L - 6 unidades",
            "Yogurt Danone 1kg - 2 unidades",
          ],
          description:
            "Llévate 6 unidades de leche Lala y 2 unidades de Yogurt Danone por $200 pesos.",
          image: "https://via.placeholder.com/150",
          cost: "400.00"
        },
      ],
    };
  },
  methods: {
    handleAddToCart(offerData) {
      console.log("Producto agregado al carrito:", offerData);
      // Aquí podrías manejar la lógica de agregar al carrito
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
</style>
