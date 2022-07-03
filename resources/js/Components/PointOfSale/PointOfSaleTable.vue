<template>
    <div>
        <div>
            <div class="row mb-3 ">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Productos</h5>
                            <div id="people">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
export default ({
  data(){
    return {
      user:[],
    }
    },
    components: {
  },
  mounted() {
      axios.get(route("user.getAuthUser")).then((response) => {
          this.user = response.data;
      });
  }
})
</script>
