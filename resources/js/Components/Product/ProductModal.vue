<template>
  <div>
    <vue-final-modal
      v-model="modal_button.show"
      @beforeOpen="beforeOpen"
      name="category_modal"
      lock-scroll="false"
      content-style="border-radius:25px"
      classes="w-50 modal-dialog modal-xl"
      :body-scroll-lock="scroll"
      content-class="modal-content "
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
          }}Producto
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
            <div class="row">
              <div class="col-md-12">
                <label for="inputName5" class="form-label">Nombre</label>
                <input
                  :disabled="disable"
                  v-model="item.name"
                  name="name"
                  type="text"
                  class="form-control"
                  id="name"
                  placeholder="Refresco"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label for="inputName5" class="form-label mt-3"
                  >Descripcion</label
                >
                <textarea
                  :disabled="disable"
                  class="form-control"
                  id="description"
                  name="description"
                  v-model="item.description"
                  placeholder="Escribe una descripcion aqui"
                ></textarea>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label for="inputName5" class="form-label mt-3">Codigo</label>
                <input
                  :disabled="disable"
                  v-model="item.code"
                  name="code"
                  type="text"
                  class="form-control"
                  id="code"
                  placeholder="12345678"
                />
              </div>
              <div class="col-md-4">
                <label for="inputName5" class="form-label mt-3">Precio de compra</label>
                <input
                  :disabled="disable"
                  v-model="item.purchase_price"
                  name="purchase_price"
                  type="number"
                  step="0.01"
                  class="form-control"
                  id="purchase_price"
                  placeholder="$123"
                />
              </div>
              <div class="col-md-4">
                <label for="inputName5" class="form-label mt-3">Precio de venta</label>
                <input
                  :disabled="disable"
                  v-model="item.sale_price"
                  name="sale_price"
                  type="number"
                  step="0.01"
                  class="form-control"
                  id="sale_price"
                  placeholder="$123"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="inputName5" class="form-label mt-3"
                  >Categoria</label
                >
                <v-select
                  :disabled="disable"
                  name="category_id"
                  id="category_id"
                  :options="options"
                  label="name"
                  :reduce="(name) => name.id"
                  v-model="item.category_id"
                />
              </div>
              <div class="col-md-6">
                <label for="inputName5" class="form-label mt-3"
                  >Proveedor</label
                >
                <v-select
                  :disabled="disable"
                  name="supplier_id"
                  id="supplier_id"
                  :options="suppliers"
                  label="company_name"
                  :reduce="(company_name) => company_name.id"
                  v-model="item.supplier_id"
                />
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
        <div class="col-3" v-if="!disable">
          <button
            form="alv"
            type="submit"
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
export default {
  name: "ProductModal",
  data() {
    return {
      modal_button: {
        show: false,
      },
      alvRoute: route("product.store"),
      alvMethod: "PUT",
      event: [],
      item: {},
      disable: false,
      options: [],
      suppliers: [],
      scroll: true,
    };
  },
  methods: {
    afterDone() {
      this.modal_button.show = false;
      this.$refs.form.unsetButtonLoading();
      this.$emit("done");
    },
    getData() {
      axios
        .get(route("categories.index"), {
          params: {
            columns: JSON.stringify(["id", "name"]),
          },
        })
        .then((response) => {
          this.options = response.data.data;
        });

      axios
        .get(route("supplier.index"), {
          params: {
            columns: JSON.stringify(["id", "company_name"]),
          },
        })
        .then((response) => {
          this.suppliers = response.data.data;
        });
    },

    beforeOpen(e) {
      this.getData();
      this.alvRoute = route("product.store");
      this.alvMethod = "POST";
      this.item = {
        name: "",
        description: "",
      };
      this.disable = false;

      if (typeof e.ref.params._rawValue.id != "undefined") {
        axios
          .get(route("product.show", e.ref.params._rawValue.id), {
            params: {
              columns: JSON.stringify([
                "name",
                "description",
                "category_id",
                "sale_price",
                "code",
                "purchase_price",
                "supplier_id",
              ]),
            },
          })
          .then((response) => {
            this.item = response.data;
          });
        this.alvRoute = route("product.update", e.ref.params._rawValue.id);
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
