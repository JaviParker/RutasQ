<template>
  <div class="payment-card">
    <!-- Productos y sus detalles -->
    
    <div class="header">
      <p class="product-name">Resumen de compra</p>
    </div>

    <div class="products-list">
      <div v-for="product in products" :key="product.id" class="product-detail">
        <p class="product-name">{{ product.name }}</p>
        <p class="product-price">x{{ product.cantidad }}</p>
      </div>
    </div>

    <div class="total-container">
      <p class="total-amount">Total</p>
      <p class="total-amount">${{ total.toFixed(2) }}</p>
    </div>

    <button class="pay-button" @click="crearPreferenciaYPagar">
    
    </button>
  </div>
</template>

<script>
import { computed } from "vue";
import { useAuthStore } from "stores/auth";
import { api } from "../../boot/axios";
import { mpApi } from "../../boot/axios"; // Importa la instancia correcta

export default {
  name: 'PaymentPage',
  data() {
    return {
      total: 0,
      products: [],
      preferenceId: null,
    };
  },
  setup() {
    const store = useAuthStore();
    const clienteId = computed(() => store.usuario?.usuarioid);
    return { clienteId };
  },
  mounted() {
    this.cargarCarrito();
    this.cargarMercadoPagoSDK();
  },
  methods: {
    cargarMercadoPagoSDK() {
      const script = document.createElement('script');
      script.src = "https://sdk.mercadopago.com/js/v2";
      script.onload = () => this.configurarBotonPago(); // Asegura que el botón se configura solo después de cargar el SDK
      document.body.appendChild(script);
    },
    async cargarCarrito() {
      try {
        const carritoResponse = await api.get(`/pedido/${this.clienteId}/ver-carrito`);
        this.products = carritoResponse.data.productos;
        this.total = carritoResponse.data.total;
      } catch (error) {
        console.error("Error al cargar el carrito:", error);
      }
    },
    async crearPreferenciaYPagar() {
      try {
        const prefResponse = await mpApi.post('/create_preference', { total: this.total });
        this.preferenceId = prefResponse.data.id;
        this.configurarBotonPago();
      } catch (error) {
        console.error("Error al crear la preferencia y configurar el pago:", error);
      }
    },
    configurarBotonPago() {
      if (window.MercadoPago) {
        const mp = new MercadoPago('TEST-5dcdedf4-88b0-4943-a1f5-4934ad2d6e8e', {
          locale: 'es-MX'
        });

        // Vaciar el contenedor del botón antes de configurar uno nuevo
        const container = document.querySelector('.pay-button');
        container.innerHTML = '';  // Esto elimina cualquier contenido previo

        mp.checkout({
          preference: {
            id: this.preferenceId
          },
          render: {
            container: '.pay-button',  // Selector del botón de pago
            label: 'Pagar',  // Texto del botón
          },
        });
      }
    }

  }
};
</script>


<style scoped>
.header{
  border-bottom: 1px solid rgba(0,0,0,0.1);
  padding: 0px 20px;
  padding-top: 20px;
}
.header p{
  font-size: 20px;
  color: #333;
  font-weight: bold;
}
.payment-card {
  background-color: white;
  border-radius: 15px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  width: 300px;
  margin: auto;
  margin-top: 2rem;
}

.products-list {
  padding: 0px 20px;
  padding-top: 20px;
  border-bottom: 1px solid rgba(0,0,0,0.1);
}

.product-detail {
  display: flex;
  justify-content: space-between;
  margin-bottom: 5px;
}

.product-name {
  font-size: 16px;
  color: #333;
}

.product-price {
  font-size: 16px;
  color: #666;
}

.total-container {
  display: flex;
  justify-content: space-between;
  padding: 0px 20px;
  padding-top: 20px;
}

.total-amount {
  font-size: 16px;
  color: #333;
  font-weight: bold;

}

.pay-button {
  background-color: white;
  color: none;
  border: none;
  padding: 10px 20px 20px 20px;
  border-radius: 10px;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>