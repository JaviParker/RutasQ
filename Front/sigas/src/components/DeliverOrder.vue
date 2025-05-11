<template>
    <q-card flat class="q-pa-md q-mb-md product"> 
      <div class="row">
        <!-- Sección de la imagen -->
        <div class="col-auto">
          <q-img src="https://placehold.co/100x100/000000/DCDCDC" alt="Imagen del producto" class="product-image" />
        </div>
  
        <!-- Sección de la información -->
        <div class="col">
          <div class="product-info">
            <div class="text-bold">{{ order.shopname }}</div>
            <div class="text-grey">
              <p>{{ order.location }}</p>
              <p>Encargado: {{ order.owner }}</p>
              <p>Estado: {{ order.paystatus }}</p>
              <p>PedidoID: {{ order.id }}</p>
            </div>
          </div>
        </div>
  
        <!-- Sección del seleccionador de cantidad -->
        <div class="col-auto q-gutter-xs btn">
          <q-btn color="primary" label="Detalles" class="full-width" clickable @click="emitId" />
        </div>
      </div>
    </q-card>
  </template>
  
  <script>
  export default {
    name: "DeliverOrder",
    props: {
      order: {
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
      emitId(){
        this.$emit("orderid", [this.order.id, this.order.userId]);
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
  .btn{
    align-content: end;
  }
  </style>
  