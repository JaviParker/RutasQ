<template>
    <div class="page-container">
        <div class="income">
            <strong>Ingresos del dia</strong>
            <b>${{ ingresosDia.toFixed(2) }}</b>
        </div>
        <OrdersCount/>
        <IncomeHistory :ingresosPorDia="ingresosPorDia"/>
      <div class="btn">
        <q-btn :to="{ name: 'adminInventory' }" rounded padding="20px 30px" color="secondary" label="Revisar inventario" class="full-width"/>
      </div>
      <div class="btn">
        <q-btn @click="redirectToRegister" rounded padding="20px 30px" color="grey" label="Registrar cliente" class="full-width"/>
      </div>
    </div>
  </template>
  
  <script>
  import { api } from 'src/boot/axios';
  import IncomeHistory from 'src/components/IncomeHistory.vue';
  import OrdersCount from 'src/components/OrdersCount.vue';
import dataStore from './dataStore';
  
  export default {
    components: {
        OrdersCount,
        IncomeHistory
    },
    data() {
      return {
        ingresosDia: 0,
        ingresosPorDia: [],
      };
    },
    methods: {
      handleAddToCart(item) {
        console.log("Producto agregado al carrito:", item);
      },
      async obtenerIngresosDia() {
        try {
          const response = await api.get('/ingresos-del-dia');
          this.ingresosDia = response.data.totalIngresos || 0;
        } catch (error) {
          console.error("Error al obtener ingresos del día:", error);
        }
      },
      async obtenerIngresosPorDia() {
        try {
          const response = await api.get('/ingresos-por-dia');
          this.ingresosPorDia = response.data;
        } catch (error) {
          console.error("Error al obtener ingresos por día:", error);
        }
      },
      redirectToRegister(){
        dataStore.rolUploading = 'admin';
        this.$router.push({name: 'adminCheckUsers'});
      }
    },
    mounted() {
      this.obtenerIngresosDia(); // Cargar datos al montar el componente
      this.obtenerIngresosPorDia();
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
  