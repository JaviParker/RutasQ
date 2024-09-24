<template>
    <div class="income-history" style="background-color: #DCDCDC; padding: 20px;">
      <div class="title">
        Historial de ingresos
      </div>
      <img :src="chartUrl" alt="Gráfico de Usuarios" />
    </div>
  </template>
  
  <script>
  
  export default {
    components: {
    },
    data() {
      return {
        chartUrl: "https://quickchart.io/chart?c={type:'bar',data:{labels:['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'],datasets:[{label:'Users',data:[12,3,4,7,10,8,7]}]}}",
        chartData: {
          labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'],
          datasets: [
            {
              label: 'Ingresos por día',
              backgroundColor: '#4CAF50',
              borderRadius: 8,
              data: [3000, 5000, 2000, 6000, 4000]
            }
          ]
        },
        chartOptions: {
          responsive: true,
          maintainAspectRatio: false
        }
      }
    }
  }
  </script>
  
  <style scoped>
  .income-history {
    width: 80%;
    height: auto;
    max-width: 400px;
    min-width: 300px;
    border-radius: 10px;
    margin: 20px;
  }

  img{
    width: 100%;
    max-width: 440px;
  }

  .title {
    font-weight: bold;
    font-size: 18px;
    margin-bottom: 20px;
    text-align: left;
  }
  </style>
  