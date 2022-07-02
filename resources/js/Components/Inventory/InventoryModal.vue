<template>
  <div>
    <vue-final-modal
      v-model="modal_button.show"
      @beforeOpen="beforeOpen"
      name="customer_modal"
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
          {{alvMethod == "POST" ? "Crear " : disable ? "Ver " : "Editar "}}Movimiento
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
              <div class="col-md-12"><label for="inputName5" class="form-label">Tipo de movimiento</label>
                  <v-select 
                    :disabled="disable" 
                    name="inventory_movement_type_id" 
                    id="inventory_movement_type_id" 
                    :options="inventoryMovementTypes" 
                    label="name" :reduce="name => name.id"  
                    v-model="item.inventory_movement_type_id"/>
              </div>
          </div>
          <div v-if="item.inventory_movement_type_id == 1">
            <div class="row" name="entry_movements" v-if="!disable">
              <div class="col-md-3">
                <label for="company_name" class="form-label mt-3"
                  >Almacen</label
                >
                <v-select 
                  :disabled="disable" 
                  name="storage_id" 
                  id="storage_id" 
                  :options="storages" 
                  label="name" :reduce="name => name.id"  
                  v-model="currentEntryMovement.storage_id"/>
              </div>
              <div class="col-md-3">
                <label for="company_name" class="form-label mt-3">Producto</label>
                  <v-select 
                    :disabled="disable" 
                    name="product_id" 
                    id="product_id" 
                    :options="products" 
                    label="name" :reduce="name => name.id"  
                    v-model="currentEntryMovement.product_id"/>
              </div>
              <div class="col-md-3">
                <label for="inputEmailC" class="form-label mt-3"
                  >Cantidad</label
                >
                <input
                  :disabled="disable"
                  v-model="currentEntryMovement.quantity"
                  name="number"
                  min="1"
                  type="text"
                  class="form-control"
                  id="emailCustomer"
                />
              </div>
              <div class="col-3 mt-6 d-flex justify-content-end">
                <button type="button" @click="addMovement" class="btn btn-primary mt-5">Agregar</button>
              </div>
            </div>
            <div class="row mt-5" v-if="item.entry_movements.length > 0">
              <table class="table table-sm">
                <thead>
                  <tr>
                    <th scope="col">Almacen</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col" v-if="!disable">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in item.entry_movements " :key="index">
                    <td>{{getStorageName(item.storage_id)}}</td>
                    <td>{{getProductName(item.product_id)}}</td>
                    <td>{{(item.quantity)}}</td>
                    <td v-if="!disable">
                       <button type="button" @click="removeItemEntry(item)" class="btn btn-danger d-flex justify-content-end">
                          <i class="bi bi-trash-fill"></i>
                       </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div v-if="item.inventory_movement_type_id == 2">
            <div class="row" name="output_movements" v-if="!disable">
              <div class="col-md-3">
                <label for="company_name" class="form-label mt-3"
                  >Almacen</label
                >
                <v-select 
                  :disabled="disable" 
                  name="storage_id" 
                  id="storage_id" 
                  :options="storages" 
                  label="name" :reduce="name => name.id"  
                  v-model="currentEntryMovement.storage_id"/>
              </div>
              <div class="col-md-3">
                <label for="company_name" class="form-label mt-3">Producto</label>
                  <v-select 
                    :disabled="disable" 
                    name="product_id" 
                    id="product_id" 
                    :options="products" 
                    label="name" :reduce="name => name.id"  
                    v-model="currentEntryMovement.product_id"/>
              </div>
              <div class="col-md-3">
                <label for="inputEmailC" class="form-label mt-3"
                  >Cantidad</label
                >
                <input
                  :disabled="disable"
                  v-model="currentEntryMovement.quantity"
                  name="number"
                  min="1"
                  type="text"
                  class="form-control"
                  id="emailCustomer"
                />
              </div>
              <div class="col-3 mt-6 d-flex justify-content-end">
                <button type="button" @click="addMovement" class="btn btn-primary mt-5">Agregar</button>
              </div>
            </div>
            <div class="row mt-5" v-if="item.entry_movements.length > 0">
              <table class="table table-sm">
                <thead>
                  <tr>
                    <th scope="col">Almacen</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col" v-if="!disable">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in item.entry_movements " :key="index">
                    <td>{{getStorageName(item.storage_id)}}</td>
                    <td>{{getProductName(item.product_id)}}</td>
                    <td>{{(item.quantity)}}</td>
                    <td v-if="!disable">
                       <button type="button" @click="removeItemEntry(item)" class="btn btn-danger d-flex justify-content-end">
                          <i class="bi bi-trash-fill"></i>
                       </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          </alv-form>
          <!-- END Put your code below -->
        </div>-
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
import Swal from "sweetalert2";

