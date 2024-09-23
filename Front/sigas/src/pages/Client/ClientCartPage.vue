<template>
    <div>
      <CartProduct
        v-for="product in products"
        :key="product.id"
        :product="product"
      />
      <!-- <ProductItemClient
        
        @add-to-cart="handleAddToCart"
      /> -->
    </div>
    <div class="total row full-width">
        <div class="col-6">
            <strong>Total</strong> <br>
            <b>${{ total }}</b>
        </div>
        <div class="col-6">
            <strong>Pagar</strong>
            <q-btn :to="{ name: 'clientPay' }" color="primary" label="Ahora" class="full-width btn"/>
            <q-btn color="green" label="En entrega" class="full-width btn"/>
        </div>
    </div>
  </template>
  
  <script>
  import CartProduct from 'src/components/CartProduct.vue';

  export default {
    components: {
      CartProduct
    },
    data() {
      return {
        total: "87.00",
        products: [
          {
            id: 1,
            name: "Jabón Foca 1kg",
            package: "Caja de 12 unidades",
            detail: "Detalle del producto",
            sku: "123456",
            image: "https://via.placeholder.com/100",
          },
          {
            id: 2,
            name: "Producto 2",
            package: "Paquete de 24 unidades",
            detail: "Otro detalle",
            sku: "654321",
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
        .total{
            background-color: #DCDCDC;
            position: fixed;
            bottom: 0;
            height: 23%;
            padding: 10px;
        }
        strong{
            font-size: 1.5rem;
        }
        b{
            font-size: 2rem;
        }
        .btn{
            margin: 5px
        }
    </style>
  