<template>
    <body class="">
    <navbar></navbar>
    <slide-bar></slide-bar>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Blank Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active">Blank</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Example Card</h5>
                            <p>This is an examle page with no contrnt. You can use it as a starter for your custom
                                pages.</p>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Example Modal</h5>
                            <p>This is an example of modal functionality. Press the button below and try it:</p>
                            <button class="btn btn-primary w-50" @click="$vfm.show('example_modal')">Open Modal
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </section>
      <slot></slot>
    </main><!-- End #main -->
    <example-modal></example-modal>
    </body>
</template>

<script>
import SlideBar from '@/Pages/Template/SlideBar'
import Navbar from '@/Pages/Template/Header'
import ExampleModal from "./ExampleModal";

export default ({
    data() {
        return {}
    },
    components: {
        SlideBar,
        Navbar,
        ExampleModal
    }
})
</script>
