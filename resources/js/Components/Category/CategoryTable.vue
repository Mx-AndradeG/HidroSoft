<template>
    <div>
        <div>
            <div class="row mb-3 ">
                <div class="col-6">
                        <input v-model="valueFilter" type="text" class="form-control" id="floatingInput" placeholder="Escriba algo para buscar...">
                </div>
                <div class="col-6 d-flex justify-content-end">
                     <button type="button" class="btn btn-outline-primary" style="margin-right: 1rem;">Exportar</button>
                     <button type="button" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
        <TableLite :is-loading="tableOptions.isLoading" :columns="tableOptions.columns" 
                    :rows="tableOptions.rows" 
                    :sortable="tableOptions.sortable"
                    :total="tableOptions.total"
                    :messages="tableOptions.messages"
                    :is-slot-mode="true"> 

        <template v-slot:actions>
            <div class="row">
                <div class="col-4"><a><i class="ri-eye-fill fs-3"  style="color: forestgreen;"></i></a></div>
                <div class="col-4"><a> <i class="ri-edit-box-fill fs-3" style="color: #0748db;"></i> </a></div>
                <div class="col-4"><a> <i class="ri-chat-delete-fill fs-3" style="color: crimson;"></i></a></div>
            </div>

        </template>
        </TableLite>
    </div>
</template>



<script setup>
import CategoryTableColumns  from "./CategoryTableColumns"
import { onMounted, reactive } from "vue";

const tableOptions = reactive({
        columns: CategoryTableColumns.columns,
        sortable:{ order: "id", sort: "desc" },
        isLoading: true,
        messages: { pagingInfo: "Mostrando {0}-{1} de {2}", pageSizeChangeLabel: "Numero de registros:", gotoPageLabel: "Ir a pagina:", noDataAvailable: "Sin informacion",},
        rows: [],
        total: 0
});

const valueFilter = reactive('');

const getData = () => {
 axios.get(route("categories.index", {columns: JSON.stringify(['id','name','description','Formatted_created_at'])})).then((response) => {
            tableOptions.rows = response.data.data;
            tableOptions.total = response.data.count;
            tableOptions.isLoading = false;
    });
}

onMounted(() => {
   getData();
});

</script>
