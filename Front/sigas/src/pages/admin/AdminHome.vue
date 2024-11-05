<template>
    <div class="page-container">
        <div class="income">
            <strong>Ingresos del dia</strong>
            <b>$13500.00</b>
        </div>
        <OrdersCount/>
        <IncomeHistory/>
      <div class="btn">
        <q-btn :to="{ name: 'deliverInventory' }" rounded padding="20px 30px" color="secondary" label="Revisar inventario" class="full-width"/>
      </div>
      <div class="btn">
        <q-btn :to="{ name: 'adminInventory' }" rounded padding="20px 30px" color="grey" label="Registrar cliente" class="full-width"/>
      </div>
    </div>
  </template>
  
  <script>
  import IncomeHistory from 'src/components/IncomeHistory.vue';
  import OrdersCount from 'src/components/OrdersCount.vue';
  
  export default {
    components: {
        OrdersCount,
        IncomeHistory
    },
    data() {
      return {
        //Datos
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

  .income{
    margin-top: 30px
  }

  .income strong, b{
    justify-self: start;
    align-items: start;
    margin: 20px;
    font-size: 1.3rem
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
  