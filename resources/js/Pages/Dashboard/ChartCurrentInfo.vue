<template>
    <div class="row">      
        <div class="col-12">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Resumen general <span>| {{current_range}}</span></h5>
                    <canvas id="week-chart"></canvas>
                </div>
              </div>
        </div>
    </div>
</template>


<script>
import  AdminLayout  from '@/Layouts/AdminLayout.vue'
import Chart from 'chart.js/auto'

export default ({
  props: {
    range_id:Number,
  },
  data(){
    return {
      myChart: null,
      current_range: '',
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
      chartData: {
          type: "bar",
          data: {
              labels: ["Mercury", "Venus", "Earth", "Mars", "Jupiter", "Saturn", "Uranus", "Neptune"],
              datasets: [
                  {
                  label: "Total de venta",
                  data: [3, 5, 2, 2, 49, 72, 27, 14],
                  backgroundColor: "#5282F0",
                  borderColor: "#133B7D",
                  borderWidth: 3
                  },
                  {
                  label: "Ganancia de venta",
                  data: [78, 3, 6, 1, 60, 42, 77, 74],
                  backgroundColor: "#86F32C",
                  borderColor: "#7BF913",
                  borderWidth: 3
                  },
                  {
                  label: "Costo de productos",
                  data: [0, 0, 1, 2, 79, 82, 27, 14],
                  backgroundColor: "#F9DF51",
                  borderColor: "#FADB2C",
                  borderWidth: 3
                  },
              ]
              },
          options: {
              plugins: {
                  title: {
                      display: true,
                      text: 'Desglose de ventas (Ultimas 10 ventas)'
                  }
              },
              responsive: true,
              lineTension: 1,
              scales: {
                  yAxes: [
                  {
                      ticks: {
                      beginAtZero: true,
                      padding: 25
                      }
                  }
                  ]
              }
          }
      }
    }
    },
    components: {
      AdminLayout,
    },
    methods: {
        getData(){
        axios.get(route("sales.bar.info"), {
            params: {
            range_id: this.range_id,
            }}).then((response) => {
                this.chartData.data.labels = response.data.labels;
                this.chartData.data.datasets[0].data = response.data.total_sales_data;
                this.chartData.data.datasets[1].data = response.data.total_earning_data;
                this.chartData.data.datasets[2].data = response.data.total_purchase_data;
                this.chartData.options.plugins.title.text = response.data.title;

                const ctx = document.getElementById('week-chart');
                if(this.myChart){
                    this.myChart.destroy();
                }
                this.$nextTick(() => {
                    this.myChart = new Chart(ctx, this.chartData);
                    this.current_range = this.ranges.find(range => range.id == this.range_id).name;
                });
            });  
        },
    },
    watch:{
      range_id(){
        this.getData();
        }
    },
    mounted(){
        this.getData();
    },
})
</script>
