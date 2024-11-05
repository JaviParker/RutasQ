<template>
    <q-page class="q-pa-md">
      <!-- Sección de productos seleccionados -->
      <div class="selected-products-container q-mb-md">
        <div class="text-h6">Productos seleccionados:</div>
        <div class="selected-products-list">
          {{ selectedProductsText }}
        </div>
      </div>
  
      <!-- Botón de regreso o finalización -->
      <div class="q-mb-md">
        <q-btn label="Finalizar" color="primary" :to="{ name: 'adminCreateNotifcation' }" />
      </div>
  
      <!-- Lista de productos disponibles para seleccionar -->
      <div class="products-grid">
        <ProductItemClient
          v-for="product in products"
          :key="product.id"
          :product="product"
          @add-to-cart="handleAddToSelectedProducts"
        />
      </div>
    </q-page>
  </template>
  
  <script>
  import ProductItemClient from '../../components/ProductItemClient.vue';
  import { api } from '../../boot/axios';
  
  export default {
    components: {
      ProductItemClient
    },
    data() {
      return {
        products: [], // Lista de productos traídos de la base de datos
        selectedProducts: [] // Lista de productos seleccionados
      };
    },
    computed: {
      // Texto formateado de productos seleccionados
      selectedProductsText() {
        return this.selectedProducts
          .map((product) => `${product.nombre} / ${product.cantidad} unidades`)
          .join(' + ');
      }
    },
    mounted() {
      this.fetchProducts(); // Llama a la función al montar el componente
    },
    methods: {
      // Obtiene productos de la base de datos
      async fetchProducts() {
        try {
          const response = await api.get('http://localhost:8090/api/products');
          this.products = response.data;
        } catch (error) {
          console.error('Error al obtener productos:', error);
        }
      },
      // Agrega el producto seleccionado a la lista de productos seleccionados
      handleAddToSelectedProducts(product) {
        if (!this.selectedProducts.includes(product)) {
          this.selectedProducts.push(product);
        }
      },
      // Regresa a la página AdminCreateNotification
      goBackToAdminCreateNotification() {
        this.$router.push({ name: 'adminCreateNotification' });
      }
    }
  };
  </script>
  
  <style scoped>
  .selected-products-container {
    text-align: center;
    margin-bottom: 16px;
  }
  
  .selected-products-list {
    font-weight: bold;
    color: #333;
    margin-top: 8px;
  }
  
  .products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 16px;
    width: 100%;
    max-width: 1200px;
    margin: auto;
  }
  </style>
  