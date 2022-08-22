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
                                                Puede que <strong><em>{{ search }}</em></strong> no tenga existencias.
                                            </template>
                                            <em v-else style="opacity: 0.8"
                                                >No hay opciones para seleccionar.</em
                                            >
                                        </template>
                                    </v-select>
                                    <button class="input-group-text btn-primary" id="basic-addon3" @click="showModal"
                                        >Ver existencias
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"> Lista de productos </h5>
                            <table class="table table-borderless" v-if="sale.current_produts.length > 0">
                            <thead>
                                <tr>
                                    <th scope="col" style="background-color: #F6F6FE;">Producto</th>
                                    <th scope="col" style="background-color: #F6F6FE; text-align: center;">Precio</th>
                                    <th scope="col" style="background-color: #F6F6FE; text-align: center;">Cantidad</th>
                                    <th scope="col" style="background-color: #F6F6FE; text-align: center;">Subtotal</th>
                                    <th scope="col" style="background-color: #F6F6FE; text-align: center;">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr  v-for="(item, index) in sale.current_produts " :key="index">
                                    <td><button type="button" class="btn btn-warning" @click="deletItem(item)"><i class="bi bi-trash"></i></button> <a class="text-primary fw-bold">{{item.product_name}}</a></td>
                                    <td style="text-align: center;">{{formatPrice(item.product_price, item.quantity_to_sale, 1 )}}</td>
                                    <td style="text-align: center;"> <vue-number-input :min="1" :max="item.quantity" v-model="item.quantity_to_sale" size="small" center inline controls></vue-number-input></td>
                                    <td style="text-align: center;">{{formatPrice(item.product_price, item.quantity_to_sale, 2 )}}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: end;">Total:</td>
                                    <td colspan="1" style="text-align: center;">{{formatPrice(total_sale, 1, 2)}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <div v-else style="text-align: center;">
                                <img src="../../../Templates/NiceAdmin/img/undraw_empty_cart_co35.svg" alt="" style="width:40%">
                                <br> <br> <span class="h6 pt-4">Agrega productos</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                           <div class="row pt-2">
                            <div class="col-12 pt-2">
                                <h5 class="card-title"> Tipo de venta </h5>
                                <!-- Tabs navs -->
                                <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a
                                        :class="current_tab == 1 ? 'nav-link active' : 'nav-link'"
                                        @click="changetab(1)"
                                        id="ex3-tab-1"
                                        data-mdb-toggle="tab"
                                        href="#ex3-tabs-1"
                                        role="tab"
                                        aria-controls="ex3-tabs-1"
                                        aria-selected="true"
                                        >Contado</a
                                        >
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a
                                        @click="changetab(2)"
                                        :class="current_tab == 2 ? 'nav-link active' : 'nav-link'"
                                        id="ex3-tab-3"
                                        data-mdb-toggle="tab"
                                        href="#ex3-tabs-3"
                                        role="tab"
                                        aria-controls="ex3-tabs-3"
                                        aria-selected="false"
                                        >Credito</a
                                        >
                                    </li>
                                </ul>
                                <div class="pt-3" v-if="current_tab == 1">
                                    <label for="inputName5" class="form-label">Cliente</label>
                                       <div class="input-group">
                                            <v-select
                                                :disabled="disable"
                                                class="p-2 form-control"
                                                name="client_id" 
                                                id="client_id" 
                                                :options="customers"
                                                label="name" 
                                                :clearable="false"
                                                :reduce="name => name.id"  
                                                v-model="sale.client_id"
                                            >
                                                <template v-slot:no-options="{ search, searching }">
                                                    <template style="opacity: 0.8" v-if="searching">
                                                        Puede que <strong><em>{{ search }}</em></strong> no este registrado como cliente.
                                                    </template>
                                                    <em v-else style="opacity: 0.8"
                                                        >No hay opciones para seleccionar.</em
                                                    >
                                                </template>
                                            </v-select>
                                            <button  :disabled="disable" class="btn btn-success" type="button" @click="$vfm.show('customer_modal')">
                                                +    
                                            </button>
                                        </div>
                                <div class="col-12 pt-4">
                                <label for="inputName5" class="form-label">Metodo de pago</label>
                                    <v-select
                                        :disabled="disable"
                                        class="p-2"
                                        name="payment_method_id" 
                                        id="payment_method_id" 
                                        :options="payment_methods"
                                        label="name" 
                                        :clearable="false"
                                        :reduce="name => name.id"  
                                        v-model="sale.payment_method_id"
                                    >
                                        <template v-slot:no-options="{ search, searching }">
                                            <template style="opacity: 0.8" v-if="searching">
                                                Puede que <strong><em>{{ search }}</em></strong> no este registrado como metodo de pago.
                                            </template>
                                            <em v-else style="opacity: 0.8"
                                                >No hay opciones para seleccionar.</em
                                            >
                                        </template>
                                    </v-select>
                                </div>
                                <div class="col-12 pt-4" v-if="see_reference_code">
                                    <label for="inputName5" class="form-label">Agregar codigo de referencia</label>
                                        <div class="p-2">
                                            <input
                                                :disabled="disable"
                                                placeholder="Codigo para pagos con tarjeta"
                                                v-model="sale.reference_code"
                                                name="reference_code"
                                                type="text"
                                                class="form-control"
                                                id="reference_code"
                                            />
                                        </div>
                                </div>
                                <div class="col-12 pt-4">
                                    <div class="p-2" style="text-align: center;">
                                        <a class="text-primary fw-bold h5">Total de venta: {{formatPrice(total_sale, 1, 2)}}</a>
                                    </div>
                                </div>
                                <div class="col-12 pt-4" v-if="!see_reference_code">
                                    <label for="inputName5" class="form-label">Cantidad recibida</label>
                                        <div class="p-2">
                                            <input
                                                :disabled="disable"
                                                placeholder="$0.00"
                                                v-model="sale.received_amount"
                                                name="reference_code"
                                                min="0"
                                                step="0.01"
                                                type="number"
                                                class="form-control"
                                                id="reference_code"
                                            />
                                        </div>
                                </div>
                                <div class="col-12 pt-4" v-if="sale.payment_method_id == 1 ? true : false">
                                    <div class="d-grid gap-2 mt-3">
                                        <button 
                                            class="btn btn-primary" 
                                            type="button"
                                            :disabled="sale.received_amount < sale.total_sale || disable "
                                            @click="sendData">
                                            Pagar
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 pt-4"  v-if="sale.payment_method_id == 2 ? true : false">
                                    <div class="d-grid gap-2 mt-3">
                                        <button 
                                            class="btn btn-primary" 
                                            type="button"
                                            :disabled="sale.reference_code != '' ? false : true"
                                            @click="sendData">
                                        Confirmar pago
                                        </button>
                                    </div>
                                </div>
                                </div>

                                <div class="pt-3" v-if="current_tab == 2">
                                    <label for="inputName5" class="form-label">Cliente</label>
                                       <div class="input-group">
                                            <v-select
                                                :disabled="disable"
                                                class="p-2 form-control"
                                                name="client_id" 
                                                id="client_id" 
                                                :options="customers"
                                                label="name" 
                                                :clearable="false"
                                                :reduce="name => name.id"  
                                                v-model="sale.client_id"
                                            >
                                                <template v-slot:no-options="{ search, searching }">
                                                    <template style="opacity: 0.8" v-if="searching">
                                                        Puede que <strong><em>{{ search }}</em></strong> no este registrado como cliente.
                                                    </template>
                                                    <em v-else style="opacity: 0.8"
                                                        >No hay opciones para seleccionar.</em
                                                    >
                                                </template>
                                            </v-select>
                                            <button  :disabled="disable" class="btn btn-success" type="button" @click="$vfm.show('customer_modal')">
                                                +    
                                            </button>
                                        </div>
                                    
                                    <div class="col-12 pt-4">
                                        <label for="inputName5" class="form-label">Plan de Pagos</label>
                                            <v-select
                                                :disabled="disable"
                                                class="p-2"
                                                name="payment_plan_id" 
                                                id="payment_plan_id" 
                                                :options="payment_plan"
                                                label="name" 
                                                :clearable="false"
                                                :reduce="name => name.id"  
                                                v-model="sale.payment_plan_id"
                                            >
                                                <template v-slot:no-options="{ search, searching }">
                                                    <template style="opacity: 0.8" v-if="searching">
                                                        Puede que <strong><em>{{ search }}</em></strong> no este registrado como metodo de pago.
                                                    </template>
                                                    <em v-else style="opacity: 0.8"
                                                        >No hay opciones para seleccionar.</em
                                                    >
                                                </template>
                                            </v-select>
                                    </div>
                                    <div class="col-12 pt-4">
                                        <label for="inputName5" class="form-label">Plazos</label>
                                            <v-select
                                                :disabled="disable"
                                                class="p-2"
                                                name="deadline_id" 
                                                id="deadline_id" 
                                                :options="deadlines"
                                                label="name" 
                                                :clearable="false"
                                                :reduce="name => name.id"  
                                                v-model="sale.deadline_id"
                                            >
                                                <template v-slot:no-options="{ search, searching }">
                                                    <template style="opacity: 0.8" v-if="searching">
                                                        Puede que <strong><em>{{ search }}</em></strong> no este registrado como metodo de pago.
                                                    </template>
                                                    <em v-else style="opacity: 0.8"
                                                        >No hay opciones para seleccionar.</em
                                                    >
                                                </template>
                                            </v-select>
                                    </div>
                                    <div class="col-12 pt-4">
                                        <div class="d-grid gap-2 mt-3">
                                            <button 
                                                class="btn btn-primary" 
                                                type="button"
                                                :disabled="sale.deadline_id == '' || sale.payment_plan_id == ''"
                                                 @click="$vfm.show('preview_payments_modal', {  deadline_id: sale.deadline_id, 
                                                                                                payment_plan_id: sale.payment_plan_id,
                                                                                                total_sale: total_sale, })"
                                                >
                                                Calcular Pagos
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 pt-4">
                                        <div class="p-2" style="text-align: center;">
                                            <a class="text-primary fw-bold h5">Total de venta: {{formatPrice(total_sale, 1, 2)}}</a>
                                        </div>
                                    </div>
                                    <div class="col-12 pt-4">
                                        <div class="d-grid gap-2 mt-3">
                                            <button 
                                                class="btn btn-primary" 
                                                type="button"
                                                :disabled="sale.deadline_id == '' || sale.payment_plan_id == '' || sale.client_id == 0 || disable "
                                                @click="sendData">
                                                Confirmar venta
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <customer-modal @done="fin"></customer-modal>
        <preview-payment-modal @done="fin"></preview-payment-modal>
    </div>
