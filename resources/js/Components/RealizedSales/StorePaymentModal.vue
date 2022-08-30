<template>
  <div>
    <vue-final-modal
      v-model="modal_button.show"
      @beforeOpen="beforeOpen"
      name="StorePaymentModal"
      :lock-scroll="false"
      content-style="border-radius:25px"
      classes="w-100 modal-dialog modal-xl"
      content-class="modal-content"
    >
      <button
        style="border-top-right-radius: 20px"
        class="modal__close btn btn-light"
        @click="modal_button.show = false"
      >
        <i class="ri-close-fill ri-lg" style="color: #4a5568"></i>
      </button>

      <!-- Section Modal Title -->
      <div class="row mt-1 text-center">
        <h3 class="col-12" style="font-weight: bold">
         Registrar Pagos
        </h3>
      </div>
      <!-- END Section Modal Title -->

      <hr />

      <!-- Section Modal Content -->
      <div class="row mt-2 mb-2" style="margin: 0 5px 0 5px">
        <div class="pb-2">
          Adeudo restante: <a class="text-primary fw-bold" >{{formatPrice(total_debt)}}</a>
        </div>
          <div class="row">
              <div class="col-md-4">
                <label for="inputNameC" class="form-label"
                  >Cantidad</label
                >
                <input
                  placeholder="$100.00"
                  :disabled="disable"
                  v-model="payment.amount"
                  type="number"
                  :max="total_debt"
                  step="0.01"
                  name="amount"
                  class="form-control"
                  id="amount"
                />
              </div>
              <div class="col-md-4">
                <label for="inputSocialC" class="form-label"
                  >Metodo de pago</label
                >
                <v-select
                  :disabled="disable"
                  class="p-2"
                  name="payment_method_id" 
                  id="payment_method_id" 
                  :options="payment_methods"
                  label="name" 
                  :clearable="false"
                  :reduce="name => name.id"  
                  v-model="payment.payment_method_id"
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
              <div class="col-md-4" v-if="payment.payment_method_id == 1">
                <label for="inputNameC" class="form-label"
                  >Cantidad recibida</label
                >
                <input
                  placeholder="Dinero recibido"
                  :disabled="disable"
                  v-model="payment.received_amount"
                  name="received_amount"
                  class="form-control"
                  type="number"
                  step="0.01"
                  id="received_amount"
                />
              </div>
              <div class="col-md-4" v-if="payment.payment_method_id == 2">
                <label for="inputNameC" class="form-label"
                  >Agregar codigo de referencia</label
                >
                <input
                    :disabled="disable"
                    placeholder="Codigo para pagos con tarjeta"
                    v-model="payment.reference_code"
                    name="reference_code"
                    type="text"
                    class="form-control"
                    id="reference_code"
                />
              </div>
          </div>
      </div>
      <div class="row mt-2 mb-2" style="margin: 0 5px 0 5px">
        <div class="row">
          <div>
                <table class="table table-borderless" v-if="data.length > 0">
                <thead>
                    <tr>
                        <th scope="col" style="background-color: #F6F6FE; text-align: center;">Numero de pago</th>
                        <th scope="col" style="background-color: #F6F6FE; text-align: center;">Fecha de pago</th>
                        <th scope="col" style="background-color: #F6F6FE; text-align: center;">Estatus de couta</th>
                        <th scope="col" style="background-color: #F6F6FE; text-align: center;">Pago</th>
                        <th scope="col" style="background-color: #F6F6FE; text-align: center;">Total Pagado</th>
                        <th scope="col" style="background-color: #F6F6FE; text-align: center;">Saldo restante</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr  v-for="(item, index) in data " :key="index">
                        <td style="text-align: center;"> {{index + 1}}</td>
                        <td style="text-align: center;"> <a class="text-primary fw-bold">{{item.date}} </a></td>
                        <td style="text-align: center;"> <a :class="item.status == 'Vigente' ? 'text-primary fw-bold' : 
                                                                    (item.status == 'Pagado' ? 'text-success fw-bold' : 'text-danger fw-bold')" >
                          {{item.status}} </a></td>
                        <td style="text-align: center;">{{formatPrice(item.amount)}} </td>
                        <td style="text-align: center;">{{formatPrice(item.total_paid)}}</td>
                        <td style="text-align: center;">{{formatPrice(item.debt)}}</td>
                    </tr>
                    </tbody>
                </table>
          </div>
          <!-- END Put your code below -->
        </div>
      </div>
      <!-- END Section Modal Content -->
      <hr />

            <div class="row justify-content-end" id="modal-footer">
        <div class="col-3" v-if="!disable">
          <button
            @click="sendData"
            type="button"
            class="w-100 btn btn-outline-primary d-flex justify-content-center"
          >
            <i class="ri-download-2-line"></i>
            <span style="margin-left: 3px">Guardar</span>
          </button>
        </div>
      </div>
      <!-- END Section Modal Footer -->
    </vue-final-modal>
  </div>
</template>

<script>
import Swal from "sweetalert2";

export default {
  name: "StorePaymentModal",

  data() {
    return {
      modal_button: {
        show: false,
      },
      payment:{
        sale_id :'',
        amount:'',
        payment_method_id:'',
        reference_code:'',
        received_amount:''
      },
      total_debt:0,
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
      data:[],
    };
  },
  methods: {
    beforeOpen(e) {
      if (typeof e.ref.params._rawValue.id != "undefined") {
          this.payment.sale_id = e.ref.params._rawValue.id;
      }
      if (typeof e.ref.params._rawValue.id != "undefined") {
        axios
          .get(route("sales.payments.dates.current"), {
            params: {
              id: e.ref.params._rawValue.id,
            },
          })
          .then((response) => {
            this.data = response.data.payment_dates;
            this.total_debt = response.data.total_debt;
          })
      }
    },
    formatPrice(value) {
          var formatter = new Intl.NumberFormat('en-US', {
              style: 'currency',
              currency: 'USD',
              minimumFractionDigits: 2
          });
          return formatter.format(value);
      },
      sendData(){
            var mensage = '';
             switch(this.payment.payment_method_id){
                case 1:
                    var change = this.payment.received_amount - this.payment.amount;
                     mensage =  change > 0 ? 'Quieres confirmar el pago con un cambio de ' + this.formatPrice(change, 1, 2) : 'Quieres confirmar el pago';
                    break;
                case 2:
                     mensage =  'Quieres confirmar el pago con codigo de referencia: ' + this.payment.reference_code;
                    break;
             }
            Swal.fire({
                title: "Realizar pago",
                text: mensage,
                icon: "success",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "No, cancelar",
                confirmButtonText: "Si, cobrar!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(route('sales.store.payment'),this.payment).then((response) => {
                        this.payment = {
                          amount:0,
                          payment_method_id:'',
                          reference_code:'',
                          received_amount:''
                        };
                        this.modal_button.show = false;
                        this.$emit("done");
                    })
                    .catch((error) => {
                        toast.error("Error al realizar el pago.", {
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
  },
};
</script>

<style scoped>
::v-deep .modal-container {
  display: flex;
  justify-content: center;
  align-items: center;
}

::v-deep .modal-content {
  position: relative;
  margin: 0 1rem;
  padding: 1rem;
  border: 1px solid #e2e8f0;
  border-radius: 0.25rem;
  background: #fff;
}

.vfm--inset{
  overflow-y: scroll !important;
}

</style>

