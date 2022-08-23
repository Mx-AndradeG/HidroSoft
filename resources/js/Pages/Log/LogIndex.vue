<template>
  <div>
    <admin-layout>
      <div class="pagetitle">
        <h1>Bitacora</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Administracion</a></li>
            <li class="breadcrumb-item active">Bitacora</li>
          </ol>
        </nav>
      </div>
      <!-- End Page Title -->

      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Bitacora</h5>
                <div id="people">
                  <log-table></log-table>
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
import LogTable from "../../Components/Log/LogTable.vue";
import { defineComponent } from "vue";

export default defineComponent({
  name: "App",
  components: { AdminLayout, LogTable },
});
</script>
