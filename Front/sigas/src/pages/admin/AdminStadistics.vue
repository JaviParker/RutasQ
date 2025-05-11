<template>
    <div class="container">
        <q-select rounded outlined v-model="model" :options="options" label="Mes" class="month" @update:model-value="filtrarPorMes"/>
    </div>
    <div class="products-grid">
        <MonthlySummaryCard
          v-for="week in weeks"
          :key="week.id"
          :week="week"
          :number="week.number"
          :income="week.income"
          :topProducts="week.topProducts"
          :days="week.days"
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
            monthMap: {
                Enero: 1,
                Febrero: 2,
                Marzo: 3,
                Abril: 4,
                Mayo: 5,
                Junio: 6,
                Julio: 7,
                Agosto: 8,
                Septiembre: 9,
                Octubre: 10,
                Noviembre: 11,
                Diciembre: 12,
            },
        }
    },
    setup () {
        const currentMonth = new Date().toLocaleString('es-MX', { month: 'long' }).replace(/^\w/, c => c.toUpperCase());
        return {
            model: ref(currentMonth), // Mes por defecto
        };
    },
    mounted() {
        // this.obtenerEstadisticasSemanales();
        this.obtenerMes();
        this.filtrarPorMes(this.model);
    },
    methods: {
        async obtenerEstadisticasSemanales(mes) {
            try {
                const response = await api.get(`/estadisticas-semanales?mes=${mes}`);
                console.log(response);
                const semanas = response.data.semanas.map((semana, index) => ({
                id: index + 1,
                number: semana.numeroSemana,
                income: semana.totalIngresos,
                topProducts: response.data.topProductos.map(p => p.name),
                days: semana.diasAnalizados,
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
        filtrarPorMes(mesNombre) {
            const mesNumero = this.monthMap[mesNombre] || null;
            if (mesNumero) {
                this.obtenerEstadisticasSemanales(mesNumero);
            } else {
                console.error('Mes no válido:', mesNombre);
            }
        }
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