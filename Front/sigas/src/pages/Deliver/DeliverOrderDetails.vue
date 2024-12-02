<template>
    <div class="page-container">
      <div class="products-grid">
        <DeliverDetailsProduct
          v-for="product in products"
          :key="product.id"
          :product="product"
          @add-to-cart="handleAddToCart"
        />
      </div>
      <div class="total row full-width">
        <div class="col-6">
            <strong>Total</strong> <br>
            <b>${{ total }}</b>
        </div>
        <div class="col-6">
            <q-btn color="green" label="Confirmar entrega" class="full-width btn" @click="confirmarPedido"/> <br>
            <q-btn color="red" label="No entregado" class="full-width btn"/>
        </div>
    </div>
    </div>
  </template>
  
  <script>
  import { api } from 'src/boot/axios';
import DeliverDetailsProduct from 'src/components/DeliverDetailsProduct.vue';
import { useAuthStore } from 'src/stores/auth';
import { computed } from 'vue';
  
  const store = useAuthStore();

  export default {
    components: {
      DeliverDetailsProduct
    },
    props: {
      orderId: {
        type: String,
        required: true,
      },
      userId: {
        type: String,
        required: true,
      },
    },
    setup() {
      const clienteId = computed(() => store.usuario?.usuarioid);
      return {
        clienteId,
      };
    },
    data() {
      return {
        products: [],
        total: 87.00,
      };
    },
    mounted() {
      this.fetchOrderDetails();
    },
    methods: {
      handleAddToCart(item) {
        console.log("Producto agregado al carrito:", item);
      },
      async fetchOrderDetails() {
        try {
          const response = await api.get(`/pedidos/${this.orderId}/productos`);
          const { productos, total } = response.data;
          this.products = productos;
          this.total = total;
          console.log(response);

        } catch (error) {
          console.error('Error al obtener los detalles del pedido:', error);
        }
      },
      async confirmarPedido(){
        try {
          
          let response = await api.put(`/pedido/${this.userId}/confirmar`);
          console.log(response);
          this.$q.notify({
            type: 'positive',
            message: 'Entrega confirmada',
          });

          this.$router.push({ name: 'deliverHome' });
        } catch (error) {
          this.$q.notify({
            type: 'negative',
            message: 'Error al confirmar',
          });
        }
      }
    },
  };
  </script>

  <style scoped>
  .page-container {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .total{
      background-color: #DCDCDC;
      position: fixed;
      bottom: 0;
      height: 23%;
      padding: 10px;
    }
    strong{
      font-size: 1.5rem;
    }
    b{
      font-size: 2.4rem;
    }
    .btn{
      margin: 5px;
      max-width: 150px;
    }

  .products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); /* Define el tamaño mínimo de los elementos y los distribuye automáticamente */
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
  