<template>
    <div>
        <vue-final-modal v-model="modal_button.show" name="example_modal" lock-scroll="false" content-style="border-radius:25px"
                         classes="modal-container w-50 modal-dialog modal-xl" body-scroll-lock="false"  content-class="modal-content ">

            <button style="border-top-right-radius: 20px;" class="modal__close btn btn-light" @click="modal_button.show = false">
                <i class="ri-close-fill ri-lg" style="color: #4a5568"></i>
            </button>

            <!-- Section Modal Title -->
            <div class="row mt-1 text-center">
                <h3 class="col-12" style="font-weight: bold;">Crear producto</h3>
            </div>
            <!-- END Section Modal Title -->

            <hr>

            <!-- Section Modal Content -->
            <div class="row mt-2 mb-2" style="margin: 0 5px 0 5px">
                <div class="col-12">
                    <!-- Put your code below -->

                    <form class="row g-3">
                        <div class="col-md-12"><label for="inputName5" class="form-label">Your Name</label> <input
                            type="text" class="form-control" id="inputName5"></div>
                        <div class="col-md-6"><label for="inputEmail5" class="form-label">Email</label> <input
                            type="email"
                            class="form-control"
                            id="inputEmail5">
                        </div>
                        <div class="col-md-6"><label for="inputPassword5" class="form-label">Password</label> <input
                            type="password" class="form-control" id="inputPassword5"></div>
                        <div class="col-12"><label for="inputAddress5" class="form-label">Address</label> <input
                            type="text"
                            class="form-control"
                            id="inputAddres5s"
                            placeholder="1234 Main St">
                        </div>
                        <div class="col-12"><label for="inputAddress2" class="form-label">Address 2</label> <input
                            type="text" class="form-control" id="inputAddress2"
                            placeholder="Apartment, studio, or floor">
                        </div>
                        <div class="col-md-6"><label for="inputCity" class="form-label">City</label> <input type="text"
                                                                                                            class="form-control"
                                                                                                            id="inputCity">
                        </div>
                        <div class="col-md-4"><label for="inputState" class="form-label">State</label> <select
                            id="inputState" class="form-select">
                            <option selected="">Choose...</option>
                            <option>...</option>
                        </select></div>
                        <div class="col-md-2"><label for="inputZip" class="form-label">Zip</label> <input type="text"
                                                                                                          class="form-control"
                                                                                                          id="inputZip">
                        </div>
                        <div class="col-12">
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="gridCheck">
                                <label
                                    class="form-check-label" for="gridCheck"> Check me out </label></div>
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

<style scoped>

::v-deep .modal-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

::v-deep .modal-content {
    position: relative;
    display: flex;
    flex-direction: column;
    margin: 0 1rem;
    padding: 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.25rem;
    background: #fff;
}

.modal__title {
    margin: 0 2rem 0 0;
    font-size: 1.5rem;
    font-weight: 700;
}

.modal__close {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
}

.dark-mode div::v-deep .modal-content {
    border-color: #2d3748;
    background-color: #1a202c;
}

hr {
    padding: 2px;
    border-radius: 10px;
    color: steelblue;
}
</style>
