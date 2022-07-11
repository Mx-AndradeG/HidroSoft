<template>
  <div>
    <vue-final-modal
      v-model="modal_button.show"
      @beforeOpen="beforeOpen"
      name="sale_modal"
      :lock-scroll="true"
      content-style="border-radius:25px"
      classes="w-50 modal-dialog modal-xl"
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
          {{
            alvMethod == "POST" ? "Crear " : disable ? "Ver " : "Editar "
          }}Detalles de venta
        </h3>
      </div>
      <!-- END Section Modal Title -->

      <hr />

      <!-- Section Modal Content -->
      <div class="row mt-2 mb-2" style="margin: 0 5px 0 5px">
        <div class="row">
          <alv-form
            id="alv"
            ref="form"
            :action="alvRoute"
            :method="alvMethod"
            @after-done="afterDone"
            :data-object="item"
          >
            <div class="row">
              <div class="col-md-6">
                <label for="inputNameC" class="form-label"
                  >Usuario que vendio</label
                >
                <input
                  placeholder="Pepito peréz"
                  :disabled="disable"
                  v-model="item.user_name"
                  name="name"
                  type="text"
                  class="form-control"
                  id="nameCustomer"
                />
              </div>
              <div class="col-md-6">
                <label for="inputSocialC" class="form-label"
                  >Sucursal</label
                >
                <input
                  placeholder="Pepito peréz S.A de C.V"
                  :disabled="disable"
                  v-model="item.branch_name"
                  name="social"
                  type="text"
                  class="form-control"
                  id="socialCustomer"
                />
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <label for="inputEmailC" class="form-label"
                  >Cliente</label
                >
                <input
                  placeholder="Pepito@correo.com"
                  :disabled="disable"
                  v-model="item.customer_name"
                  name="email"
                  type="text"
                  class="form-control"
                  id="emailCustomer"
                />
              </div>

              <div class="col-md-6">
                <label for="inputPhoneC" class="form-label">Metodo de pago</label>
                <input
                  placeholder="449-123-23-45"
                  :disabled="disable"
                  v-model="item.payment_method_name"
                  name="phone"
                  type="text"
                  class="form-control"
                  id="phoneCustomer"
                />
              </div>
              <div class="col-md-6">
                <label for="inputPhoneC" class="form-label">Total de compra</label>
                <input
                  placeholder="449-123-23-45"
                  :disabled="disable"
                  v-model="item.formatted_total_sale"
                  name="phone"
                  type="text"
                  class="form-control"
                  id="phoneCustomer"
                />
              </div>
              <div class="col-md-6">
                <label for="inputPhoneC" class="form-label">Fecha de compra</label>
                <input
                  placeholder="449-123-23-45"
                  :disabled="disable"
                  v-model="item.Formatted_created_at"
                  name="phone"
                  type="text"
                  class="form-control"
                  id="phoneCustomer"
                />
              </div>
              <div class="col-12 pt-4">
                  <h5 class="card-title"> Lista de productos </h5>
                  <table class="table table-borderless">
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
                       <tr  v-for="(item, index) in item.sale_formatt_details " :key="index">
                          <td><a class="text-primary fw-bold">{{item.product_name}}</a></td>
                          <td style="text-align: center;">{{item.price}}</td>
                          <td style="text-align: center;"> {{item.quantity}} </td>
                          <td style="text-align: center;">{{item.subtotal}}</td>
                        </tr> 
                      <tr>
                          <td colspan="4" style="text-align: end;">Total:</td>
                          <td colspan="1" style="text-align: center;">{{item.formatted_total_sale}}</td>
                      </tr>
                      </tbody>
                  </table>
              </div>
            </div>
          </alv-form>
          <!-- END Put your code below -->
        </div>
      </div>
      <!-- END Section Modal Content -->
      <hr />

      <!-- Section Modal Footer -->
      <div class="row justify-content-end" id="modal-footer">
        <div class="col-4" v-if="!disable">
          <button
            form="alv"
            type="submit"
            class="w-100 btn btn-outline-primary d-flex justify-content-center"
          >
            <i class="ri-download-2-line"></i>
            <span style="margin-left: 3px">Guardar </span>
          </button>
        </div>
      </div>
      <!-- END Section Modal Footer -->
    </vue-final-modal>
  </div>
</template>

<script>
export default {
  name: "sale_modal",

  data() {
    return {
      modal_button: {
        show: false,
      },
      alvRoute: route("customer.store"),
      alvMethod: "PUT",
      event: [],
      payment_methods: [],
      customers: [],
      item: {
        id: "",
        user_name: "",
        branch_name: "",
        customer_name: "",
        payment_method_name: "",
        formatted_total_sale: "",
        Formatted_created_at: "",
        sale_formatt_details: [],
      },
      disable: false,
      center: { lat: 51.093048, lng: 6.84212 },
      markers: [
        {
          position: {
            lat: 51.093048,
            lng: 6.84212,
          },
        },
      ],
    };
  },
  methods: {
    afterDone() {
      this.modal_button.show = false;
      this.$refs.form.unsetButtonLoading();
      this.$emit("done");
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
    beforeOpen(e) {
      this.alvRoute = route("customer.store");
      this.alvMethod = "POST";
      this.item = {
        id: "",
        user_name: "",
        branch_name: "",
        customer_name: "",
        payment_method_name: "",
        formatted_total_sale: "",
        Formatted_created_at: "",
        sale_formatt_details: [],
      };
      this.disable = false;

      if (typeof e.ref.params._rawValue.id != "undefined") {
        axios
          .get(route("sales.show", e.ref.params._rawValue.id), {
            params: {
              columns: JSON.stringify([
                  "id",
                  "user_name",
                  "branch_name",
                  "customer_name",
                  "payment_method_name",
                  "formatted_total_sale",
                  "Formatted_created_at",
                  "sale_formatt_details"
              ]),
            },
          })
          .then((response) => {
            this.item = response.data;
          });
        this.alvRoute = route("customer.update", e.ref.params._rawValue.id);
        this.alvMethod = "PUT";
        this.disable = false;
      }
      if (typeof e.ref.params._rawValue.show != "undefined") {
        this.disable = true;
      }
    },
    openModal() {
      this.open = true;
    },
    closeModal() {
      this.open = false;
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
