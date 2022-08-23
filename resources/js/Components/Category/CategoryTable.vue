<template>
    <div>
        <div>
            <div class="row mb-3 ">
                <div class="col-12 d-flex justify-content-end">
                     <button type="button" class="btn btn-outline-primary" style="margin-right: 1rem;" 
                        @click="exportToExcel">Exportar</button>
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
                    @do-search="getData"
                    @VnodeMounted="initTable"
                    >
                    <template v-slot:description="data">
                        <span :class="data.value.description == null ? 'badge bg-danger' : ''"> 
                        {{(data.value.description == null ? 'No tiene' : data.value.description)}}
                        </span>
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
        <category-modal @done="fin"></category-modal>
    </div>
</template>



<script setup>
import CategoryTableColumns  from "./CategoryTableColumns"
import CategoryModal  from "./CategoryModal"
import { onMounted, reactive, ref, createApp, defineComponent, h, watch  } from "vue";
import Swal from 'sweetalert2'
import { useToast } from "vue-toastification";

const toast = useToast()

const filters = reactive({
  name: null,
  description: null,
  Formatted_created_at:null,
})

const tableOptions = reactive({
        columns: CategoryTableColumns.columns,
        sortable:{ order: "id", sort: "desc" },
        isLoading: true,
        messages: { pagingInfo: "Mostrando {0}-{1} de {2}", pageSizeChangeLabel: "Numero de registros:", gotoPageLabel: "Ir a pagina:", noDataAvailable: "Sin informacion",},
        rows: [],
        total: 0
});

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
axios.get(route("categories.index", {
    columns: JSON.stringify(['id','name','description','Formatted_created_at']), 
    limit:_limit, 
    page:_offset+1, 
    orderBy:_orderBy, 
    ascending:_ascending,
    filters: JSON.stringify(filters),
    })).then((response) => {
            tableOptions.rows = response.data.data;
            tableOptions.total = response.data.count;
            tableOptions.isLoading = false;
    });
}

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
                value: filters.Formatted_created_at,
                onInput: (e) => {
                  filters.Formatted_created_at = e.target.value;
                },
              });
          },
        })
      ).mount(childTh[2]);
      // append cloned element to the header after first <tr>
      headerTr[0].after(cloneTr)
  };

const exportToExcel = () => {
  axios({
    url: route("stock.export"),
    method: "GET",
    responseType: "blob",
  }).then((response) => {
    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute(
      "download",
      "Categorias.xlsx"
    );
    document.body.appendChild(link);
    link.click();
  });
  
}

const sharedItem = () => {
    console.log(1);
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
            axios.delete(route("categories.destroy",_id)).then((response) => {
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
