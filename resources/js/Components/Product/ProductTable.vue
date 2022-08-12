<template>
    <div>
        <div>
            <div class="row mb-3 ">
                <div class="col-12 d-flex justify-content-end">
                     <button type="button" class="btn btn-outline-primary" style="margin-right: 1rem;" @click="exportToExcel">Exportar</button>
                     <button  @click="$vfm.show('category_modal')" type="button" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
        <TableLite :is-loading="tableOptions.isLoading" :columns="tableOptions.columns"
                    :rows="tableOptions.rows"
                    :sortable="tableOptions.sortable"
                    :total="tableOptions.total"
                    :messages="tableOptions.messages"
                    :is-slot-mode="true"
                    @VnodeMounted="initTable"
                    @do-search="getData">

                    <template v-slot:sale_price="data">
                       {{formatPrice(data.value.sale_price)}}
                    </template>
                    <template v-slot:purchase_price="data">
                        {{formatPrice(data.value.purchase_price)}}
                    </template>

                    <template v-slot:actions="data">
                        <div class="row">
                            <div class="col-4"><a type="click" @click="$vfm.show('category_modal', {id:data.value.id, show:true})">
                                <i data-toggle="tooltip" data-placement="bottom" title="Ver registro" class="ri-eye-fill fs-3"  style="color: forestgreen; cursor:pointer;"></i>
                            </a></div>
                            <div class="col-4"><a type="click" @click="$vfm.show('category_modal', {id:data.value.id})">
                                <i data-toggle="tooltip" data-placement="bottom" title="Editar registro" class="ri-edit-box-fill fs-3" style="color: #0748db; cursor:pointer;"></i>
                            </a></div>
                            <div class="col-4"><a @click="deleteItem(data.value.id)">
                                <i data-toggle="tooltip" data-placement="bottom" title="Eliminar registro" class="ri-chat-delete-fill fs-3" style="color: crimson; cursor:pointer;"></i>
                            </a></div>
                        </div>
                    </template>
        </TableLite>
        <product-modal @done="fin"></product-modal>
    </div>
</template>



<script setup>
import ProductTableColumns  from "./ProductTableColumns"
import ProductModal  from "./ProductModal"
import { onMounted, reactive, ref, createApp, defineComponent, h, watch  } from "vue";
import Swal from 'sweetalert2'
import { useToast } from "vue-toastification";

const toast = useToast()

const filters = reactive({
  name: null,
  purchase_price: null,
  description:null,
  code:null,
  sale_price:null,
  category_name:null,
  supplier_name:null,
  Formatted_created_at:null,
})

watch(filters, (newValue, oldValue) => {
   getData(0, 10, "id", "desc");
})


const formatPrice = (value) => {
    var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    });
    return formatter.format(value);
}

const tableOptions = reactive({
        columns: ProductTableColumns.columns,
        sortable:{ order: "id", sort: "desc" },
        isLoading: true,
        messages: { pagingInfo: "Mostrando {0}-{1} de {2}", pageSizeChangeLabel: "Numero de registros:", gotoPageLabel: "Ir a pagina:", noDataAvailable: "Sin informacion",},
        rows: [],
        total: 0
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
                class: "form-control form-control-sm",
                value: filters.description,
                onInput: (e) => {
                  filters.description = e.target.value;
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
                value: filters.code,
                onInput: (e) => {
                  filters.code = e.target.value;
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
                value: filters.sale_price,
                onInput: (e) => {
                  filters.sale_price = e.target.value;
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
                value: filters.purchase_price,
                onInput: (e) => {
                  filters.purchase_price = e.target.value;
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
                value: filters.supplier_name,
                onInput: (e) => {
                  filters.supplier_name = e.target.value;
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
                value: filters.category_name,
                onInput: (e) => {
                  filters.category_name = e.target.value;
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

const fin = () =>{
   getData(0, 10, 'id', 'desc');
    toast.success("Accion realizada correctamente",{
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
    rtl: false
});
}

const getData = (_offset, _limit, _orderBy, _ascending) => {
tableOptions.isLoading = true;
_ascending = _ascending === "desc" ? '1' : '2';
axios.get(route("product.index", {columns: JSON.stringify([
        'id',
        'name',
        'purchase_price',
        'description',
        'code',
        'sale_price',
        'category_name',
        'supplier_name',
        'Formatted_created_at']), 
    limit:_limit, page:_offset+1, orderBy:_orderBy, ascending:_ascending,
    filters: JSON.stringify(filters),
    })).then((response) => {
            tableOptions.rows = response.data.data;
            tableOptions.total = response.data.count;
            tableOptions.isLoading = false;
    });
}

const exportToExcel = () => {
  axios({
    url: route("product.export"),
    method: "GET",
    responseType: "blob",
  }).then((response) => {
    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute(
      "download",
      "Productos.xlsx"
    );
    document.body.appendChild(link);
    link.click();
  });
  
}

const deleteItem = (_id) =>{
        Swal.fire({
            title: 'Eliminar registro',
            text: "¿Esta seguro que quiere eliminar el registro?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No, dejalo',
            confirmButtonText: 'Si, borralo!'
        }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(route("product.destroy",_id)).then((response) => {
                getData(0, 10, 'id', 'desc');
            toast.success("Elemento borrado exitosamente",{
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
                rtl: false
            });
            });
        }})
}


onMounted(() => {
   getData(0, 10, 'id', 'desc');
});

</script>
