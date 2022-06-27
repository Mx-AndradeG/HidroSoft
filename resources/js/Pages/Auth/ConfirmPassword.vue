<template>
<body class="">
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">HidroSoft</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Inicia sesion con tu cuenta</h5>
                    <p class="text-center small">Confirma tu contraseña</p>
                  </div>

                    <alv-form :action="alvRoute" :method="alvMethod" :data-object="item" @after-done="afterDone" >
                      <div class="col-12">
                        <label for="password" class="form-label">Contraseña</label>
                          <input v-model="item.password" type="password" name="password" class="form-control" id="password" required>
                        <div class="invalid-feedback">Porfavor ingresa tu contraseña!</div>
                      </div>

                      <div class="col-12">
                        <label for="password" class="form-label">Confirmar contraseña</label>
                          <input v-model="item.password_confirmation" type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                        <div class="invalid-feedback">Porfavor ingresa tu contraseña!</div>
                      </div>

                      <div class="col-12 pt-3">
                        <button class="btn btn-primary w-100" type="submit">Iniciar sesion</button>
                      </div>
                    </alv-form>
                </div>
              </div>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->
</body>
</template>

<script>

export default {
    components: {
    },
    data() {
        return {
            item:{
              user_id: null,
              password_confirmation: null,
              password: null,
            },
              alvRoute: route("user.validation"),
              alvMethod: "POST",
        }
    },

    methods: {
            afterDone(){
                window.location.reload();
            }
    },
    created() {
      this.item.user_id =  window.location.pathname.split('/')[2]
    }
}
</script>
