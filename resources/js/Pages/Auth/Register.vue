<template>
<body class="">
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">NiceAdmin</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Crear cuenta</h5>
                    <p class="text-center small">Porfavor ingresa los siguientes datos</p>
                  </div>

                  <form @submit.prevent="submit" class="row g-3 needs-validation" novalidate>
                    <div class="col-12">
                      <label for="yourName" class="form-label">Nombre</label>
                      <input v-model="item.name" type="text" name="name" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Porfavor ingresa tu nombre.</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Correo</label>
                      <input v-model="item.email" type="email" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Porfavor ingresa tu correo!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Contraseña</label>
                      <input v-model="item.password" type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Porfavor ingresa tu contraseña!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                        <label class="form-check-label" for="acceptTerms">Estoy de acuerdo con los <a href="#">terminos y condiciones</a></label>
                        <div class="invalid-feedback">Debes de estar de acuerdo antes de registrarte.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Crear cuenta</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Ya tienes una cuenta  <a :href="route('login')">Log in</a></p>
                    </div>
                  </form>

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
                item: this.$inertia.form({
                    name: '',
                    email: '',
                    password: '',
                })
            }
        },

        methods: {
          submit() {
            this.item
                .transform(data => ({
                    ...data,
                    remember: this.item.remember ? 'on' : ''
                }))
                .post(this.route('register'), {
                    onError: (errors) => {
                        if (Object.values(errors)[0])
                            this.$toast.open({duration: 2000, message: Object.values(errors)[0], type: "error"});
                        else
                            this.$toast.open({
                                duration: 2000,
                                message: "Estas credenciales no coinciden con nuestros registros.",
                                type: "error"
                            });
                        this.item.reset('password');
                    },
                })
        }
        }
    }
</script>
