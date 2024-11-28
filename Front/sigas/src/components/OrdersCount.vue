<template>
    <div class="order-status-container">
      <!-- Título del componente -->
      <div class="title">
        Pedidos
      </div>
  
      <!-- Contenedor de estados y cantidades -->
      <div class="status-row">
        <!-- Totales -->
        <div class="status-column">
          <div class="status-title">Totales</div>
          <div class="status-quantity">{{ pedidosTotales }}</div>
        </div>
  
        <!-- Confirmados -->
        <div class="status-column">
          <div class="status-title">Confirmados</div>
          <div class="status-quantity">{{ pedidosConfirmados }}</div>
        </div>
  
        <!-- Pendientes -->
        <div class="status-column">
          <div class="status-title">Pendientes</div>
          <div class="status-quantity">{{ pedidosPendientes }}</div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
import { api } from 'src/boot/axios';

  export default {
    name: 'OrderStatus',
    data() {
      return {
        pedidosTotales: 0,
        pedidosConfirmados: 0,
        pedidosPendientes: 0,
      };
    },
    methods: {
      async obtenerConteoPedidos() {
        try {
          const response = await api.get('/conteo-pedidos');
          this.pedidosTotales = response.data.pedidosTotales || 0;
          this.pedidosConfirmados = response.data.pedidosConfirmados || 0;
          this.pedidosPendientes = response.data.pedidosPendientes || 0;
        } catch (error) {
          console.error("Error al obtener conteo de pedidos:", error);
        }
      },
    },
    mounted() {
      this.obtenerConteoPedidos(); // Llama al método al montar
    },
  };
  </script>
  
  <style scoped>
  /* Estilos generales del componente */
  .order-status-container {
    background-color: #DCDCDC; /* Fondo gris claro */
    padding: 20px;
    border-radius: 8px;
    width: 80%; /* Adaptable al contenedor padre */
    max-width: 400px;
    min-width: 300px;
    margin-top: 30px;
  }
  
  /* Título de "Pedidos" */
  .title {
    font-weight: bold;
    font-size: 18px;
    margin-bottom: 20px;
    text-align: left;
  }
  
  /* Contenedor para la fila de estados y cantidades */
  .status-row {
    display: flex;
    justify-content: space-between;
    border-top: 1px solid #ccc; /* Línea horizontal imaginaria */
    padding-top: 10px;
  }
  
  /* Cada columna para Totales, Confirmados y Pendientes */
  .status-column {
    text-align: center;
    flex: 1;
  }
  
  /* Títulos de los estados */
  .status-title {
    font-size: 14px;
    margin-bottom: 5px;
    font-weight: bold;
  }
  
  /* Cantidad debajo del estado */
  .status-quantity {
    font-size: 16px;
    font-weight: bold;
    color: #333;
  }
  </style>
  