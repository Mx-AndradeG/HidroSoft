<template>
    <article class="card">
        <div class="card-header">
            <h4>Datos de la cuenta</h4>
        </div>
        <div class="card-body">
            <form v-if="ready" class="row g-3 mt-2 mb-2">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" v-model="account_data.name" class="form-control" id="name" required>
                </div>
                <div class="col-6">
                    <label class="form-label">Sucursal</label>
                    <v-select :options="branches" v-model="account_data.branch_id" :reduce="e => e.id" label="name"
                              required/>
                </div>
                <div class="col-6">
                    <label for="formatted_created_at" class="form-label">Fecha de registro</label>
                    <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="bi bi-calendar4-week"></i>
                                </span>
                        <input type="text" disabled v-model="account_data.formatted_created_at" class="form-control"
                               id="formatted_created_at">
                    </div>
                </div>
                <div class="col-6">
                    <label for="formatted_updated_at" class="form-label">Fecha de actualización</label>
                    <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">
                                    <i class="bi bi-calendar4-week"></i>
                                </span>
                        <input type="text" disabled class="form-control" v-model="account_data.formatted_updated_at"
                               id="formatted_updated_at">
                    </div>
                </div>
            </form>
            <article v-else class=" d-flex flex-column justify-content-center">
                <span class="loader align-self-center"></span>
                <h5 class=" align-self-center mt-2">Cargando datos de la cuenta...</h5>
            </article>
        </div>
        <div class="card-footer">
            <button @click="updateAccountData" type="submit"
                    class="float-end w-25 rounded-5 btn btn-primary opacity-75">
                <span style="margin-left: 3px">Actualizar </span>
            </button>
        </div>
    </article>
</template>

<script>
import {useToast} from "vue-toastification";

const toast = useToast();

export default {
    name: "UserAccountDataCard",
    data() {
        return {
            account_data: {},
            ready: false,
            branches: []
        }
    },
    created() {
        this.getBranches()
        this.getAccountData();
    },
    methods: {
        getBranches() {
            axios.get(this.route('branch.index', this.auth.id), {
                params: {
                    columns: JSON.stringify([
                        'id',
                        'name',
                    ])
                }
            }).then(response => {
                this.branches = response.data.data;
            })
        },
        getAccountData() {
            axios.get(this.route('user.show', this.auth.id), {
                params: {
                    columns: JSON.stringify([
                        'name',
                        'email',
                        'user_company_name',
                        'branch_id',
                    ])
                }
            }).then(response => {
                this.account_data = response.data;
                this.ready = true;
            }).catch(() => {
                toast.error("Hubo un error al obtener los datos de la cuenta", {
                    position: "top-center",
                    closeOnClick: true,
                    pauseOnFocusLoss: true,
                    pauseOnHover: true,
                    draggable: true,
                    draggablePercent: 0.6,
                    showCloseButtonOnHover: false,
                    hideProgressBar: true,
                    closeButton: "button",
                    icon: true,
                    rtl: false,
                });
            })
        },
        updateAccountData() {
            axios.post(this.route('user.account'), {
                account_data: this.account_data
            }).then(response => {
                toast.success("Datos de la cuenta actualizados", {
                    position: "top-center",
                    closeOnClick: true,
                    pauseOnFocusLoss: true,
                    pauseOnHover: true,
                    draggable: true,
                    draggablePercent: 0.6,
                    showCloseButtonOnHover: false,
                    hideProgressBar: true,
                    closeButton: "button",
                    icon: true,
                    rtl: false,
                });
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }).catch((error) => {
                    let message = typeof error.response.data.errors !== 'undefined'
                        ? Object.values(error.response.data.errors)[0][0]
                        : 'Hubo un error al actualizar sus datos, contacte a soporte.'
                    toast.error(message, {
                        position: "top-center",
                        closeOnClick: true,
                        pauseOnFocusLoss: true,
                        pauseOnHover: true,
                        draggable: true,
                        draggablePercent: 0.6,
                        showCloseButtonOnHover: false,
                        hideProgressBar: true,
                        closeButton: "button",
                        icon: true,
                        rtl: false,
                    });
                }
            );
        }
    }
}
</script>
