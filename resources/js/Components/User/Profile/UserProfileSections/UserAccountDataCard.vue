<template>
    <article class="card">
        <div class="card-header">
            <h4 class="fw-bolder p-0 m-0">Su actividad dentro del sisitema</h4>
        </div>
        <div class="card-body">
            <form class="row g-3 mt-2 mb-2">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email">
                </div>
                <div class="col-6">
                    <label for="company" class="form-label">Empresa</label>
                    <input type="text" class="form-control" id="company">
                </div>
                <div class="col-6">
                    <label for="branch" class="form-label">Sucursal</label>
                    <input type="text" class="form-control" id="branch">
                </div>
                <div class="col-6">
                    <label for="created_at"  class="form-label">Fecha de registro</label>
                    <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="bi bi-calendar4-week"></i>
                                </span>
                        <input type="text" disabled class="form-control" id="created_at">
                    </div>
                </div>
                <div class="col-6">
                    <label for="updated_at"  class="form-label">Fecha de actualización</label>
                    <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">
                                    <i class="bi bi-calendar4-week"></i>
                                </span>
                        <input type="text" disabled class="form-control" id="updated_at">
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" class="float-end w-25 rounded-5 btn btn-primary opacity-75">
                <span style="margin-left: 3px">Guardar </span>
            </button>
        </div>
    </article>
</template>

<script>
export default {
    name: "UserAccountDataCard"
}
</script>

<style scoped>

</style>
