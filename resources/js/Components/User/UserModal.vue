<template>
  <div>
        <vue-final-modal v-model="modal_button.show"  @beforeOpen="beforeOpen" name="user_modal" lock-scroll="false" content-style="border-radius:25px"
                         classes="modal-container w-50 modal-dialog modal-xl" :body-scroll-lock="scroll"  content-class="modal-content ">
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
          }}Usuario
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
            <div class="col-md-12">
              <label for="name" class="form-label"
                >Nombre</label
              >
              <input
                placeholder="José Pérez"
                :disabled="disable"
                v-model="item.name"
                name="name"
                type="text"
                class="form-control"
                id="name"
              />
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <label for="email" class="form-label"
                >Correo Electronico</label
              >
              <input
                placeholder="correo@email.com"
                :disabled="disable"
                v-model="item.email"
                name="email"
                type="text"
                class="form-control"
                id="email"
              />
            </div>
          </div>
          <div class="row">
              <div class="col-md-12"><label for="inputName5" class="form-label mt-3">Tipo de usuario</label>
                <v-select :disabled="disable" name="user_type_id" id="user_type_id" :options="user_types" label="name" :reduce="name => name.id"  v-model="item.user_type_id"/>
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
  name: "UserModal",
  data() {
    return {
      modal_button: {
        show: false,
      },
      alvRoute: route("user.store"),
      alvMethod: "PUT",
      event: [],
      item: {},
      disable: false,
      user_types: []
    };
  },
  methods: {
    afterDone() {
      this.modal_button.show = false;
      this.$refs.form.unsetButtonLoading();
      this.$emit("done");
    },
    getData(){
        axios.get(route("user_type.index"),{ params:{
                columns: JSON.stringify(['id','name'])
        }}).then((response) => {
            this.user_types = response.data.data;
        });
    },
    beforeOpen(e) {
      this.getData()
      this.alvRoute = route("user.store");
      this.alvMethod = "POST";
      this.item = {
        name: "",
        email: '',
        user_type_id: '',
      };
      this.disable = false;

      if (typeof e.ref.params._rawValue.id != "undefined") {
        axios
          .get(route("user.show", e.ref.params._rawValue.id), {
            params: {
              columns: JSON.stringify([
                'name',
                'phone',
                'email',
                'address',
                'latitude',
                'longitude',
                'company_id',
              ]),
            },
          })
          .then((response) => {
            this.item = response.data;
          });
        this.alvRoute = route("user.update", e.ref.params._rawValue.id);
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

.vfm--inset{
  overflow-y: scroll !important;
}

</style>
