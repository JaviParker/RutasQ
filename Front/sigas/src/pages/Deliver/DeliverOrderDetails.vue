<template>
    <div class="page-container">
      <div class="products-grid">
        <DeliverDetailsProduct
          v-for="product in products"
          :key="product.id"
          :product="product"
          @add-to-cart="handleAddToCart"
        />
      </div>
      <div class="total row full-width">
        <div class="col-6">
            <strong>Total</strong> <br>
            <b>${{ total }}</b>
        </div>
        <div class="col-6">
            <q-btn color="secondary" label="Confirmar entrega" class="full-width btn"/> <br>
            <q-btn color="red" label="No entregado" class="full-width btn"/>
        </div>
    </div>
    </div>
  </template>
  
  <script>
  import DeliverDetailsProduct from 'src/components/DeliverDetailsProduct.vue';
  
  export default {
    components: {
      DeliverDetailsProduct
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
            ordered: 4,
          },
          {
            id: 2,
            name: "Jabón Roma 1kg",
            package: "Caja de 6 unidades",
            detail: "Otro detalle",
            sku: "654321",
            cost: "120.00",
            image: "https://via.placeholder.com/100",
            ordered: 2,
          },
          {
            id: 2,
            name: "Jabón FOCA 1kg",
            package: "Caja de 6 unidades",
            detail: "Otro detalle",
            sku: "654321",
            cost: "120.00",
            image: "https://via.placeholder.com/100",
            ordered: 6,
          },
          {
            id: 2,
            name: "Jabón Roma 1kg",
            package: "Caja de 6 unidades",
            detail: "Otro detalle",
            sku: "654321",
            cost: "120.00",
            image: "https://via.placeholder.com/100",
            ordered: 8,
          },
        ],
        total: 87.00,
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
      font-size: 2.4rem;
    }
    .btn{
      margin: 5px;
      max-width: 150px;
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
  