<template>
    <div class="row">      
        <div class="col-12">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title"> Top 10 Productos que dan mas ganancia</h5>
                   <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col" style="background-color: #F6F6FE;">Producto</th>
                        <th scope="col" style="background-color: #F6F6FE; text-align: end;">Precio de compra</th>
                        <th scope="col" style="background-color: #F6F6FE; text-align: end;">Precio de venta</th>
                        <th scope="col" style="background-color: #F6F6FE; text-align: end;">Ganancia</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, index) in data " :key="index">
                        <td><a class="text-primary fw-bold">{{item.name}}</a></td>
                        <td style="text-align: end;">{{formatPrice(item.purchase_price)}}</td>
                        <td class="fw-bold" style="text-align: end;">{{formatPrice(item.sale_price)}}</td>
                        <td style="text-align: end;">{{formatPrice(item.earning)}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
        </div>
    </div>
</template>


<script>

export default ({
  props: {
    range_id:Number,
  },
  data(){
    return {
      myChart: null,
      data: [],
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
    }
    },
    components: {
    },
    methods: {
      getData(){
        axios.get(route("sales.erned.product")).then((response) => {
            this.data = response.data;
        });  
      },
      formatPrice(value) {
        var formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        });
        return formatter.format(value);
      },
    },
    mounted(){
        this.getData();
    },
})
</script>
