<template>
  <div>
    <admin-layout>
      <div class="pagetitle">
        <h1>Inventarios</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Sucursales</a></li>
            <li class="breadcrumb-item active">Inventarios</li>
          </ol>
        </nav>
      </div>
      <!-- End Page Title -->

      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Inventarios</h5>
                <div id="people">
                  <div v-if="!show">
                    <div class="row" >
                        <div class="col-10">
                          <label for="inputName5" class="form-label mt-3"
                            >Almacenes</label
                          >
                          <v-select
                            name="storage_id"
                            id="storage_id"
                            :options="storages"
                            label="name"
                            :reduce="(name) => name.id"
                            v-model="storage_id"
                          />
                        </div>
                        <div class="col-2 mt-5">
                            <button
                              v-if="storage_id != null"
                              @click="shareInfo()"
                              type="button"
                              class="btn btn-primary"
                            >
                              Ver inventario
                            </button>
                        </div>
                    </div>
                    <center>
                      <div class="row" style="padding-top:10%;" >
                        <div class="col-12">
                          <img src="../../../Templates/NiceAdmin/img/undraw_deliveries_2r4y.svg" alt="" style="width:40%">
                          <br> <br> <span class="h4 pt-4"> Selecciona un almacén</span>
                        </div>
                      </div>
                    </center>

                  </div>
                  <stock-table :storage_id="storage_id" v-else></stock-table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </admin-layout>
  </div>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import StockTable from "../../Components/Stock/StockTable.vue";
import { defineComponent } from "vue";

export default defineComponent({
  name: "App",
  components: { AdminLayout, StockTable },
  data() {
    return {
      storages: [],
      storage_id: null,
      show: false,
    };
  },
  methods: {
    getBranchId() {
      axios.get(route("storage.index", {
        columns: JSON.stringify([ "id","name",])
      })).then((response) => {
        this.storages = response.data.data;
      });
    },
    shareInfo() {
      this.show = true;
    },
  },
  mounted() {
    this.storage_id = null;
    this.getBranchId();
  },
});
</script>
