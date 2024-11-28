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
          <div class="full-width full-height">
            <q-btn flat icon="remove" @click="decreaseQuantity" />
            <span>{{ quantity }}</span>
            <q-btn flat icon="add" @click="increaseQuantity" />
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
      initialQuantity: {
        type: Number,
        default: null, // Usaremos este valor si se pasa una cantidad desde el componente padre
      },
    },
    data() {
      return {
        quantity: this.initialQuantity ?? 1, // Usar initialQuantity si está definida, de lo contrario, iniciar en 1
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
  }
  </style>
  