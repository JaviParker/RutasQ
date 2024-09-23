<template>
    <q-card flat class="q-pa-md q-mb-md notification">
      <div class="row">
        <!-- Primera columna: imagen e información -->
        <div class="col">
          <div class="row">
            <!-- Imagen de la oferta -->
            <div class="col-auto">
              <q-img :src="offer.image" alt="Imagen de la oferta" class="offer-image" />
            </div>
  
            <!-- Información de la oferta -->
            <div class="col offer-info">
              <div class="text-grey">{{ offer.type }}</div>
              <div class="text-bold">{{ offer.name }}</div>
              <div class="selected-products text-grey">
                <p v-for="(product, index) in offer.products" :key="index">{{ product }}</p>
              </div>
            </div>
          </div>
  
          <!-- Segunda fila: descripción -->
          <div class="row offer-description q-mt-sm">
            <div class="col">
              {{ offer.description }}
            </div>
          </div>
        </div>
  
        <!-- Segunda columna: botones de cantidad y agregar -->
        <div class="col-auto q-gutter-xs buttons">
          <span class="cost">${{offer.cost}}</span>
          <div class="full-width">
            <q-btn flat icon="remove" @click="decreaseQuantity" />
            <span>{{ quantity }}</span>
            <q-btn flat icon="add" @click="increaseQuantity" />
          </div>
          <q-btn flat color="primary" label="Agregar" class="full-width" @click="addToCart" />
        </div>
      </div>
    </q-card>
  </template>
  
  <script>
  export default {
    name: "NotificationOffer",
    props: {
      offer: {
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
          offer: this.offer,
          quantity: this.quantity,
        });
      },
    },
  };
  </script>
  
  <style scoped>
  .notification {
    max-width: 450px;
    min-width: 360px;
    background-color: #DCDCDC;
    border-radius: 12px;
  }
  
  .offer-image {
    width: 100px;
    height: 100px;
    border-radius: 10px;
    margin-right: 12px;
  }
  
  .offer-info {
    margin-bottom: 10px;
  }
  
  .offer-info p {
    margin: 0;
    padding: 0;
    font-size: 11px;
  }
  
  .offer-description {
    margin-top: 10px;
    padding-top: 10px;
    font-size: 12px;
    border-top: 1px solid #ccc;
  }
  
  .selected-products p {
    margin: 0;
    padding: 0;
    font-size: 11px;
  }
  
  .buttons {
    align-self: center;
  }

  .cost{
    font-size: 20px;
    font-weight: bolder;
    color: #001D6C;
    margin-left: 30px;
    justify-self: center;
    width: auto;
  }
  </style>
  