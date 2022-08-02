<template>
    <div>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="modalCustomer" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <div class="row mt-1 text-center">
                    <h3 class="col-12" style="font-weight: bold">
                    {{
                        alvMethod == "POST" ? "Crear " : disable ? "Ver " : "Editar "
                    }}Cliente
                    </h3>
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
            <!-- Section Modal Title -->

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
                    <span style="margin-left: 3px">Guardar </span>
                </button>
                </div>
            </div>
            </div>
        </div>
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
    beforeOpen() {
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
    },
    openModal() {
      this.open = true;
    },
    closeModal() {
      this.open = false;
    },
  },
    mounted() {
        this.beforeOpen();
    },
};
</script>
