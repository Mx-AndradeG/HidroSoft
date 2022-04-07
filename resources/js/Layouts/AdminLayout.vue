<template>
<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <slide-bar></slide-bar>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
   <navbar></navbar>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-12 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
           <slot></slot>
          </div>
        </div>
      </div>
    </div>
  </main>
  </body>
</template>

<script>
import  SlideBar  from '@/Pages/Template/SlideBar'
import  Navbar  from '@/Pages/Template/Header'

export default ({
  data(){
    return {}
    },
    components: {
      SlideBar,
      Navbar
  }
})
</script>
