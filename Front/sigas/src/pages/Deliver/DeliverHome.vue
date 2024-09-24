<template>
    <div class="page-container">
      <div class="products-grid">
        <DeliverOrder
          v-for="order in orders"
          :key="order.id"
          :order="order"
        />
      </div>
      <div class="btn">
        <q-btn color="secondary" label="Registrar cliente" class="full-width"/>
      </div>
    </div>
  </template>
  
  <script>
  import DeliverOrder from 'src/components/DeliverOrder.vue';
  
  export default {
    components: {
      DeliverOrder,
    },
    data() {
      return {
        orders: [
          {
            id: 1,
            shopname: "Abarrotes Jessi",
            location: "Calle jardines #409 col. Independencia",
            owner: "Luis Ramirez",
            paystatus: "Pagado",
            image: "https://via.placeholder.com/100",
          },
          {
            id: 1,
            shopname: "Miscelanea Pepe",
            location: "Calle Torres #211 col. Benito Juarez",
            owner: "Luis Ramirez",
            paystatus: "Pagado",
            image: "https://via.placeholder.com/100",
          },
          {
            id: 1,
            shopname: "Abarrotes Mari",
            location: "Calle jardines #409",
            owner: "Luis Ramirez",
            paystatus: "Pagado",
            image: "https://via.placeholder.com/100",
          },
          {
            id: 1,
            shopname: "Miscelanea El guero",
            location: "Calle jardines #409",
            owner: "Luis Ramirez",
            paystatus: "Pagado",
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
  