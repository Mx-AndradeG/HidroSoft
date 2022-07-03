<template>
  <div>
    <admin-layout>
      <div class="pagetitle">
        <h1>Movimientos de Inventarios</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Sucursales</a></li>
            <li class="breadcrumb-item active"> Movimientos de Inventarios</li>
          </ol>
        </nav>
      </div>
      <!-- End Page Title -->

      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"> Movimientos de Inventarios</h5>
                <div id="people">
                  <inventory-table></inventory-table>
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
import InventoryTable from "../../Components/Inventory/InventoryTable.vue";
import { defineComponent } from "vue";

export default defineComponent({
  name: "App",
  components: { AdminLayout, InventoryTable },
});
</script>
