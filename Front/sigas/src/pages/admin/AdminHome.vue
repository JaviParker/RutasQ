<template>
  <div class="page-container" ref="pdfContent">
    <div class="income">
      <strong>Ingresos del día</strong>
      <b>${{ ingresosDia.toFixed(2) }}</b>
    </div>
    <OrdersCount />
    <IncomeHistory :ingresosPorDia="ingresosPorDia" />
    
    <div class="botones">
      <div class="btn">
        <q-btn :to="{ name: 'adminInventory' }" rounded padding="20px 30px" color="secondary" label="Revisar inventario" class="full-width" />
      </div>
      <div class="btn">
        <q-btn @click="redirectToRegister" rounded padding="20px 30px" color="grey" label="Registrar cliente" class="full-width" />
      </div>
      <div class="btn">
        <q-btn rounded padding="20px 30px" color="secondary" label="Generar PDF" class="full-width PDF" @click="generatePdf" />
      </div>
    </div>
  </div>
</template>

<script>
import { api } from 'src/boot/axios';
import IncomeHistory from 'src/components/IncomeHistory.vue';
import OrdersCount from 'src/components/OrdersCount.vue';
import dataStore from './dataStore';
import JsPDF from 'jspdf';
import domToImage from 'dom-to-image-more';

export default {
  components: {
    OrdersCount,
    IncomeHistory
  },
  data() {
    return {
      ingresosDia: 0,
      ingresosPorDia: []
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
    redirectToRegister() {
      dataStore.rolUploading = 'admin';
      this.$router.push({ name: 'adminCheckUsers' });
    },
    generatePdf() {
      const element = this.$refs.pdfContent;

      domToImage.toPng(element)
        .then((dataUrl) => {
          const pdf = new JsPDF({
            orientation: 'portrait',
            unit: 'px',
            format: [element.offsetWidth, element.offsetHeight]
          });
          const pdfWidth = pdf.internal.pageSize.getWidth();
          const pdfHeight = pdf.internal.pageSize.getHeight();
          const imgProps = pdf.getImageProperties(dataUrl);
          const imgWidth = imgProps.width;
          const imgHeight = imgProps.height;
          const x = (pdfWidth - imgWidth) / 2;
          const y = 0;

          pdf.addImage(dataUrl, 'PNG', x, y, imgWidth, imgHeight);
          pdf.save('ReporteAdmin.pdf');
        })
        .catch(function (error) {
          console.error('Error al generar el PDF:', error);
        });
    }
  },
  mounted() {
    this.obtenerIngresosDia();
    this.obtenerIngresosPorDia();
  }
};
</script>

<style scoped>
.page-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.income {
  margin-top: 30px;
}

.income strong, b {
  justify-self: start;
  align-items: start;
  margin: 20px;
  font-size: 1.3rem;
}

.botones {
  justify-content: center;
  padding: 0 35%;
}

.botones .btn {
  margin-bottom: 10px;
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  width: 100%;
  max-width: 1200px;
  margin: 20px auto;
}

@media (max-width: 768px) {
  .products-grid {
    grid-template-columns: 1fr;
  }
}
</style>
