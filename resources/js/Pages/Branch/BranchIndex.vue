<template>
  <div>
    <admin-layout>
      <div class="pagetitle">
        <h1>Sucursales</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Sucursales</a></li>
            <li class="breadcrumb-item active">Sucursales</li>
          </ol>
        </nav>
      </div>
      <!-- End Page Title -->

      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Sucursales</h5>
                <div id="people">
                  <branch-table></branch-table>
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
import BranchTable from "../../Components/Branch/BranchTable.vue";
import { defineComponent } from "vue";

export default defineComponent({
  name: "App",
  components: { AdminLayout, BranchTable },
});
</script>
