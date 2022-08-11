<template>
    <div class="row">      
        <div class="col-xxl-3 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title" style="font-size: 15px;" >Numero de Ventas <span>| {{current_range}}</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6 style="font-size: 20px;">{{data.total_count_sale_today}}</h6>
                    </div>
                  </div>
                </div>

              </div>
        </div>
        <div class="col-xxl-3 col-md-6">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title" style="font-size: 15px;">Cantidad vendida <span>| {{current_range}}</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6 style="font-size: 20px;">  {{formatPrice(data.total_amount_sale_today)}}</h6>
                    </div>
                  </div>
                </div>

              </div>
        </div>
        <div class="col-xxl-3 col-md-6">
              <div class="card info-card revenue-card">
               <div class="card-body">
                  <h5 class="card-title" style="font-size: 15px;" >Ganancia <span>| {{current_range}}</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6 style="font-size: 20px;">{{formatPrice(data.total_earnings_today)}}</h6>
                    </div>
                  </div>
                </div>

              </div>
        </div>
         <div class="col-xxl-3 col-xl-12">
              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title" style="font-size: 15px;">Productos vendidos <span>| {{current_range}}</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="ps-3">
                      <h6 style="font-size: 20px;">{{data.total_products_sale_today}}</h6>
                    </div>
                  </div>

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
    }
    },
    components: {
  },
  methods:{
    getData(){
      axios.get(route("sales.header.info"), {
        params: {
          range_id: this.range_id,
        }}).then((response) => {
          this.data = response.data;
          this.current_range = this.ranges.find(range => range.id == this.range_id).name;
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
  watch:{
    range_id(){
      this.getData();
    }
  },
  mounted(){
    this.getData();
  }

})
</script>
