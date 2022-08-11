<template>
  <div>
    <div>
      <div class="row mb-3">
        <div class="col-6">
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
            @click="$vfm.show('branch_modal')"
            type="button"
            class="btn btn-primary"
          >
            Nueva sucursal
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
      @VnodeMounted="initTable"
    >
      <template v-slot:address="data">
        <span :class="data.value.address == null ? 'badge bg-danger' : 'badge bg-success'"> 
          {{(data.value.address == null ? 'Sin dirección' : data.value.address)}}
        </span>
      </template>
      <template v-slot:actions="data">
        <div class="row">
          <div class="col-3">
            <a
              type="click"
              @click="
                $vfm.show('branch_modal', { id: data.value.id, show: true })
              "
            >
              <i
                data-toggle="tooltip"
                data-placement="bottom"
                title="Ver registro"
                class="ri-eye-fill fs-4"
                style="color: forestgreen; cursor: pointer"
              ></i>
            </a>
          </div>
          <div class="col-3">
            <a
              type="click"
              @click="$vfm.show('branch_modal', { id: data.value.id })"
            >
              <i
                data-toggle="tooltip"
                data-placement="bottom"
                title="Editar Cliente"
                class="ri-edit-box-fill fs-4"
                style="color: #0748db; cursor: pointer"
              ></i>
            </a>
          </div>
          <div class="col-3" v-if="!data.value.has_storage">
            <a @click="deleteItem(data.value.id)">
              <i
                data-toggle="tooltip"
                data-placement="bottom"
                title="Eliminar cliente"
                class="ri-chat-delete-fill fs-4"
                style="color: crimson; cursor: pointer"
              ></i>
            </a>
          </div>
        </div>
      </template>
    </TableLite>
    <branch-modal @done="fin"></branch-modal>
  </div>
</template>



<script setup>

const filters = reactive({
  name: null,
  address:null,
  phone:null,
  Formatted_created_at:null
})

import BranchTableColumns from "./BranchTableColumns";
import BranchModal from "./BranchModal.vue";
import { onMounted, reactive, ref, createApp, defineComponent, h, watch  } from "vue";
import Swal from "sweetalert2";
import { useToast } from "vue-toastification";

const toast = useToast();

const tableOptions = reactive({
  columns: BranchTableColumns.columns,
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


watch(filters, (newValue, oldValue) => {
   getData(0, 10, "id", "desc");
})

    const initTable = ({ el: tableComponent }) => {
      let headerTr = tableComponent.getElementsByClassName("vtl-thead-tr");
      if (! headerTr[0]) {
        return;
      }
      let cloneTr = headerTr[0].cloneNode(true); // Clone first <tr>
      let childTh = cloneTr.getElementsByClassName("vtl-thead-th");
      for(let i = 0; i < childTh.length; i++) {
        // Clear <th>'s HTML
        childTh[i].innerHTML = "";
      }
      // Create a input element and append to first <th>
      createApp(
        defineComponent({
          setup() {
            return () =>
              h("input", {
                value: filters.name,
                onInput: (e) => {
                  filters.name = e.target.value;
                },
              });
          },
        })
      ).mount(childTh[0]);
      
      createApp(
        defineComponent({
          setup() {
            return () =>
              h("input", {
                value: filters.address,
                onInput: (e) => {
                  filters.address = e.target.value;
                },
              });
          },
        })
      ).mount(childTh[1]);

      createApp(
        defineComponent({
          setup() {
            return () =>
              h("input", {
                value: filters.phone,
                onInput: (e) => {
                  filters.phone = e.target.value;
                },
              });
          },
        })
      ).mount(childTh[2]);

      createApp(
        defineComponent({
          setup() {
            return () =>
              h("input", {
                value: filters.Formatted_created_at,
                onInput: (e) => {
                  filters.Formatted_created_at = e.target.value;
                },
              });
          },
        })
      ).mount(childTh[3]);
      // append cloned element to the header after first <tr>
      headerTr[0].after(cloneTr)
    };

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
      route("branch.index", {
        columns: JSON.stringify([
          "id",
          "name",
          "address",
          "phone",
          "rfc",
          "has_storage",
          "Formatted_created_at",
        ]),
        filters: JSON.stringify(filters),
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
    text: "¿Esta seguro que quiere eliminar esta sucursal?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "No, dejalo",
    confirmButtonText: "Si, borralo!",
  }).then((result) => {
    if (result.isConfirmed) {
      axios.delete(route("branch.destroy", _id)).then((response) => {
        getData(0, 10, "id", "desc");
        toast.success("Cliente borrado exitosamente", {
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
