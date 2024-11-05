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
import MonthlySummaryCard from 'src/components/MonthlySummaryCard.vue';
import { ref } from 'vue'

export default {
    components: {
        MonthlySummaryCard
    },
    data() {
        return {
            weeks: [
                {
                    id: 1,
                    number: 1,
                    income: 13500.00,
                    topProducts: [
                        'Jabon Foca',
                        'Sopa Yemina',
                        'Coca cola 1.5L'
                    ]
                },
                {
                    id: 2,
                    number: 2,
                    income: 11000.00,
                    topProducts: [
                        'Jabon Foca',
                        'Sopa Yemina',
                        'Coca cola 1.5L'
                    ]
                },
                {
                    id: 3,
                    number: 3,
                    income: 12600.00,
                    topProducts: [
                        'Jabon Foca',
                        'Sopa Yemina',
                        'Coca cola 1.5L'
                    ]
                }            
            ]
        }
    },
    setup () {
    return {
        model: ref(null),
        options: [
        'Enero','Febrero', 'Marzo', 'Abril', 'Mayo','Junio', 'Julio', 'Agosto', 'Septiembre','Octubre', 'Noviembre', 'Diciembre'
        ]
    }
    }
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