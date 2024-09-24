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
          <div class="status-quantity">{{ totalOrders }}</div>
        </div>
  
        <!-- Confirmados -->
        <div class="status-column">
          <div class="status-title">Confirmados</div>
          <div class="status-quantity">{{ confirmedOrders }}</div>
        </div>
  
        <!-- Pendientes -->
        <div class="status-column">
          <div class="status-title">Pendientes</div>
          <div class="status-quantity">{{ pendingOrders }}</div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'OrderStatus',
    data() {
      return {
        // Aquí defines las cantidades
        totalOrders: 100,
        confirmedOrders: 75,
        pendingOrders: 25
      };
    }
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
  