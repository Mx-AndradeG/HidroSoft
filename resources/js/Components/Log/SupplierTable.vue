<template>
  <div>
    <div>
      <div class="row mb-3">
        <div class="col-12 d-flex justify-content-end">
          <button
            type="button"
            class="btn btn-outline-primary"
            style="margin-right: 1rem"
            @click="exportToExcel"
          >
            Exportar
          </button>
          <button
            @click="$vfm.show('customer_modal')"
            type="button"
            class="btn btn-primary"
          >
            Nuevo Proveedor
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
        <span :class="data.value.address == null ? 'badge bg-danger' : ''"> 
          {{(data.value.address == null ? 'Sin dirección' : data.value.address)}}
        </span>
      </template>
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
          <div class="col-4">
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
    <supplier-modal @done="fin"></supplier-modal>
  </div>
</template>



<script setup>
import SupplierTableColumns from "./LogTableColumns";
import SupplierModal from "./SupplierModal.vue";
import { onMounted, reactive, ref, createApp, defineComponent, h, watch  } from "vue";
import Swal from "sweetalert2";
import { useToast } from "vue-toastification";

const toast = useToast();

const filters = reactive({
  name: null,
  address: null,
  email: null,
  Formatted_created_at:null,
})

const tableOptions = reactive({
  columns: SupplierTableColumns.columns,
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
                class: "form-control form-control-sm",
                value: filters.company_name,
                onInput: (e) => {
                  filters.company_name = e.target.value;
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
                class: "form-control form-control-sm",
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
                class: "form-control form-control-sm",
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
                class: "form-control form-control-sm",
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

watch(filters, (newValue, oldValue) => {
   getData(0, 10, "id", "desc");
})

const exportToExcel = () => {
  axios({
    url: route("supplier.export"),
    method: "GET",
    responseType: "blob",
  }).then((response) => {
    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute(
      "download",
      "Proveedores.xlsx"
    );
    document.body.appendChild(link);
    link.click();
  });
  
}

const getData = (_offset, _limit, _orderBy, _ascending) => {
  tableOptions.isLoading = true;
  _ascending = _ascending === "desc" ? "1" : "2";
  axios
    .get(
      route("supplier.index", {
        columns: JSON.stringify([
          "id",
          "company_name",
          "address",
          "phone",
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
    text: "¿Esta seguro que quiere eliminar este proveedor?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "No, dejalo",
    confirmButtonText: "Si, borralo!",
  }).then((result) => {
    if (result.isConfirmed) {
      axios.delete(route("supplier.destroy", _id)).then((response) => {
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
