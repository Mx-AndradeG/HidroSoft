<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Actividad reciente | <small class="fs-6"> Hoy</small></h4>
            <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                        <h6>Filtrar por tiempo</h6>
                    </li>
                    <li><a class="dropdown-item" href="#">Hoy</a></li>
                    <li><a class="dropdown-item" href="#">Último mes</a></li>
                    <li><a class="dropdown-item" href="#">Este año</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="activity">
                <div class="activity-item d-flex">
                    <div class="d-flex justify-content-start align-items-center flex-column">
                        <i class='bi bi-circle-fill activity-badge text-danger '
                           style="z-index: 3; height: 0;"></i>
                        <div class="m-0 align-self-middle"
                             style="width: 3px; background-color: #a7bbd854;height: 100%;">
                        </div>
                    </div>
                    <div class="ms-3 me-1 d-flex flex-column">
                        <div class="d-flex justify-content-between">
                            <small class="fw-bold">Eliminación</small>
                            <small class="fw-bold text-muted" style="font-size: 12px;">Hace 32 min.</small>
                        </div>
                        <p style="font-size: 15px">Se ha creado un nuevo producto con los siguentes datos:
                            Nombre: Vitacilina,
                            Precio de compra: $23.00, Precio de venta: $27.00, Descripcion: Crema anti
                            quemaduras o unguento,
                            Categoria: Farmacos, Proveedor: Farmacias Similares.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "UserActivityCard"
}
</script>
