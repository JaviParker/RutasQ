<template>
    <div>
      <div class="products-grid">
        <CartProduct
        v-for="product in products"
        :key="product.id"
        :product="product"
        :initialQuantity="product.cantidad"
        @update-quantity="updateQuantity"
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
            <p class="q-mt-lg">Descuento aplicado</p>
            <p class="q-mt-xs">Ahorraste ${{  this.descuento  }}</p>
        </div>
        <div class="col-6">
            <strong>Pagar</strong> <br>
            <q-btn :to="{ name: 'clientPay' }" color="primary" label="Ahora" class="full-width btn"/>
            <q-btn color="green" label="En entrega" class="full-width btn" @click="registrarCompra"/>
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
        descuento: 0,
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
          
          this.descuento = response.data.pedido.descuento || 0;
          
          this.total = response.data.total - this.descuento;
          console.log(this.total);
          
        } catch (error) {
          console.error("Error al cargar el carrito:", error);
        }
      },
      updateQuantity({ productId, quantity }) {
        const productIndex = this.products.findIndex((item) => item.id === productId);

        if (productIndex !== -1) {
          if (quantity === 0) {
            // Eliminar el producto del carrito
            this.products.splice(productIndex, 1);
          } else {
            // Actualizar la cantidad localmente
            this.products[productIndex].cantidad = quantity;
          }

          // Recalcular el total dinámicamente
          this.total = this.products.reduce((acc, item) => acc + item.cantidad * item.cost, 0);
        }
      },
      handleAddToCart(item) {
        console.log("Producto agregado al carrito:", item);
      },
      async registrarCompra() {
        try {
          const productos = this.products.map(product => ({
            id: product.id,
            cantidad: product.cantidad,
          }));

          const payload = {
            productos,
            total: this.total.toString(),
          };

          await api.post('/historial-compra', payload);

          // Cambiar el estado del pedido a no confirmado
          await api.put(`/pedido/${this.clienteId}/enviar`);

          // Limpiar carrito local y recargar
          this.products = [];
          this.total = 0;

          this.$q.notify({
            type: 'positive',
            message: 'Compra registrada y carrito actualizado',
          });

          this.$router.push({ name: 'clientHome' });
        } catch (error) {
          console.error("Error al registrar la compra:", error);
          this.$q.notify({
            type: 'negative',
            message: 'Error al procesar la compra',
          });
        }
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
  