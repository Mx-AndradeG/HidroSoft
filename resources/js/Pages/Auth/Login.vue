<template>
<body class="">
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Iniciar Sesion</h4>
                  <p class="mb-0">Ingresa tu email y contraseña para iniciar sesion</p>
                </div>
                <div class="card-body">
                  <form @submit.prevent="submit">
                    <div class="mb-3">
                      <input  type="email" name="email" v-model="item.email" class="form-control form-control-lg" placeholder="Email" aria-label="Email">
                    </div>
                    <div class="mb-3">
                      <input type="password" name="password" v-model="item.password" class="form-control form-control-lg" placeholder="Contraseña" aria-label="Password">
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe">
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Iniciar sesion</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    No tienes cuenta?
                    <a :href="route('register')" class="text-primary text-gradient font-weight-bold">Registrate</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');
                background-size: cover;">
                <span class="mask bg-gradient-primary opacity-6"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative">"La atención nos define"</h4>
                <p class="text-white position-relative">En HidroSoft nos precupa ayudarte en tu camino hacia el exito.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>
</template>

<script>

export default {
    components: {
    },

    data() {
        return {
            item: this.$inertia.form({
                email: '',
                password: '',
                remember: false
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
                .post(this.route('login'), {
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
