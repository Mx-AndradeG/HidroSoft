<template>
    <body class="">
    <navbar></navbar>
    <slide-bar></slide-bar>
    <main id="main" class="main">
      <slot></slot>
    </main><!-- End #main -->
    </body>
</template>

<script>
import SlideBar from '@/Pages/Template/SlideBar'
import Navbar from '@/Pages/Template/Header'

export default ({
    data() {
        return {}
    },
    components: {
        SlideBar,
        Navbar,
    }
})
</script>
