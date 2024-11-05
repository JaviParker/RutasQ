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
        />
      </div>

      <div class="btn">
        <q-btn color="secondary" label="Agregar producto" class="full-width"/>
      </div>
    </div>
  </template>
  
  <script>
import AdminInventoryProduct from 'src/components/AdminInventoryProduct.vue';

  
  export default {
    components: {
      AdminInventoryProduct,
    },
    data() {
      return {
        products: [
          {
            id: 1,
            name: "Jabón Foca 1kg",
            package: "Caja de 6 unidades",
            detail: "Detalle del producto",
            sku: "123456",
            cost: "115.00",
            image: "https://via.placeholder.com/100",
            quantity: 6,
          },
          {
            id: 2,
            name: "Jabón Roma 1kg",
            package: "Caja de 6 unidades",
            detail: "Otro detalle",
            sku: "654321",
            cost: "120.00",
            image: "https://via.placeholder.com/100",
            quantity: 8,
          },
          {
            id: 2,
            name: "Jabón Roma 1kg",
            package: "Caja de 6 unidades",
            detail: "Otro detalle",
            sku: "654321",
            cost: "120.00",
            image: "https://via.placeholder.com/100",
            quantity: 3,
          },
          {
            id: 2,
            name: "Jabón Roma 1kg",
            package: "Caja de 6 unidades",
            detail: "Otro detalle",
            sku: "654321",
            cost: "120.00",
            image: "https://via.placeholder.com/100",
            quantity: 0,
          },
        ],
      };
    },
    methods: {
      handleAddToCart(item) {
        console.log("Producto agregado al carrito:", item);
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
  