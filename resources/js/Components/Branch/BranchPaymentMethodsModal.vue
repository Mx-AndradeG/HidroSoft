<template>
  <div>
    <vue-final-modal
      v-model="modal_button.show"
      @beforeOpen="beforeOpen"
      name="payment_method_modal"
      lock-scroll="false"
      content-style="border-radius:25px"
      classes="modal-container w-50 modal-dialog modal-xl"
      body-scroll-lock="true"
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
            Metodos de pago.
        </h3>
      </div>
      <!-- END Section Modal Title -->

      <hr />

      <alv-form
        id="alv-payment-method"
        ref="form"
        :action="alvRoute"
        :method="alvMethod"
        @after-done="afterDone"
        @after-error="afterError"
        :data-object="item"
      >

      <!-- Section Modal Content -->
      <div class="row mt-2 mb-2" style="margin: 0 5px 0 5px">
        <div class="row">
          <div class="row">
            <div class="col-md-8">
              <label for="inputNameC" class="form-label"
                >Nombre del metodo del pago</label
              >
              <input
                placeholder="Efectivo"
                :disabled="disable"
                v-model="current_payment"
                name="name"
                type="text"
                class="form-control"
                id="nameCustomer"
              />
            </div>
            <div class="col-md-4 pt-4" style="margin-top: 4px;">
              <button
                  @click="pushPaymentMethod()"
                  type="button"
                  class="btn btn-primary">
                  Agregar
              </button>
            </div>
          </div>
          <div class="mt-5 text-center" v-if="item.payment_methods.length > 0 ">
          <center class="m-3"> <h5> Métodos de pagó</h5> </center> 
            <table class="table"  style="height: 100px;">
              <thead>
                <tr>
                  <th class="align-middle" scope="col">Nombre</th>
                  <th class="align-middle" scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(data,index) in item.payment_methods.filter(i=>!i.deleted)" :key="index.id">
                  <td class="align-middle"> <span class="align-middle">{{data.payment_method}}</span> </td>
                  <td class="align-middle">              
                    <button
                        @click="deleteInvoice(index)"
                        type="button"
                        class="btn btn-danger">
                        <i
                          data-toggle="tooltip"
                          data-placement="bottom"
                          title="Eliminar"
                          class="ri-delete-bin-2-line fs-4"
                          style="color: white; cursor: pointer"
                        ></i>
                  </button> 
              </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- END Put your code below -->
        </div>
      </div>
      <!-- END Section Modal Content -->
      <hr />
      </alv-form>

      <!-- Section Modal Footer -->
      <div class="row justify-content-end" id="modal-footer">
        <div class="col-4" v-if="!disable">
          <button
            form="alv-payment-method"
            type="submit"
            class="w-100 btn btn-outline-primary d-flex justify-content-center"
          >
            <i class="ri-download-2-line"></i>
            <span style="margin-left: 3px">Guardar datos</span>
          </button>
        </div>
      </div>
      <!-- END Section Modal Footer -->
    </vue-final-modal>
  </div>
</template>

<script>
import { useToast } from "vue-toastification";

const toast = useToast()

export default {
  name: "BranchPaymentMethodsModal",
  data() {
    return {
      modal_button: {
        show: false,
      },
      alvRoute: route("payment-method.branch.store"),
      alvMethod: "POST",
      event: [],
      current_payment: '',
      item: {
          payment_methods: [],
      },
      disable: false,
    };
  },
  methods: {
    pushPaymentMethod(){
      this.item.payment_methods.push({
          id: 'null',
          payment_method: this.current_payment,
          deleted: false,
      });
        this.current_payment = null;
    },
    deleteInvoice(index){
      this.item.payment_methods[index].deleted = true;
    },

    getData(id) {
    axios.get(route("payment-method.index",id))
          .then(Response => {
            this.transactations_id = Response.data.data;
      });
    },
    afterError(error){
     this.showToast(error.message)
    },

    showToast(message){
        toast.warning(message ,{
          position: "top-right",
          closeOnClick: true,
          pauseOnFocusLoss: true,
          pauseOnHover: true,
          draggable: true,
          draggablePercent: 0.6,
          showCloseButtonOnHover: false,
          hideProgressBar: false,
          closeButton: "button",
          icon: true,
          rtl: false
      });
    },

    beforeOpen(e) {
      this.alvRoute = route("payment-method.branch.store");
      this.alvMethod = "POST";
      this.item = {
        payment_methods: [],
      };
      if(typeof e.ref.params._rawValue.id != "undefined" ){
        this.getData(e.ref.params._rawValue.id);
        this.item.branch_id = e.ref.params._rawValue.id;
      }
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
  display: flex;
  flex-direction: column;
  margin: 0 1rem;
  padding: 1rem;
  border: 1px solid #e2e8f0;
  border-radius: 0.25rem;
  background: #fff;
}
</style>
