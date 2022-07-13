<template>
  <div>
    <div>
        <div class="row pb-6" >
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
                  v-if="storage_id != ''"
                  @click="shareInfo()"
                  type="button"
                  class="btn btn-primary"
                >
                  Ver inventario
                </button>
            </div>
        </div>
        <center  v-if="!show">
          <div class="row" style="padding-top:10%;" >
            <div class="col-12">
              <img src="../../../Templates/NiceAdmin/img/undraw_deliveries_2r4y.svg" alt="" style="width:40%">
              <br> <br> <span class="h4 pt-4"> Selecciona un almacén</span>
            </div>
          </div>
        </center>
    </div>
    <div v-if="show">
      <div class="pt-3 mb-3">
        <div class="row pt-3 mb-3">
          <div class="col-6">
            <input
              v-model="valueFilter"
              type="text"
              class="form-control"
              id="floatingInput"
              placeholder="Escriba algo para buscar..."
            />
          </div>
        </div>
      </div>
      <TableLite
        :is-loading="tableOptions.isLoading"
        :columns="tableOptions.columns"
        :rows="tableOptions.rows"
        :sortable="tableOptions.sortable"
        :total="tableOptions.total"
        :messages="tableOptions.messages"
        :is-slot-mode="true"
        @do-search="getData"
      >
        <template v-slot:actions="data">
          <div class="row">
            <div class="col-12">
              <a
                type="click"
                @click="
                  $vfm.show('customer_modal', { id: data.value.id, show: true })
                "
              >
                <i
                  data-toggle="tooltip"
                  data-placement="bottom"
                  title="Ver registro"
                  class="ri-eye-fill fs-3"
                  style="color: forestgreen; cursor: pointer"
                ></i>
              </a>
            </div>
          </div>
        </template>
      </TableLite>
      <stock-table-columns @done="fin"></stock-table-columns>
    </div>
  </div>
</template>



<script setup>
import StockTableColumns from "./StockTableColumns";
import { onMounted, reactive, ref } from "vue";
import Swal from "sweetalert2";
import { useToast } from "vue-toastification";
const toast = useToast();


const tableOptions = reactive({
  columns: StockTableColumns.columns,
  sortable: { order: "id", sort: "desc" },
  isLoading: true,
  messages: {
    pagingInfo: "Mostrando {0}-{1} de {2}",
    pageSizeChangeLabel: "Numero de registros:",
    gotoPageLabel: "Ir a pagina:",
    noDataAvailable: "Sin informacion",
  },
  rows: [],
  total: 0,
});

const fin = () => {
  getData(0, 10, "id", "desc");
  toast.success("Accion realizada correctamente", {
    position: "top-center",
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: true,
    closeButton: "button",
    icon: true,
    rtl: false,
  });
};

const storages = ref([]);
const storage_id = ref('');
const show = ref(false);


 const getBranchId = () => {
      axios.get(route("wherehouses.index", {
        columns: JSON.stringify([ "id","name",])
      })).then((response) => {
        storages.value = response.data.data;
      });
  };

const shareInfo = () => {
    show.value = true;
    getData(0, 10, "id", "desc");
};

const getData = (_offset, _limit, _orderBy, _ascending) => {
  tableOptions.isLoading = true;
  _ascending = _ascending === "desc" ? "1" : "2";
  axios
    .get(
      route("stock.index", {
        columns: JSON.stringify([
          "id",
          'product_name',
          'storage_name',
          'quantity'
        ]),
        filters: JSON.stringify({
          'storage_id': storage_id.value,
        }),
        limit: _limit,
        page: _offset + 1,
        orderBy: _orderBy,
        ascending: _ascending,
      })
    )
    .then((response) => {
      tableOptions.rows = response.data.data;
      tableOptions.total = response.data.count;
      tableOptions.isLoading = false;
    });
};

const deleteItem = (_id) => {
  Swal.fire({
    title: "Eliminar registro",
    text: "¿Esta seguro que quiere eliminar este registro?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "No, dejalo",
    confirmButtonText: "Si, borralo!",
  }).then((result) => {
    if (result.isConfirmed) {
      axios.delete(route("wherehouses.destroy", _id)).then((response) => {
        getData(0, 10, "id", "desc");
        toast.success("Proveedor borrado exitosamente", {
          position: "top-center",
          closeOnClick: true,
          pauseOnFocusLoss: true,
          pauseOnHover: true,
          draggable: true,
          draggablePercent: 0.6,
          showCloseButtonOnHover: false,
          hideProgressBar: false,
          closeButton: "button",
          icon: true,
          rtl: false,
        });
      });
    }
  });
};

onMounted(() => {
  getBranchId()
});
</script>
