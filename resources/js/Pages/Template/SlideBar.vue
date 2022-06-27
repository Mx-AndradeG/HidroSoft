<template>
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-heading">Dashboard</li>
      <!-- Start Dashboard Nav -->
      <li class="nav-item">
        <a :class="currentURL == '/dashboard' ? 'nav-link' : 'nav-link collapsed'" :href="route('Dashboard')">
          <i class="bi bi-bar-chart-line"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <!-- End Dashboard Nav -->
      <li class="nav-heading">Sucursales</li>

      <!-- Start Categories Nav -->
      <li class="nav-item">
        <a :class="currentURL == '/branch' ? 'nav-link' : 'nav-link collapsed'" :href="route('Branch')">
          <i class="bi bi-grid"></i>
          <span>Sucursales</span>
        </a>
      </li>
      <!-- End Categories Nav -->

          <!-- Start Categories Nav -->
      <li class="nav-item">
        <a :class="currentURL == '/storage' ? 'nav-link' : 'nav-link collapsed'" :href="route('Storage')">
          <i class="bi bi-truck"></i>
          <span>Almacenes</span>
        </a>
      </li>
      <!-- End Categories Nav -->
                <!-- Start Categories Nav -->
      <li class="nav-item">
        <a :class="currentURL == '/inventory' ? 'nav-link' : 'nav-link collapsed'" :href="route('Inventory')">
          <i class="bi bi-arrow-down-square"></i>
          <span>Inventarios</span>
        </a>
      </li>
      <!-- End Categories Nav -->

      <!-- End Dashboard Nav -->
      <li class="nav-heading">Catálogos</li>

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

      <!-- End Dashboard Nav -->
        <li class="nav-heading">Administración</li>
        
        <li class="nav-item">
        <a :class="currentURL == '/user' ? 'nav-link' : 'nav-link collapsed'" :href="route('User')">
          <i class="bi bi-people"></i>
          <span>Usuarios</span>
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
