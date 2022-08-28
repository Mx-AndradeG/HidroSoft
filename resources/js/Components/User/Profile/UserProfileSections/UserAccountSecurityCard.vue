<template>
    <div class="card">
        <div class="card-header">
            <h4>Seguridad de la cuenta</h4>
        </div>
        <div class="card-body">
            <h5 class="mt-3">Cambiar contraseña</h5>
            <div class="accordion" id="accordionChangePassword">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPasswordTraits">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="bi bi-exclamation-octagon-fill me-2"></i>
                            Consideraciones para la nueva contraseña
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse "
                         aria-labelledby="headingPasswordTraits"
                         data-bs-parent="#accordionChangePassword">
                        <div class="accordion-body">
                            Para crear una contraseña segura, se recomienda que contenga al menos:
                            <ul>
                                <li>8 caracteres</li>
                                <li>Una letra mayuscula y minúscula <small>([A-Z] [a-z])</small></li>
                                <li>Un número <small>(0-9)</small></li>
                                <li>Un símbolo <small>(@#$%&*!)</small></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2 mb-2">
                <div class="form-group col-12 mt-2">
                    <label for="current_password">Contraseña actual
                        <small class="text-danger">*</small>
                    </label>
                    <input v-model="user_password_data.current_password" class="form-control" type="password"
                           id="current_password" name="current_password"/>
                </div>
                <div class="form-group col-6 mt-2">
                    <label for="password">Nueva contraseña
                        <small class="text-danger">*</small>
                    </label>
                    <input v-model="user_password_data.password" class="form-control" type="password" id="password"
                           name="password"/>
                </div>
                <div class="form-group col-6 mt-2">
                    <label for="password_confirmation">Confirmar nueva contraseña
                        <small class="text-danger">*</small>
                    </label>
                    <input v-model="user_password_data.password_confirmation" class="form-control" type="password"
                           id="password_confirmation" name="password_confirmation"/>
                </div>

            </div>
        </div>
        <div class="card-footer">
            <button @click="confirmChangePassw" type="submit" class="float-end w-25 rounded-5 btn btn-primary opacity-75">
                <span style="margin-left: 3px">Cambiar </span>
            </button>
        </div>
        <overlay-loader v-if="loader" :title="'¡Exito!'" :message="'Cerrando sesión...'"></overlay-loader>
    </div>

</template>

<script>
import {useToast} from "vue-toastification";
import OverlayLoader from "../../../Extras/OverlayLoader";
import Swal from "sweetalert2";

const toast = useToast();

export default {
    name: "UserAccountSecurityCard",
    components: {OverlayLoader},
    data() {
        return {
            loader: false,
            user_password_data: {
                current_password: '',
                password: '',
                password_confirmation: ''
            }
        }
    },
    methods: {
        confirmChangePassw() {
            Swal.fire({
                title: "Cambiar contraseña de la cuenta",
                text: "¿Esta seguro que desea cambiar su contraseña? \n Tenga cuidado, se cerrará la sesión una vez completado el proceso.",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "No, déjalo",
                confirmButtonText: "Si, vamos",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.changePassw()
                }
            });
        },
        changePassw() {
            axios.post(this.route('user.account.passwd'), this.user_password_data)
                .then(() => {
                    this.loader = true;
                    setTimeout(() => {
                        this.$inertia.post(route("user.logout"))
                    }, 2000);
                }).catch((error) => {
                let message = typeof error.response.data.errors !== 'undefined'
                    ? Object.values(error.response.data.errors)[0][0]
                    : 'Hubo un error al cambiar su contraseña, contacte a soporte.'

                toast.error(message, {
                    position: "top-center", closeOnClick: true, pauseOnFocusLoss: true,
                    pauseOnHover: true, draggable: true, draggablePercent: 0.6, showCloseButtonOnHover: false,
                    hideProgressBar: true, closeButton: "button", icon: true, rtl: false,
                });
            });
        }
    },
}
</script>
