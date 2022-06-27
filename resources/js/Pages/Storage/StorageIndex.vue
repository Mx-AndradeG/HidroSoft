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
                <h5 class="card-title">Almacenes</h5>
                <div id="people">
                  <storage-table></storage-table>
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
import StorageTable from "../../Components/Storage/StorageTable.vue";
import { defineComponent } from "vue";

export default defineComponent({
  name: "App",
  components: { AdminLayout, StorageTable },
});
</script>
