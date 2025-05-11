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
              <p class="cost">${{ product.cost }}</p>
            </div>
          </div>
        </div>
  
        <!-- Sección del seleccionador de cantidad -->
        <div class="col-auto q-gutter-xs cant">
          <div class="full-width full-height">
            <p>Ordenados</p>
            <span>{{ product.cantidad }}</span>
          </div>
        </div>
      </div>
    </q-card>
  </template>
  
  <script>
  export default {
    name: "DeliverDetailsProduct",
    props: {
      product: {
        type: Object,
        required: true,
      },
    },
    data() {
      return {
        quantity: 1, // Cantidad inicial
      };
    },
    methods: {
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
  .cant{
    width: 80px;
    align-self: center;
    font-size: 1.7rem;
    font-weight: bolder;
    color: #0F62FE;
  }
  .cant p{
    font-size: 14px;
    
  }
  .cost{
    font-size: 15px!important;
    font-weight: bolder;
    color: #001D6C;
  }
  </style>
  