<template>
    <div class="page-container">
      <div class="products-grid">
        <DeliverOrder
          v-for="order in orders"
          :key="order.id"
          :order="order"
        />
      </div>
      <div class="btn">
        <q-btn color="secondary" label="Registrar cliente" class="full-width" @click="redirectToRegister"/>
      </div>
    </div>
  </template>
  
  <script>
  import { api } from 'src/boot/axios';
import DeliverOrder from 'src/components/DeliverOrder.vue';
import dataStore from '../admin/dataStore';
  
  export default {
    components: {
      DeliverOrder,
    },
    data() {
      return {
        orders: [],
      };
    },
    mounted() {
      this.fetchOrders();
    },
    methods: {
      handleAddToCart(item) {
        console.log("Producto agregado al carrito:", item);
      },
      redirectToRegister(){
        dataStore.rolUploading = 'deliver';
        this.$router.push({name: 'adminCheckUsers'});
      },
      async fetchOrders() {
        try {
          const response = await api.get('/get-pedidos-con-tienda-info');
          if (response.data.status === 'success') {
            this.orders = response.data.data;
          } else {
            this.$q.notify({
              type: 'negative',
              message: 'Error al cargar los pedidos',
            });
          }
        } catch (error) {
          console.error(error);
          this.$q.notify({
            type: 'negative',
            message: 'Ocurrió un error al intentar cargar los pedidos.',
          });
        }
      },
    },
  };
  </script>

  <style scoped>
  .page-container {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .carousel-container {
    width: 100%;
    max-width: 1200px;
    
  }

  .products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); /* Define el tamaño mínimo de los elementos y los distribuye automáticamente */
    width: 100%;
    max-width: 1200px;
    margin: 20px auto; /* Centra la cuadrícula horizontalmente */
  }

  .btn{
    align-self: end;
    position: fixed;
    bottom: 0;
    margin: 5%;
  }

  @media (max-width: 768px) {
    .products-grid {
      grid-template-columns: 1fr; /* En pantallas pequeñas, se muestran como lista */
    }
  }
  </style>
  