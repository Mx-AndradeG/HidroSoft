<template>
  <div>
    <div>
      <div class="row mb-3">
        <div class="col-6">
          <input
            v-model="valueFilter"
            type="text"
            class="form-control"
            id="floatingInput"
            placeholder="Escriba algo para buscar..."
          />
        </div>
        <div class="col-6 d-flex justify-content-end">
          <button
            type="button"
            class="btn btn-outline-primary"
            style="margin-right: 1rem"
          >
            Exportar
          </button>
          <button
            @click="$vfm.show('customer_modal')"
            type="button"
            class="btn btn-primary"
          >
            Nuevo almacen
          </button>
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
          <div class="col-4">
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
          <div class="col-4">
            <a
              type="click"
              @click="$vfm.show('customer_modal', { id: data.value.id })"
            >
              <i
                data-toggle="tooltip"
                data-placement="bottom"
                title="Editar Cliente"
                class="ri-edit-box-fill fs-3"
                style="color: #0748db; cursor: pointer"
              ></i>
            </a>
          </div>
          <div class="col-4" v-if="!data.value.has_stock" >
            <a @click="deleteItem(data.value.id)">
              <i
                data-toggle="tooltip"
                data-placement="bottom"
                title="Eliminar cliente"
                class="ri-chat-delete-fill fs-3"
                style="color: crimson; cursor: pointer"
              ></i>
            </a>
          </div>
        </div>
      </template>
    </TableLite>
    <storage-modal @done="fin"></storage-modal>
  </div>
</template>



<script setup>
import StorageTableColumns from "./StorageTableColumns";
import StorageModal from "./StorageModal.vue";
import { onMounted, reactive } from "vue";
import Swal from "sweetalert2";
import { useToast } from "vue-toastification";

const toast = useToast();

const tableOptions = reactive({
  columns: StorageTableColumns.columns,
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

const getData = (_offset, _limit, _orderBy, _ascending) => {
  tableOptions.isLoading = true;
  _ascending = _ascending === "desc" ? "1" : "2";
  axios
    .get(
      route("storage.index", {
        columns: JSON.stringify([
          "id",
          'name',
          "address",
          "branch_name",
          "has_stock",
          "Formatted_created_at",
        ]),
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
    text: "¿Esta seguro que quiere eliminar este proveedor?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "No, dejalo",
    confirmButtonText: "Si, borralo!",
  }).then((result) => {
    if (result.isConfirmed) {
      axios.delete(route("storage.destroy", _id)).then((response) => {
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
  getData(0, 10, "id", "desc");
});
</script>
