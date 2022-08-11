<template>
    <div class="row">      
        <div class="col-12">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Ingreso por metodo de pago <span>| {{current_range}}</span></h5>
                    <canvas id="donut-chart"></canvas>
                </div>
              </div>
        </div>
    </div>
</template>


<script>
import Chart from 'chart.js/auto'

export default ({
props: {
    range_id:Number,
  },
  data(){
    return {
        myChart: null,
        data: [],
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
        chartDatapie: {
            type: 'doughnut',
            data: {
                labels: [
                    'Efectivo',
                    'Tarjeta',
                ],
                datasets: [{
                    label: 'Cantidad vendida',
                    data: [],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 255)',
                    ],
                    hoverOffset: 4
                }]
            },
        }
    }
    },
    components: {
  },
    methods: {
        getData(){
        axios.get(route("sales.pie.info"), {
            params: {
            range_id: this.range_id,
            }}).then((response) => {
                var datasets = [];
                for (var key in response.data) {
                    datasets.push(response.data[key]);
                }
                this.chartDatapie.data.datasets[0].data = datasets;
                const ctx = document.getElementById('donut-chart');
                if(this.myChart){
                    this.myChart.destroy();
                }
                this.$nextTick(() => {
                    this.myChart = new Chart(ctx, this.chartDatapie);
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
