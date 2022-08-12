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

    </TableLite>
  </div>
</template>



<script setup>
import LogTableColumns from "./LogTableColumns";
import { onMounted, reactive, ref, createApp, defineComponent, h, watch  } from "vue";
import Swal from "sweetalert2";
import { useToast } from "vue-toastification";

const toast = useToast();

const filters = reactive({
  user_name: null,
  module: null,
  type: null,
  action: null,
  Formatted_created_at:null,
})

const tableOptions = reactive({
  columns: LogTableColumns.columns,
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
                value: filters.user_name,
                onInput: (e) => {
                  filters.user_name = e.target.value;
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
                value: filters.module,
                onInput: (e) => {
                  filters.module = e.target.value;
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
                value: filters.type,
                onInput: (e) => {
                  filters.type = e.target.value;
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
                value: filters.action,
                onInput: (e) => {
                  filters.action = e.target.value;
                },
              });
          },
        })
      ).mount(childTh[3]);

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
      ).mount(childTh[4]);
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
    url: route("Log.export"),
    method: "GET",
    responseType: "blob",
  }).then((response) => {
    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute(
      "download",
      "Bitacora.xlsx"
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
      route("Log.index", {
        columns: JSON.stringify([
          "user_name",
          "module",
          "type",
          "action",
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
