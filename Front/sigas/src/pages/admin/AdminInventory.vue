<template>
    <div class="page-container">
      <q-input rounded outlined v-model="text" label="Busca un producto" class="searchbar">
        <template v-slot:prepend>
          <q-icon name="search" />
        </template>
      </q-input>
      <div class="products-grid">
        <AdminInventoryProduct
          v-for="product in products"
          :key="product.id"
          :product="product"
          @add-to-cart="handleAddToCart"
          @edit-product="redirectToEdit"
          @delete-product="deleteProduct"
        />
      </div>

      <div class="btn">
        <q-btn color="secondary" label="Agregar producto" class="full-width" @click="redirectToPost"/>
      </div>
    </div>

    <q-dialog v-model="confirmDialog.visible">
      <q-card>
        <q-card-section class="row items-center">
          <q-icon name="warning" color="red" size="lg" class="q-mr-sm" />
          <span>¿Estás seguro de que deseas eliminar este producto?</span>
        </q-card-section>
        <q-card-actions align="right">
          <q-btn flat label="Cancelar" color="grey" v-close-popup @click="confirmDialog.visible = false" />
          <q-btn flat label="Confirmar" color="red" v-close-popup @click="confirmDialog.confirm()" />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </template>
  
  <script>
import AdminInventoryProduct from 'src/components/AdminInventoryProduct.vue';
import { api } from 'src/boot/axios';
import router from 'src/router';
import dataStore from './dataStore';
  
  export default {
    components: {
      AdminInventoryProduct,
    },
    data() {
      return {
        products: [],
        confirmDialog: {
          visible: false,
          confirm: null, // Función a ejecutar al confirmar
        },
      };
    },
    mounted() {
    this.fetchProducts(); // Llama a la función cuando el componente se monta
    },
    methods: {
      async fetchProducts() {
      try {
        // Hacer una solicitud GET a la API de productos
        const response = await api.get("http://localhost:8090/api/products");

        // Asignar los productos recibidos al array products
        this.products = response.data;
        console.log(this.products);
        console.log(this.clienteId);
        
      } catch (error) {
        console.error("Error al obtener productos:", error);
      }
    },
    redirectToEdit(product) {
      dataStore.selectedProduct = product;
      dataStore.method = 'put';
      this.$router.push({ name: 'adminProducts' });
    },
    redirectToPost(){
        dataStore.method = 'post';
        this.$router.push({ name: 'adminProducts'});
    },
    async deleteProduct(productId) {
    console.log("Intentando borrar producto con ID:", productId); // Debugging

    // Mostrar el diálogo de confirmación
    this.confirmDialog.visible = true;

    // Asignar la función de confirmación
    this.confirmDialog.confirm = async () => {
      try {
        await api.delete(`http://localhost:8090/api/products/${productId}`);
        this.products = this.products.filter(
          (product) => product.id !== productId
        );

        this.$q.notify({
          message: "Producto eliminado correctamente.",
          color: "green",
        });

        this.fetchProducts(); // Recarga la lista de productos
      } catch (error) {
        console.error("Error al eliminar el producto:", error);
        alert("Hubo un error al eliminar el producto.");
      }
    };
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

  .searchbar{
    margin-top: 30px;
    width: 70%;
    min-width: 300px;
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
  