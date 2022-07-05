<template>
    <div>
        <div>
            <div class="row mb-3">
                <div class="col-xl-8 col-lg-8 col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <div id="people">
                                <div class="input-group">
                                    <span class="input-group-text btn-primary" id="basic-addon3"
                                        >Buscar producto
                                    </span>
                                    <v-select
                                        class="p-2 form-control"
                                        @search="searchProduct"
                                        :options="products"
                                        label="product_formatt_name"
                                        @option:selecting="addItem"
                                    >
                                        <template v-slot:no-options="{ search, searching }">
                                            <template style="opacity: 0.8" v-if="searching">
                                                Puede que <strong><em>{{ search }}</em></strong> no tenga inventario o su almacén no sea principal
                                            </template>
                                            <em v-else style="opacity: 0.8"
                                                >No hay opciones para seleccionar.</em
                                            >
                                        </template>
                                    </v-select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"> Lista de productos </h5>
                            <table class="table table-borderless" v-if="current_produts.length > 0">
                            <thead>
                                <tr>
                                    <th scope="col" style="background-color: #F6F6FE;">Producto</th>
                                    <th scope="col" style="background-color: #F6F6FE;">Precio</th>
                                    <th scope="col" style="background-color: #F6F6FE;">Cantidad</th>
                                    <th scope="col" style="background-color: #F6F6FE;">Subtotal</th>
                                    <th scope="col" style="background-color: #F6F6FE;">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr  v-for="(item, index) in current_produts " :key="index">
                                    <td><a class="text-primary fw-bold">{{item.product_name}}</a></td>
                                    <td>{{formatPrice(item.product_price, item.quantity_to_sale, 1 )}}</td>
                                    <td > <input type="number" min="0" :max="item.quantity" v-model="item.quantity_to_sale"></td>
                                    <td>{{formatPrice(item.product_price, item.quantity_to_sale, 2 )}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <div v-else style="text-align: center;">
                                <img src="../../../Templates/NiceAdmin/img/undraw_deliveries_2r4y.svg" alt="" style="width:40%">
                                <br> <br> <span class="h6 pt-4">Agrega productos</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Productos</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
import { useToast } from "vue-toastification";
const toast = useToast();

export default ({
  data(){
    return {
      storage_id:'',
      products: [],
      current_produts: [],
    }
    },
    components: {
  },
  methods: {
        searchProduct(search, loading) {
            if (search.length) {
                loading(true);
                var charging = this.search(loading, search, this)
                loading(charging);
            }
        },
        search: _.debounce(function (loading, search) {
                axios.get(route("stock.index"), {
                    params: {
                    columns: JSON.stringify([
                        "id",
                        "product_formatt_name",
                        "product_name",
                        "quantity",
                        "product_price",
                        "product_id",
                    ]),
                    filters: JSON.stringify({
                        'storage_id': this.storage_id,
                        'pos_product_name': search,
                    }),
                    },
                })
                .then((response) => {
                    this.products = response.data.data;
                    return false;
                });
        }, 350),
        addItem(item) {
            const index = this.current_produts.findIndex(i => i.id == item.id);
            if(index != -1){
                toast.warning("El producto ya esta en la lista.", {
                    position: "top-center",
                    closeOnClick: true,
                    pauseOnFocusLoss: true,
                    pauseOnHover: true,
                    draggable: true,
                    draggablePercent: 0.6,
                    showCloseButtonOnHover: false,
                    hideProgressBar: true,
                    closeButton: "button",
                    icon: true,
                    rtl: false,
                });
            }else{
                item.quantity_to_sale = 1;
                this.current_produts.push(item);
            }

        },
        formatPrice(value, quantity, type) {
        switch(type){
            case 1:
                var formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 2
                });
                return formatter.format(value);
            break;
            case 2:
                var formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 2
                });
                return formatter.format(value * quantity);
        }

    },
  },	
  mounted() {
      axios.get(route("user.getAuthUser")).then((response) => {
          this.storage_id = response.data;
      });
  }
})
</script>
