<template>
  <body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <slide-bar></slide-bar>
    <main class="main-content position-relative border-radius-lg ps">
      <!-- Navbar -->
      <header></header>
      <!-- End Navbar -->
    </main>
  </body>
</template>

<script>
import { SlideBar } from '@/Pages/Template/SlideBar'
import { Header } from '@/Pages/Template/Header'

export default ({
  data(){
    return {}
    },
    components: {
      SlideBar,
      Header
  }
})
</script>
