<template>
    <div>
        <admin-layout>
                  <div class="pagetitle">
          <h1>Categorias</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
              <li class="breadcrumb-item">Pages</li>
              <li class="breadcrumb-item active">Categorias</li>
            </ol>
          </nav>
        </div><!-- End Page Title -->

      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Categorias</h5>
                <div id="people">
                    <category-table></category-table>
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

import  AdminLayout  from '@/Layouts/AdminLayout.vue';
import CategoryTable from '../../Components/Category/CategoryTable.vue'
import  {defineComponent} from 'vue';

export default defineComponent({
    name: "App",
    components: {AdminLayout, CategoryTable },

})
       
</script>