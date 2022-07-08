<template>
  <div>
    <vue-final-modal
      v-model="modal_button.show"
      @beforeOpen="beforeOpen"
      name="customer_modal"
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
          }}Cliente
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
                  >Nombre del cliente</label
                >
                <input
                  placeholder="Pepito peréz"
                  :disabled="disable"
                  v-model="item.name"
                  name="name"
                  type="text"
                  class="form-control"
                  id="nameCustomer"
                />
              </div>
              <div class="col-md-6">
                <label for="inputSocialC" class="form-label"
                  >Razón Social</label
                >
                <input
                  placeholder="Pepito peréz S.A de C.V"
                  :disabled="disable"
                  v-model="item.social"
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
                  >Correo Electronico</label
                >
                <input
                  placeholder="Pepito@correo.com"
                  :disabled="disable"
                  v-model="item.email"
                  name="email"
                  type="text"
                  class="form-control"
                  id="emailCustomer"
                />
              </div>

              <div class="col-md-6">
                <label for="inputPhoneC" class="form-label">Teléfono</label>
                <input
                  placeholder="449-123-23-45"
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
                  placeholder="AAAA991122330"
                  :disabled="disable"
                  v-model="item.rfc"
                  name="rfc"
                  type="text"
                  class="form-control"
                  id="rfcCustomer"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label for="inputAddressC" class="form-label">Dirección</label>
                <GMapAutocomplete
                  class="form-control"
                  placeholder="Busca una localizacion"
                  @place_changed="setPlace"
                  :value="item.address"
                  :disabled="disable"
                  name="address"
                  id="address"
                />
                <center class="mt-5">
                  <GMapMap
                    :center="center"
                    :zoom="15"
                    map-type-id="terrain"
                    style="
                      width: 100%;
                      position: relative;
                      overflow: hidden;
                      height: 26rem;
                    "
                  >
                    <GMapCluster>
                      <GMapMarker
                        :key="index"
                        v-for="(m, index) in markers"
                        :position="m.position"
                        :clickable="true"
                        :draggable="false"
                        @click="center = m.position"
                      />
                    </GMapCluster>
                  </GMapMap>
                </center>
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
  name: "customer_modal",

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
    setPlace(e) {
      this.center.lat = e.geometry.location.lat();
      this.center.lng = e.geometry.location.lng();
      this.markers[0].position.lat = e.geometry.location.lat();
      this.markers[0].position.lng = e.geometry.location.lng();
      this.item.latitude = e.geometry.location.lat();
      this.item.longitude = e.geometry.location.lng();
      this.item.address = e.formatted_address;
    },
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
                "latitude",
                "longitude",
              ]),
            },
          })
          .then((response) => {
            this.item = response.data;
            this.center.lat = Number(response.data.latitude);
            this.center.lng = Number(response.data.longitude);
            this.markers[0].position.lat = Number(response.data.latitude);
            this.markers[0].position.lng = Number(response.data.longitude);
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
</style>
