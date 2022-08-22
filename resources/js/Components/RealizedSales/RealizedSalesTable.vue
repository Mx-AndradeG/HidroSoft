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
          <a
            :href="route('PointOfSale')"
            type="button"
            class="btn btn-primary"
          >
            Nueva venta
          </a>
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
      <template v-slot:sale_type_name="data">
        <span :class="data.value.sale_type_name == 'Contado' ? 'badge bg-success': 'badge bg-warning'"> 
          {{(data.value.sale_type_name)}}
        </span>
      </template>

      <template v-slot:sale_status_name="data">
        <span :class="data.value.sale_status_name == 'Pagado' ? 'badge bg-success': 
                      (data.value.sale_status_name == 'Sin pago' ? 'badge bg-danger':'badge bg-warning')"> 
          {{(data.value.sale_status_name)}}
        </span>
      </template>

      <template v-slot:payment_method_name="data">
        <span :class="data.value.payment_method_name == 'Efectivo' ? 'badge bg-success': data.value.payment_method_name == 'Credito' ? 'badge bg-warning' : 'badge bg-primary'"> 
          {{(data.value.payment_method_name)}}
        </span>
      </template>

      <template v-slot:actions="data">
        <div class="row">
          <div class="col-4">
            <a
              type="click"
              @click="
                $vfm.show('sale_modal', { id: data.value.id, show: true })
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
          <div class="col-4"><a type="click" @click="showTicket(data.value.id)">
                  <i data-toggle="tooltip" data-placement="bottom" title="Imprimir ticket" class="ri-ticket-2-fill fs-3" style="color: #FFC107; cursor:pointer;"></i>
          </a></div>
          <div class="col-4"><a type="click" @click="$vfm.show('preview_payments_modal', {id:data.value.id})">
                  <i data-toggle="tooltip" data-placement="bottom" title="Ver pagos" class="ri-money-dollar-circle-fill fs-3" style="color: #0748db; cursor:pointer;"></i>
          </a></div>
         <div v-if="data.value.sale_status_name != 'Pagado'" class="col-4"><a type="click" @click="$vfm.show('StorePaymentModal', {id:data.value.id})">
                  <i data-toggle="tooltip" data-placement="bottom" title="Registrar pago" class="ri-add-circle-fill fs-3" style="color: forestgreen; cursor:pointer;"></i>
          </a></div>
        </div>
      </template>
    </TableLite>
    <realized-sales-modal @done="fin"></realized-sales-modal>
    <payment-dates-modal></payment-dates-modal>
    <store-payment-modal @done="fin"></store-payment-modal>
  </div>
</template>



<script setup>
import RealizedSalesTableColumns from "./RealizedSalesTableColumns";
import RealizedSalesModal from "./RealizedSalesModal.vue";
import PaymentDatesModal from "./PaymentDatesModal.vue";
import StorePaymentModal from "./StorePaymentModal.vue";
import { onMounted, reactive, ref, createApp, defineComponent, h, watch } from "vue";
import Swal from "sweetalert2";
import { useToast } from "vue-toastification";
const filters = reactive({
  user_name: null,
  branch_name:null,
  customer_name:null,
  sale_type_name:null,
  payment_method_name:null,
  formatted_total_sale:null,
  Formatted_created_at:null,
})



const branch_name_filter = ref(""); // Search text
const searchTerm2 = ref(""); // Search text
const toast = useToast();
const data = ref([]); // fake data
const valueFilter = ref(""); // Search text

const tableOptions = reactive({
  columns: RealizedSalesTableColumns.columns,
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
                value: filters.branch_name,
                onInput: (e) => {
                  filters.branch_name = e.target.value;
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
                value: filters.customer_name,
                onInput: (e) => {
                  filters.customer_name = e.target.value;
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
                value: filters.sale_type_name,
                onInput: (e) => {
                  filters.sale_type_name = e.target.value;
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
                value: filters.payment_method_name,
                onInput: (e) => {
                  filters.payment_method_name = e.target.value;
                },
              });
          },
        })
      ).mount(childTh[4]);

      createApp(
        defineComponent({
          setup() {
            return () =>
              h("input", {
                class: "form-control form-control-sm",
                value: filters.sale_status_name,
                onInput: (e) => {
                  filters.sale_status_name = e.target.value;
                },
              });
          },
        })
      ).mount(childTh[5]);

      createApp(
        defineComponent({
          setup() {
            return () =>
              h("input", {
                class: "form-control form-control-sm",
                value: filters.formatted_total_sale,
                onInput: (e) => {
                  filters.formatted_total_sale = e.target.value;
                },
              });
          },
        })
      ).mount(childTh[6]);

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
      ).mount(childTh[7]);
      // append cloned element to the header after first <tr>
      headerTr[0].after(cloneTr)
    };

const exportToExcel = () => {
  axios({
    url: route("sales.export"),
    method: "GET",
    responseType: "blob",
  }).then((response) => {
    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute(
      "download",
      "Ventas_realizadas_.xlsx"
    );
    document.body.appendChild(link);
    link.click();
  });
  
}


const showTicket = (id) => {
    axios
    .get(route("sales.print.ticket", id))
    .then((response) => {
      window.open(response.data)
    });
}

const getData = (_offset, _limit, _orderBy, _ascending) => {
  tableOptions.isLoading = true;
  _ascending = _ascending === "desc" ? "1" : "2";
  axios
    .get(
      route("sales.index", {
        columns: JSON.stringify([
          "id",
          "user_name",
          "branch_name",
          "customer_name",
          "payment_method_name",
          "sale_type_name",
          "sale_status_name",
          "formatted_total_sale",
          "Formatted_created_at"
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
    text: "¿Esta seguro que quiere eliminar este cliente?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "No, dejalo",
    confirmButtonText: "Si, borralo!",
  }).then((result) => {
    if (result.isConfirmed) {
      axios.delete(route("customer.destroy", _id)).then((response) => {
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
