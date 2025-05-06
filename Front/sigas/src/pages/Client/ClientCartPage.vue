<template>
    <div>
      <div class="products-grid">
        <CartProduct
        v-for="product in products"
        :key="product.id"
        :product="product"
        :initialQuantity="product.cantidad"
        />
      </div>
      <!-- <ProductItemClient
        
        @add-to-cart="handleAddToCart"
      /> -->
    </div>
    <div class="total row full-width">
        <div class="col-6">
            <strong>Total</strong> <br>
            <b>${{ this.total }}</b>
        </div>
        <div class="col-6">
            <strong>Pagar</strong> <br>
            <q-btn :to="{ name: 'clientPay' }" color="primary" label="Ahora" class="full-width btn"/>
        </div>
    </div>
  </template>
  
  <script>
  import CartProduct from 'src/components/CartProduct.vue';
  import { api } from "../../boot/axios";
  import { useAuthStore } from "stores/auth";
  import { computed } from "vue";

  const store = useAuthStore();

  export default {
    components: {
      CartProduct
    },
    data() {
      return {
        products: [],
      };
    },
    setup() {
      const clienteId = computed(() => store.usuario?.usuarioid);
      return {
        clienteId,
      };
    },
    mounted() {
      this.obtenerCarrito();
    },
    methods: {
      async obtenerCarrito() {
        try {
          const response = await api.get(`/pedido/${this.clienteId}/ver-carrito`);
          this.products = response.data.productos;
          console.log(this.products);
          
          this.total = response.data.total;
          console.log(this.total);
          
        } catch (error) {
          console.error("Error al cargar el carrito:", error);
        }
      },
      handleAddToCart(item) {
        console.log("Producto agregado al carrito:", item);
      },
    },
  };
  </script>

  <style scoped>
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
  