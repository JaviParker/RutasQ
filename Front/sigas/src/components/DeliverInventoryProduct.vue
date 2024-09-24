<template>
    <q-card flat class="q-pa-md q-mb-md product"> 
  <div class="row">
    <!-- Sección de la imagen -->
    <div class="col-auto">
      <q-img :src="product.image" alt="Imagen del producto" class="product-image" />
    </div>

    <!-- Sección de la información -->
    <div class="col">
      <div class="product-info">
        <div class="text-bold">{{ product.name }}</div>
        <div class="text-grey">
          <p>{{ product.package }}</p>
          <p>{{ product.detail }}</p>
          <p>SKU: {{ product.sku }}</p>
        </div>
      </div>
    </div>

    <!-- Sección del seleccionador de cantidad -->
    <div class="col-auto q-gutter-xs buttons">
      <div class="full-width cant">
        <span class="text-bold">Totales: </span>
        <span>{{ quantity }}</span>
      </div>
      <div class="row">
        <div class="col-6 counts">
          <span>Vendidos</span> <br>
          <span>{{ soldCount }}</span>
        </div>
        <div class="col-6 counts">
          <span>Restantes</span> <br>
          <span>{{ stock }}</span>
        </div>
      </div>
    </div>
  </div>
</q-card>

  </template>
  
  <script>
  export default {
    name: "ProductItemClient",
    props: {
      product: {
        type: Object,
        required: true,
      },
    },
    data() {
      return {
        quantity: 1,
        stock: 10,
        soldCount: 2,
      };
    },
    methods: {
      increaseQuantity() {
        this.quantity++;
      },
      decreaseQuantity() {
        if (this.quantity > 1) {
          this.quantity--;
        }
      },
      addToCart() {
        this.$emit("add-to-cart", {
          product: this.product,
          quantity: this.quantity,
        });
      },
    },
  };
  </script>
  
  <style scoped>
  .product{
    max-width: 450px;
    min-width: 360px;
    background-color: #DCDCDC;
    border-radius: 12px;
    padding: 10px;
    margin: 20px;
  }
  .product-image {
    width: 100px;
    height: 100px;
    border-radius: 10px;
    margin-right: 12px;
  }
  .rounded-borders {
    border-radius: 10px;
  }
  .product-info p {
    margin: 0;
    padding: 0;
    font-size: 11px;
  }
  .buttons{
    align-self: center;
    width: 150px;
    justify-items: center;
  }
  .cant{
    font-size: 1rem;
    margin: 5px;
    display: flex;
    justify-content: center;
  }
  </style>
  