<template>
    <main class="row justify-content-around h-100">
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
                    <div class="d-flex m-2 align-items-center flex-column justify-content-center">
                        <i style="font-size: 40px" class="bi bi-person-bounding-box"></i>
                        <small>Datos</small>
                    </div>
                    <div class=" m-2 d-flex flex-column align-items-center justify-content-center">
                        <i style="font-size: 40px" class="bi bi-activity"></i>
                        <small>Actividad</small>
                    </div>
                </div>
                <div class="d-flex w-75 flex-row justify-content-around">
                    <div class="d-flex m-2 align-items-center flex-column justify-content-center">
                        <i style="font-size: 40px" class="bi bi-shield"></i>
                        <small>Seguridad</small>
                    </div>
                    <div class=" m-2 d-flex flex-column align-items-center justify-content-center">
                        <i style="font-size: 40px" class="bi bi-palette2"></i>
                        <small>Apariencia</small>
                    </div>
                </div>

            </article>
        </section>
        <section class="col-8">
            <article class="card">

            </article>
        </section>
    </main>
</template>

<script>
export default {
    name: "UserProfile"
}
</script>
