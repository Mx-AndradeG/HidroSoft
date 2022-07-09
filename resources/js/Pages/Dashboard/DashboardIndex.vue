<template>
  <div class="section dashboard">
    <admin-layout>
      <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Inicio</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </nav>
      </div>
      <!-- End Page Title -->

      <section class="section">
        <div class="row">
          <div class="col-12" style="padding-bottom: 19px">
              <v-select
                name="range_id"
                :clearable="false"
                id="range_id"
                :options="ranges"
                label="name"
                :reduce="(name) => name.id"
                v-model="range_id"
              />
          </div>
          <div class="col-lg-12">
            <header-dashboard :range_id="range_id"></header-dashboard>
          </div>
          <div class="col-lg-8">
            <chart-current-info :range_id="range_id"></chart-current-info>
          </div>
          <div class="col-lg-4">
            <donut-chart-current-info :range_id="range_id"></donut-chart-current-info>
          </div>
          <div class="col-lg-8">
            <product-earning-table :range_id="range_id"></product-earning-table>
          </div>
          <div class="col-lg-4">
            <donut-products-chart :range_id="range_id"></donut-products-chart>
          </div>
        </div>
      </section>
    </admin-layout>
  </div>
</template>

<script>
import  AdminLayout  from '@/Layouts/AdminLayout.vue'
import  HeaderDashboard  from './HeaderDashboard.vue'
import  ChartCurrentInfo  from './ChartCurrentInfo.vue'
import  DonutChartCurrentInfo  from './DonutChartCurrentInfo.vue'
import  ProductEarningTable  from './ProductEarningTable.vue'
import  DonutProductsChart  from './DonutProductsChart.vue'

export default ({
  data(){
    return {
      ranges:[
        {
          id:1,
          name:'Hoy'
        },
        {
          id:2,
          name:'Semana'
        },
        {
          id:3,
          name:'Mes'
        },
        {
          id:4,
          name:'Año'
        },
      ],
      range_id:1,
      
    }
    },
    components: {
      AdminLayout,
      HeaderDashboard,
      ChartCurrentInfo,
      DonutChartCurrentInfo,
      ProductEarningTable,
      DonutProductsChart
  }
})
</script>
