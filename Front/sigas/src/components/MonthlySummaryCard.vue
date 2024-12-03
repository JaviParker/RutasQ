<template>
    <div class="summary-card">
      <!-- Título de la semana -->
      <div class="summary-title">
        Semana {{ number }} ({{ days }} días resumidos)
      </div>
  
      <!-- Ingresos brutos -->
      <div class="summary-section">
        <span class="section-label">Ingresos brutos</span>
        <span class="income-total">{{ income }}</span>
      </div>
  
      <!-- Productos más vendidos -->
      <div class="summary-section">
        <span class="section-label">Productos más vendidos</span>
        <ul class="top-products">
          <li v-for="(product, index) in topProducts" :key="index" class="product-item">
            {{ product }}
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "MonthlySummaryCard",
    props: {
      number: {
        type: String,
        default: "1"
      },
      income: {
        type: String,
        default: "$0.00"
      },
      topProducts: {
        type: Array,
        default: () => []
      },
      days: {
        type: Number,
        default: 1
      }
    }
  };
  </script>
  
  <style scoped>
  .summary-card {
    background-color: #DCDCDC; /* Fondo gris claro */
    padding: 16px;
    border-radius: 20px;
    max-width: 350px;
    min-width: 350px;
    margin: 10px;
  }
  
  .summary-title {
    font-weight: bold;
    font-size: 18px;
    color: #333;
    margin-bottom: 8px;
  }
  
  .summary-section {
    margin-top: 12px;
  }
  
  .section-label {
    font-size: 14px;
    color: #000000;
    display: block;
    margin-bottom: 4px;
    font-weight: bold;
  }
  
  .income-total {
    font-size: 20px;
    font-weight: bold;
    color: #333;
  }
  
  .top-products {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  
  .product-item {
    font-size: 14px;
    color: #777;
  }
  </style>
  