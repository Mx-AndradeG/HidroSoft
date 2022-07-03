<template>
    <div>
    <admin-layout>
      <div class="pagetitle">
        <h1>Punto de venta</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Ventas</a></li>
            <li class="breadcrumb-item active">Punto de venta</li>
          </ol>
        </nav>
      </div>
      <!-- End Page Title -->

      <section class="section">
        <div class="row">
          <point-of-sale-table></point-of-sale-table>      
        </div>
      </section>
    </admin-layout>
  </div>
</template>

<script>
import  AdminLayout  from '@/Layouts/AdminLayout.vue'
import PointOfSaleTable from "../../Components/PointOfSale/PointOfSaleTable.vue";

export default ({
  data(){
    return {}
    },
    components: {
      AdminLayout,
      PointOfSaleTable
  }
})
</script>
