<template>
  <div>
    <vue-final-modal
      v-model="modal_button.show"
      @beforeOpen="beforeOpen"
      name="customer_modal"
      lock-scroll="false"
      content-style="border-radius:25px"
      classes="modal-container w-50 modal-dialog modal-xl"
      body-scroll-lock="false"
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
          }}Cliente
        </h3>
      </div>
      <!-- END Section Modal Title -->

      <hr />

      <!-- Section Modal Content -->
      <div class="row mt-2 mb-2" style="margin: 0 5px 0 5px">
        <div class="col-12">
          <!-- Put your code below -->
          <alv-form
            id="alv"
            ref="form"
            :action="alvRoute"
            :method="alvMethod"
            @after-done="afterDone"
            :data-object="item"
          >
            <div class="col-md-12">
              <label for="inputNameC" class="form-label"
                >Nombre del cliente</label
              >
              <input
                :disabled="disable"
                v-model="item.name"
                name="name"
                type="text"
                class="form-control"
                id="nameCustomer"
              />
            </div>

            <div class="col-md-12">
              <label for="inputAddressC" class="form-label">Dirección</label>
              <input
                :disabled="disable"
                v-model="item.address"
                name="address"
                type="text"
                class="form-control"
                id="addressCustomer"
              />
            </div>

            <div class="col-md-12">
              <label for="inputPhoneC" class="form-label"
                >Número de teléfono</label
              >
              <input
                :disabled="disable"
                v-model="item.phone"
                name="phone"
                type="text"
                class="form-control"
                id="phoneCustomer"
              />
            </div>

            <div class="col-md-12">
              <label for="inputRFCC" class="form-label">RFC</label>
              <input
                :disabled="disable"
                v-model="item.rfc"
                name="rfc"
                type="text"
                class="form-control"
                id="rfcCustomer"
              />
            </div>

            <div class="col-md-12">
              <label for="inputEmailC" class="form-label"
                >Correo Electronico</label
              >
              <input
                :disabled="disable"
                v-model="item.email"
                name="email"
                type="text"
                class="form-control"
                id="emailCustomer"
              />
            </div>

            <div class="col-md-12">
              <label for="inputSocialC" class="form-label">Razón Social</label>
              <input
                :disabled="disable"
                v-model="item.social"
                name="social"
                type="text"
                class="form-control"
                id="socialCustomer"
              />
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
            <span style="margin-left: 3px">Guardar datos</span>
          </button>
        </div>
      </div>
      <!-- END Section Modal Footer -->
    </vue-final-modal>
  </div>
</template>

<script>
export default {
  name: "ExampleModal",
  data() {
    return {
      modal_button: {
        show: false,
      },
      alvRoute: route("customer.store"),
      alvMethod: "PUT",
      event: [],
      item: {},
      disable: false,
    };
  },
  methods: {
    afterDone() {
      this.modal_button.show = false;
      this.$refs.form.unsetButtonLoading();
      this.$emit("done");
    },
    beforeOpen(e) {
      this.alvRoute = route("customer.store");
      this.alvMethod = "POST";
      this.item = {
        name: "",
        address: "",
        phone: "",
        rfc: "",
        email: "",
        social: "",
      };
      this.disable = false;

      if (typeof e.ref.params._rawValue.id != "undefined") {
        axios
          .get(route("customer.show", e.ref.params._rawValue.id), {
            params: {
              columns: JSON.stringify([
                "name",
                "address",
                "phone",
                "rfc",
                "email",
                "social",
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
