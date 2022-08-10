<template>
    <div>
        <vue-final-modal v-model="modal_button.show" name="example_modal" lock-scroll="false" content-style="border-radius:25px"
                         classes="modal-container w-100 modal-dialog modal-xl" body-scroll-lock="false"  content-class="modal-content ">

            <button style="border-top-right-radius: 20px;" class="modal__close btn btn-light" @click="modal_button.show = false">
                <i class="ri-close-fill ri-lg" style="color: #4a5568"></i>
            </button>
            <!-- Section Modal Title -->
            <div class="row mt-1 text-center">
                <h3 class="col-12" style="font-weight: bold;">Crear categoria</h3>
            </div>
            <!-- END Section Modal Title -->
            <hr>
            <!-- Section Modal Content -->
            <div class="row mt-2 mb-2" style="margin: 0 5px 0 5px">
                <div class="col-12">
                    <!-- Put your code below -->
                    <form class="row g-3">
                        <div class="col-md-12"><label for="inputName5" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="inputName5">
                        </div>

                        <div class="col-md-6"><label for="inputEmail5" class="form-label">Descripcion</label> 
                            <input type="text" class="form-control" id="inputEmail5">
                        </div>

                    </form>
                    <!-- END Put your code below -->
                </div>
            </div>
            <!-- END Section Modal Content -->
            <hr>
            <!-- Section Modal Footer -->
            <div class="row justify-content-end" id="modal-footer">
                <div class="col-3">
                    <button class="w-100 btn btn-light d-flex justify-content-center">
                        <i class="ri-download-2-line"></i>
                        <span style="margin-left: 3px">Guardar</span>
                    </button>
                </div>
            </div>
            <!-- END Section Modal Footer -->
        </vue-final-modal>
    </div>
</template>

<script>

export default {
    name: "ExampleModal",
    data() {
        return {
            modal_button: {
                show: false
            }
        }
    }
}
</script>