export default {
  name: "InventoryModal",
  components: {},
  data() {
    return {
      modal_button: {
        show: false,
      },
      alvRoute: route("supplier.store"),
      alvMethod: "PUT",
      event: [],
      inventoryMovementTypes: [],
      storages: [],
      products: [],
      item: {
        inventory_movement_type_id: '',
        entry_movements: [],
        output_movements: [],
      },
      currentEntryMovement: {
        storage_id: '',
        product_id: '',
        quantity: '',
      },
      disable: false,
      num: 1,
    };
  },
  methods: {

    afterDone() {
      this.modal_button.show = false;
      this.$refs.form.unsetButtonLoading();
      this.$emit("done");
    },
    beforeOpen(e) {
      this.getData();
      this.alvRoute = route("inventory-movement.store");
      this.alvMethod = "POST";
      this.item = {
        company_name: "",
        address: "",
        phone: "",
        rfc: "",
        email: "",
        social: "",
        entry_movements: [],
      };
      this.disable = false;

      if (typeof e.ref.params._rawValue.id != "undefined") {
        axios
          .get(route("inventory-movement.show", e.ref.params._rawValue.id), {
            params: {
              columns: JSON.stringify([
                'inventory_movement_type_id',
                "all_movements",
              ]),
            },
          })
          .then((response) => {
            this.item.inventory_movement_type_id = response.data.inventory_movement_type_id;
            this.item.entry_movements = response.data.all_movements;
          });
        this.alvRoute = route("inventory-movement.update", e.ref.params._rawValue.id);
        this.alvMethod = "PUT";
        this.disable = false;
      }
      if (typeof e.ref.params._rawValue.show != "undefined") {
        this.disable = true;
      }
    },
    addMovement(){
      switch(this.current_movement_name){
        case 'Entrada':
          if(this.item.entry_movements.length > 0){
            var replyItemIndex = this.item.entry_movements.findIndex((element) => 
              element.storage_id == this.currentEntryMovement.storage_id && 
              element.product_id == this.currentEntryMovement.product_id);
            if(replyItemIndex != -1){
              Swal.fire({
                title: "Entrada repetida",
                text: "¿Quieres sumar la cantidad o reemplazar la entrada?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Sumalo",
                confirmButtonText: "Cambialo",
              }).then((result) => {
                if (result.isConfirmed) {
                  this.item.entry_movements[replyItemIndex] = this.currentEntryMovement;
                  this.currentEntryMovement = {
                      storage_id: '',
                      product_id: '',
                      quantity: '',
                    }
                }else{
                  this.item.entry_movements[replyItemIndex].quantity = Number(this.item.entry_movements[replyItemIndex].quantity) + Number(this.currentEntryMovement.quantity);
                  this.currentEntryMovement = {
                      storage_id: '',
                      product_id: '',
                      quantity: '',
                    }
                }
              });
            }else{
                this.item.entry_movements.push(this.currentEntryMovement);
                this.currentEntryMovement = {
                  storage_id: '',
                  product_id: '',
                  quantity: '',
                }
            }
          }else{
              this.item.entry_movements.push(this.currentEntryMovement);
              this.currentEntryMovement = {
                storage_id: '',
                product_id: '',
                quantity: '',
              }
          }
        break;
        case 'Salida':

        break;
        case 'Movimiento entre almacenes':
        
        break;
          
      }
    },
    getStorageName(id){
        return this.storages.find((element) => element.id == id).name;
    },
    getProductName(id){
        return this.products.find((element) => element.id == id).name;
    },
    removeItemEntry(item){
        this.item.entry_movements.splice(item,1);
    },
    getData(){
      axios.get(route("inventory_movement_type.index"),{ params:{
          columns: JSON.stringify(['id','name'])
        }}).then((response) => {
          this.inventoryMovementTypes = response.data.data;
      });
      
      axios.get(route("storage.index"),{ params:{
          columns: JSON.stringify(['id','name'])
        }}).then((response) => {
          this.storages = response.data.data;
      });

      axios.get(route("product.index"),{ params:{
          columns: JSON.stringify(['id','name'])
         }}).then((response) => {
            this.products = response.data.data;
        });
    },
  },

  computed:{
      current_movement_name(){
        if(this.item.inventory_movement_type_id != ''){
          var item = this.inventoryMovementTypes.find((element) => element.id == this.item.inventory_movement_type_id);
          return item.name
        }else{
          return '';
        }
        
     }
  }

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
