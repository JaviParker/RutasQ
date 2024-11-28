<template>
    <div class="container">
        <q-select rounded outlined v-model="model" :options="options" label="Mes" class="month"/>
    </div>
    <div class="products-grid">
        <MonthlySummaryCard
          v-for="week in weeks"
          :key="week.id"
          :week="week"
          :number="week.number"
          :income="week.income"
          :topProducts="week.topProducts"
        />
      </div>
</template>

<script>
import { api } from 'src/boot/axios';
import MonthlySummaryCard from 'src/components/MonthlySummaryCard.vue';
import { ref } from 'vue'

export default {
    components: {
        MonthlySummaryCard
    },
    data() {
        return {
            weeks: [],
            options: [],
        }
    },
    setup () {
        return {
            model: ref('Noviembre'),
            // options: [
            //     // 'Enero',
            //     // 'Febrero',
            //     // 'Marzo',
            //     // 'Abril',
            //     // 'Mayo',
            //     // 'Junio',
            //     // 'Julio',
            //     // 'Agosto',
            //     // 'Septiembre',
            //     // 'Octubre',
            //     // 'Noviembre',
            //     // 'Diciembre',
            // ]
        }
    },
    mounted() {
        this.obtenerEstadisticasSemanales();
        this.obtenerMes();
    },
    methods: {
        async obtenerEstadisticasSemanales() {
        try {
            const response = await api.get('/estadisticas-semanales');
            const semanas = response.data.semanas.map((semana, index) => ({
            id: index + 1,
            number: semana.numeroSemana,
            income: semana.totalIngresos,
            topProducts: response.data.topProductos.map(p => p.nombre),
            }));
            this.weeks = semanas;
            console.log(this.weeks);
            
            
        } catch (error) {
            console.error('Error al obtener estadísticas semanales:', error);
        }
        },
        async obtenerMes() {
        try {
            const response = await api.get('/meses');
            this.options = response.data;
        } catch (error) {
            console.error('Error al obtener meses:', error);
        }
        },
    },
}
</script>

<style scoped>
.products-grid{
    display: grid;
    width: 100%;
    align-items: center;
    justify-content: center;
}
.month{
    display: flex;
    width: 80%;
    justify-content: center;
    margin-top: 20px;
    margin-bottom: 20px;
}
.container{
    display: flex;
    justify-content: center;
}
</style>