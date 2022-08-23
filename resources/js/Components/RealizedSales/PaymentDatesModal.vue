<template>
  <div>
    <vue-final-modal
      v-model="modal_button.show"
      @beforeOpen="beforeOpen"
      name="preview_payments_modal"
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
         Tabla de amortización
        </h3>
      </div>
      <!-- END Section Modal Title -->

      <hr />

      <!-- Section Modal Content -->
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

      <!-- Section Modal Footer -->
      <!-- END Section Modal Footer -->
    </vue-final-modal>
  </div>
</template>

<script>
export default {
  name: "preview_payments_modal",

  data() {
    return {
      modal_button: {
        show: false,
      },
      data:[],
    };
  },
  methods: {
    beforeOpen(e) {
      if (typeof e.ref.params._rawValue.id != "undefined") {
        axios
          .get(route("sales.payments.dates.current"), {
            params: {
              id: e.ref.params._rawValue.id,
            },
          })
          .then((response) => {
            this.data = response.data.payment_dates;
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

