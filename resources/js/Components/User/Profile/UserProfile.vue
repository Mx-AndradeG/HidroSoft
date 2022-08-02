<template>
    <main class="row justify-content-around align-items-center h-100">
        <section class="col-3">
            <article class="card rounded-3 d-flex flex-column justify-content-center align-items-center">
                <div style="width: 180px; height: 180px" class="mt-3 mb-3">
                    <img style="object-fit: contain; width: inherit;" :src="$asset('images/profile-default-image.png')">
                </div>

                <h3>K. Anderson</h3>

                <h6 class="text-muted ">ADMINISTRADOR</h6>

                <div class="d-flex flex-row align-items-center justify-content-center w-75 mt-3 mb-2">
                    <hr class=" w-100 opacity-25">
                    <small style="font-size: 11px" class="m-2 fw-bolder text-muted opacity-75">NAVEGAR</small>
                    <hr class="w-100 opacity-25">
                </div>
                <div class="d-flex w-75 flex-row justify-content-around">
                    <div
                        class="d-flex m-2 align-items-center flex-column justify-content-center card shadow-sm rounded-5 w-100 p-2">
                        <i style="font-size: 40px; color: #75a2ca;" class="bi bi-person-bounding-box"></i>
                        <small>Datos</small>
                    </div>
                    <div
                        class=" m-2 d-flex flex-column align-items-center justify-content-center card shadow-sm rounded-5 w-100 p-2">
                        <i style="font-size: 40px; color: #75a2ca;" class="bi bi-activity"></i>
                        <small>Actividad</small>
                    </div>
                </div>
                <div class="d-flex w-75 flex-row justify-content-around">
                    <div
                        class="d-flex m-2 align-items-center flex-column justify-content-center card shadow-sm rounded-5 w-100 p-2">
                        <i style="font-size: 40px; color: #75a2ca;" class="bi bi-shield"></i>
                        <small>Seguridad</small>
                    </div>
                    <div
                        class=" m-2 d-flex flex-column align-items-center justify-content-center card shadow-sm rounded-5 w-100 p-2">
                        <i style="font-size: 40px; color: #75a2ca;" class="bi bi-palette2"></i>
                        <small>Apariencia</small>
                    </div>
                </div>

            </article>
        </section>
        <section class="col-8">
            <!--            <user-account-data-card></user-account-data-card>-->
            <!-- Recent Activity -->
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="fw-bolder">Actividad reciente | <small class="fs-6"> Hoy</small></h4>
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
            </div><!-- End Recent Activity -->
        </section>
    </main>
</template>

<script>
import UserAccountDataCard from "./UserProfileSections/UserAccountDataCard";

export default {
    name: "UserProfile",
    components: {UserAccountDataCard}
}
</script>
