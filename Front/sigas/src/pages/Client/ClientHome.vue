<template>
    <div class="page-container">
      <div class="carousel-container">
        <CategoryCarousel />
      </div>
      <div class="products-grid">
        <ProductItemClient
          v-for="product in products"
          :key="product.id"
          :product="product"
          @add-to-cart="handleAddToCart"
        />
      </div>
    </div>
  </template>
  
  <script>
  import CategoryCarousel from 'src/components/CategoryCarousel.vue';
  import ProductItemClient from '../../components/ProductItemClient.vue';
  
  export default {
    components: {
      ProductItemClient,
      CategoryCarousel
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
          },
          {
            id: 2,
            name: "Jabón Roma 1kg",
            package: "Caja de 6 unidades",
            detail: "Otro detalle",
            sku: "654321",
            cost: "120.00",
            image: "https://via.placeholder.com/100",
          },
          {
            id: 2,
            name: "Jabón Roma 1kg",
            package: "Caja de 6 unidades",
            detail: "Otro detalle",
            sku: "654321",
            cost: "120.00",
            image: "https://via.placeholder.com/100",
          },
          {
            id: 2,
            name: "Jabón Roma 1kg",
            package: "Caja de 6 unidades",
            detail: "Otro detalle",
            sku: "654321",
            cost: "120.00",
            image: "https://via.placeholder.com/100",
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

  @media (max-width: 768px) {
    .products-grid {
      grid-template-columns: 1fr; /* En pantallas pequeñas, se muestran como lista */
    }
  }
  </style>
  