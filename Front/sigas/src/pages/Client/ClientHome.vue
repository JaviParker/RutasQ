<template>
    <div>
      <CategoryCarousel/>
      <ProductItemClient
        v-for="product in products"
        :key="product.id"
        :product="product"
        @add-to-cart="handleAddToCart"
      />
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
  