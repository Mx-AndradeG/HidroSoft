<template>
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <!-- Start Dashboard Nav -->
      <li class="nav-item">
        <a :class="currentURL == '/dashboard' ? 'nav-link' : 'nav-link collapsed'" :href="route('Dashboard')">
          <i class="bi bi-bar-chart-line"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <!-- End Dashboard Nav -->

      <!-- Start Categories Nav -->
      <li class="nav-item">
        <a :class="currentURL == '/categories' ? 'nav-link' : 'nav-link collapsed'" :href="route('Category')">
          <i class="bi bi-grid"></i>
          <span>Categorias</span>
        </a>
      </li>
      <!-- End Categories Nav -->

      <!-- Start Clients Nav -->
      <li class="nav-item">
        <a :class="currentURL == '/customers' ? 'nav-link' : 'nav-link collapsed'" :href="route('Customer')">
          <i class="bi bi-person"></i>
          <span>Clientes</span>
        </a>
      </li>
      <!-- End Cliente Nav -->

      <!-- Start Suppliers Nav -->
      <li class="nav-item">
        <a :class="currentURL == '/suppliers' ? 'nav-link' : 'nav-link collapsed'" :href="route('Supplier')">
          <i class="bi bi-person"></i>
          <span>Proveedores</span>
        </a>
      </li>
      <!-- End Suppliers Nav -->
            <!-- Start Suppliers Nav -->
      <li class="nav-item">
        <a :class="currentURL == '/products' ? 'nav-link' : 'nav-link collapsed'" :href="route('Product')">
          <i class="bi bi-box-seam"></i>
          <span>Productos</span>
        </a>
      </li>
      <!-- End Suppliers Nav -->
    </ul>
  </aside>
  <!-- End Sidebar-->
</template>

<script>
export default {
  data() {
    return {
      showingNavigationDropdown: false,
      currentURL: ''
    };
  },

  methods: {
    logout() {
      this.$inertia.post(route("logout"));
    },
  },
  created() {
      this.currentURL = window.location.pathname;
    },
};
</script>