</template>



<script>
import { useToast } from "vue-toastification";
const toast = useToast();
import CustomerModal from './CustomerModal.vue';
import PreviewPaymentModal from './PreviewPaymentModal.vue';
import Swal from "sweetalert2";

export default ({
  data(){
    return {
      open_dialog: false,
      storage_id:'',
      products: [],
      customers: [],
      payment_methods: [
        {
          id: 1,
          name: "Efectivo",
        },
        {
          id: 2,
          name: "Tarjeta"
        },
      ],
      payment_plan: [
        {
          id: 1,
          name: "Semanal"
        },
        {
          id: 2,
          name: "Quincenal"
        },
        {
          id: 3,
          name: "Mensual"
        }
      ],
      deadlines:[
        {
          id: 1,
          name: "3"
        },
        {
          id: 2,
          name: "6"
        },
        {
          id: 3,
          name: "12"
        }
      ],
      current_storage: {},
      current_branch: {},
      current_tab: 1,
      sale:{
        current_produts: [],
        client_id: '',
        total_sale: 0,
        sale_type_id: 1,
        payment_method_id: '',
        reference_code: '',
        received_amount: 0,
        deadline_id: '',
        payment_plan_id: '',
      },
    }
    },
    components: {
        CustomerModal,
        PreviewPaymentModal
  },
    methods: {
        fin(){
            toast.success("Accion realizada correctamente", {
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
            axios.get(route("customer.index", {
            columns: JSON.stringify([
                "id",
                "name",
            ])})).then((response) => {
            this.customers = response.data.data;
            this.customers.push({
                id: 0,
                name: "Publico en general",
            })
            this.sale.client_id = 0;
        });  
        },
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
            const index = this.sale.current_produts.findIndex(i => i.id == item.id);
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
                this.sale.current_produts.push(item);
                this.products = [];
            }

        },
        sendData(){
            var mensage = '';
            this.sale.total_sale = this.total_sale;
             switch(this.sale.payment_method_id){
                case 1:
                    var change = this.sale.received_amount - this.sale.total_sale;
                     mensage =  change > 0 ? 'Quieres confirmar la venta con un cambio de ' + this.formatPrice(change, 1, 2) : 'Quieres confirmar la venta';
                    break;
                case 2:
                     mensage =  'Quieres confirmar la venta con codigo de referencia: ' + this.sale.reference_code;
                    break;
                case 3: 
                    var current_customer = this.customers.find(c => c.id == this.sale.client_id);
                    mensage =  'Quieres confirmar la venta a credito a ' + current_customer.name + ' por el monto de ' + this.formatPrice(this.sale.total_sale, 1, 2);
                    break;
             }
            Swal.fire({
                title: "Realizar venta",
                text: mensage,
                icon: "success",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "No, cancelar",
                confirmButtonText: "Si, cobrar!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(route('sales.store'), this.sale).then((response) => {
                        toast.success("Venta realizada con exito.", {
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
                        this.sale ={
                            current_produts: [],
                            client_id: '',
                            total_sale: 0,
                            sale_type_id: 1,
                            payment_method_id: '',
                            reference_code: '',
                            received_amount: 0,
                            deadline_id: '',
                            payment_plan_id: '',
                        };
                        this.printJS(response.data.ticket);
                    })
                    .catch((error) => {
                        toast.error("Error al realizar la venta.", {
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
                    });
                }
            });
        },
        changetab(tab){
            if(tab == 2){
                this.sale.payment_method_id = 3
            }
            if(tab == 1){
                this.sale.payment_method_id = ''
            }
            this.sale.sale_type_id = tab;
            this.current_tab = tab;
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
        deletItem(item) {
            this.sale.current_produts.splice(item, 1);
        },
  },	
  mounted() {

        axios.get(route("user.getAuthUser")).then((response) => {
            this.current_storage = response.data.wherehouses;
            this.current_branch = response.data.branch;
            this.storage_id = response.wherehouses.id;
        });
        axios.get(route("customer.index", {
            columns: JSON.stringify([
                "id",
                "name",
            ])})).then((response) => {
            this.customers = response.data.data;
            this.customers.push({
                id: 0,
                name: "Publico en general",
            })
            this.sale.client_id = 0;
        });  
       
  },
    watch: {
    'sale.payment_method_id'() {
        this.sale.reference_code = '';
        this.sale.received_amount = 0;
    }
  },
  
    computed:{
        total_sale(){
            var total = 0;
            this.sale.current_produts.forEach(item => {
                total += item.product_price * item.quantity_to_sale;
            });
            this.sale.total_sale = total;
            return total;
        },
        disable(){
            if(this.sale.current_produts.length > 0){
                return false;
            }else{
                return true;
            }
        },
        see_reference_code(){
            if(this.sale.payment_method_id != 2){
                return false;
            }else{
                return true;
            }
        }
  }
})
</script>

<style>
.offcanvas-end {
    top: 0;
    right: 0;
    width: 45%;
    border-left: 1px solidrgba(0,0,0,.2);
    transform: translateX(100%);
}

@media (max-width: 992px) {
.offcanvas-end {
    width: 100%;
}
}
</style>