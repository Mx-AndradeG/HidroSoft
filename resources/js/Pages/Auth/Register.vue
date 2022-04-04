<template>
<body class="">
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg'); background-position: top;">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Bienvenido!</h1>
            <p class="text-lead text-white">Use these awesome forms to login or create new account in your project for free.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-header text-center pt-4">
              <h5>Registrate</h5>
            </div>
            <div class="card-body">
              <alv-form role="form" :action="alvRoute" :method="alvMethod" :data-object="item">
                <div class="mb-3">
                  <input type="text" class="form-control" placeholder="Nombre" v-model="item.name" aria-label="Nombre">
                </div>
                <div class="mb-3">
                  <input type="email" class="form-control" placeholder="Email" v-model="item.email" aria-label="Email">
                </div>
                <div class="mb-3">
                  <input type="password" class="form-control" placeholder="Contraseña" v-model="item.password" aria-label="Contraseña">
                </div>
                <div class="form-check form-check-info text-start">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" v-model="terms" >
                  <label class="form-check-label" for="flexCheckDefault">
                    I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                  </label>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2" :disabled="!terms" >Sign up</button>
                </div>
                <p class="text-sm mt-3 mb-0">Already have an account? <a :href="route('login')" class="text-dark font-weight-bolder">Sign in</a></p>
              </alv-form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
</template>

<script setup>
import {ref} from "vue";

const item = ref({  
    name: '',
    email:'',
    password:''
});
const terms = ref(false);
const alvRoute = ref('register');
const alvMethod = ref('POST');

</script>
