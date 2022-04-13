<template>
<body class="">
  <main class="bd-wizard-wrapper">
    <div class="card bd-wizard-card">
      <div id="wizard" class="card-body wizard clearfix vertical" role="application">
        <div class="steps clearfix">
          <ul role="tablist">
            <li role="tab" :class="tab == 1 ? 'current' : 'disable'" > 
              <a @click="changeTab(1)" aria-controls="wizard-p-0" style="cursor:pointer">
              <div class="bd-step-title-wrapper">
                <div class="bd-wizard-step-icon">
                  <i class="ri-account-box-line"></i>
                </div>
                <h6 class="bd-wizard-step-title">Datos personales</h6>
                <p class="bd-wizard-step-subtitle">Lorem ipsum dolor.</p>
              </div>
            </a>
            </li>
            <li role="tab" :class="tab == 2 ? 'current' : 'disable'">
              <a @click="changeTab(2)"  aria-controls="wizard-p-1" style="cursor:pointer">
              <div class="bd-step-title-wrapper">
                <div class="bd-wizard-step-icon">
                  <i class="ri-building-4-line"></i>
                </div>
                <h6 class="bd-wizard-step-title">Crear empresa</h6>
                <p class="bd-wizard-step-subtitle">Lorem ipsum dolor.</p>
              </div>
            </a>
            </li>
            <li role="tab" :class="tab == 3 ? 'current' : 'disable'" aria-disabled="false" aria-selected="true">
              <a @click="changeTab(3)" aria-controls="wizard-p-2" style="cursor:pointer">
                  <div class="bd-step-title-wrapper">
                    <div class="bd-wizard-step-icon">
                      <i class="ri-bank-card-2-line"></i>
                    </div>
                    <h6 class="bd-wizard-step-title">Plan</h6>
                    <p class="bd-wizard-step-subtitle">Lorem ipsum dolor.</p>
                  </div>
              </a>
            </li>
            <li role="tab" :class="tab == 4 ? 'current' : 'disable'">
              <a @click="changeTab(4)" aria-controls="wizard-p-3" style="cursor:pointer">
                <div class="bd-step-title-wrapper">
                  <div class="bd-wizard-step-icon">
                    <i class="ri-send-plane-2-line"></i>
                  </div>
                  <h6 class="bd-wizard-step-title">Registrarse</h6>
                  <p class="bd-wizard-step-subtitle">Lorem ipsum dolor.</p>
                </div>
              </a>
              </li>
          </ul>
        </div>
        <div v-if="tab == 1" class="content clearfix" >
          <section class="body current" >
            <h4 class="section-heading">Ingresa tus datos personales.</h4>
            <div class="form-group">
                <label for="text" class="sr-only">Nombre</label>
                <input type="text" v-model="item.user.name" name="text" id="text" class="form-control" placeholder="Juan perez">
              </div>
              <div class="form-group">
                <label for="text" class="sr-only">Correo</label>
                <input type="email" v-model="item.user.email" name="email" id="text" class="form-control" placeholder="correo@gmail.com">
              </div>
              <div class="form-group">
                  <label for="password" class="sr-only">Contraseña</label>
                  <input type="password" v-model="item.user.password" name="password" id="password" class="form-control">
                </div>
              <div>
              </div>
            </section>
          </div>
          <div v-if="tab == 2"  class="content clearfix" >
          <section class="body current" >
            <h4 class="section-heading">Datos de tu empresa</h4>
            <div class="form-group">
                <label for="company_name" class="sr-only">Nombre de la empresa</label>
                <input type="text" v-model="item.company.name" name="company_name" id="company_name" class="form-control" placeholder="Tienda don jose.">
              </div>
              <div class="form-group">
                <label for="phone" class="sr-only">Telefono</label>
                <input type="text" v-model="item.company.phone" name="phone" id="phone" class="form-control" placeholder="449-123-45-67">
              </div>
              <div class="form-group">
                  <label for="email" class="sr-only">Correo</label>
                  <input type="text"  v-model="item.company.email" name="email" id="email" class="form-control" placeholder="TiendaJose@correo.com">
                </div>
              <div>
              </div>
            </section>
          </div>

        <div v-if="tab == 3"  class="content clearfix" >
          <section class="body current" >
            <h4 class="section-heading">Selecciona tu plan</h4>
           <div class="purpose-radios-wrapper">
              <div class="purpose-radio">
                <input type="radio" name="purpose" id="branding" class="purpose-radio-input" value="Branding" checked="">
                <label for="branding" class="purpose-radio-label">
                  <span class="label-icon">
                    <img alt="branding" class="label-icon-default">
                    <img alt="branding" class="label-icon-active">
                  </span>
                  <span class="label-text">Mensual</span>
                </label>
              </div>
              <div class="purpose-radio">
                <input type="radio" name="purpose" id="mobile-design" class="purpose-radio-input" value="Moile Design">
                <label for="mobile-design" class="purpose-radio-label">
                  <span class="label-icon">
                    <img alt="branding" class="label-icon-default">
                    <img alt="branding" class="label-icon-active">
                  </span>
                  <span class="label-text">Personalizado</span>
                </label>
              </div>
              <div class="purpose-radio">
                <input type="radio" name="purpose" id="web-design" class="purpose-radio-input" value="Web Design">
                <label for="web-design" class="purpose-radio-label">
                  <span class="label-icon">
                    <img alt="branding" class="label-icon-default">
                    <img alt="branding" class="label-icon-active">
                  </span>
                  <span class="label-text">Anual</span>
                </label>
              </div>
            </div>
              <div>
              </div>
            </section>
          </div>

        <div v-if="tab == 4"  class="content clearfix" >
          <section id="wizard-p-3" role="tabpanel" aria-labelledby="wizard-h-3" class="body current" aria-hidden="false" style="">
              <h4 class="section-heading">Acepto terminos y condiciones.</h4>
              <div class="form-check mt-4">
                <label class="form-check-label">
                  <input v-model="terms" type="checkbox" class="form-check-input" name="termsAgreement" id="termsAgreement" value="termsAgreed">
                  Estoy de acuerdo con los terminos de condiciones.
                </label>
              </div>
            </section>
          </div>


          <div class="actions clearfix">
            <ul role="menu" aria-label="Pagination">
              <li class="" aria-disabled="false" v-if="tab != 1" @click="changeTab((tab-1))">
                <a role="menuitem">Anterior</a>
              </li>
              <li aria-hidden="false" v-if="tab != 4" aria-disabled="false" class="" style="display: list-item;" @click="changeTab((tab+1))">
                <a role="menuitem">Siguiente</a>
              </li>
              <li aria-hidden="true" v-if="tab == 4 && terms">
                <a @click="submit" role="menuitem">Terminar</a>
              </li>
            </ul>
          </div>

          </div>
    </div>
  </main>
</body>
</template>

<script>
  import { useToast } from "vue-toastification";
  const toast = useToast()

    export default {
        components: {
        },

        data() {
            return {
                item: this.$inertia.form({
                   user:{
                     name: '',
                     email: '',
                     password: ''
                   },
                   company:{
                     name:'',
                     phone:'',
                     emial:''
                   }
                }),
                tab:1,
                terms: false,
            }
        },

        methods: {
          changeTab(numberTab){
            if(this.tab < numberTab){
              switch(this.tab){
                case 1:
                  if(this.validateProfileForm()){
                      this.tab = numberTab;
                  }
                break;
                case 2:
                  if(this.validateCompanyForm()){
                    this.tab = numberTab;
                  }
                break;
                default:
                  this.tab = numberTab;
              } 
            }else{
              this.tab = numberTab;
            }


          },
          validateProfileForm(){
            if(this.item.user.name != '' && this.item.user.email != '' && this.item.user.password != ''){
                return true
            }else{
              this.showToast('Completa tu información personal porfavor.');
              return false
            }
          },
          validateCompanyForm(){
            if(this.item.company.name != '' && this.item.company.email != '' && this.item.company.phone != ''){
                return true
            }else{
              this.showToast("Completa la información de tu empresa.");
              return false
            }
          },
          showToast(message){
              toast.warning(message ,{
                position: "top-right",
                closeOnClick: true,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: false,
                hideProgressBar: false,
                closeButton: "button",
                icon: true,
                rtl: false
            });
          },
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
<style scoped>
body {
  font-family: 'Karla', sans-serif;
  background-color: #ffffff00; }

.bd-wizard-wrapper {
  padding-top: 10% !important;
  width: calc(100% - 320px);
  margin-left: 320px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px; }
  @media (max-width: 991px) {
    .bd-wizard-wrapper {
      width: calc(100% - 230px);
      margin-left: 230px; } }
  @media (max-width: 767px) {
    .bd-wizard-wrapper {
      width: 100%;
      margin-left: 0;
      margin-top: 70px; } }

.bd-wizard-card {
  max-width: 725px;
  width: 100%;
  border-radius: 10px;
  border: 0; }
  .bd-wizard-card .card-body {
    padding: 75px 85px; }
    @media (max-width: 991px) {
      .bd-wizard-card .card-body {
        padding-left: 26px;
        padding-right: 26px; } }
    @media (max-width: 767px) {
      .bd-wizard-card .card-body {
        padding: 24px; } }

/* Wizard */
.wizard {
  padding: 20px; }
  .wizard .audible {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0; }
  .wizard .steps {
    position: fixed;
    width: 320px;
    left: 0;
    top: 0;
    bottom: 0;
    overflow-y: auto;
    background-color: #001778;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: center; }
    @media (max-width: 991px) {
      .wizard .steps {
        width: 230px; } }
    @media (max-width: 767px) {
      .wizard .steps {
        position: absolute;
        top: auto;
        left: 0;
        right: 0;
        bottom: calc(100% + 15px);
        width: 100%;
        justify-content: stretch;
        padding: 10px 0;
        border-radius: 10px; } }
    .wizard .steps > ul {
      list-style: none;
      padding-left: 0;
      display: flex;
      justify-content: space-around;
      margin-bottom: 0;
      flex-direction: column; }
      @media (max-width: 767px) {
        .wizard .steps > ul {
          flex-direction: row;
          width: 100%; } }
      @media (max-width: 767px) {
        .wizard .steps > ul li {
          width: 25%; } }
      .wizard .steps > ul li a {
        display: block;
        padding: 25px 0; }
        @media (max-width: 767px) {
          .wizard .steps > ul li a {
            padding: 0;
            text-align: center; } }
        .wizard .steps > ul li a:hover {
          text-decoration: none; }
      .wizard .steps > ul li .bd-step-title-wrapper {
        color: #fff; }
      .wizard .steps > ul li .bd-wizard-step-icon {
        font-size: 35px;
        height: 35px;
        width: 35px;
        line-height: 35px;
        margin-bottom: 13px;
        opacity: 0.5; }
        @media (max-width: 767px) {
          .wizard .steps > ul li .bd-wizard-step-icon {
            margin: 0 auto;
            font-size: 25px; } }
      .wizard .steps > ul li .bd-wizard-step-title {
        font-size: 18px;
        opacity: 0.5;
        font-weight: bold;
        line-height: 22px;
        margin-bottom: 4px; }
        @media (max-width: 767px) {
          .wizard .steps > ul li .bd-wizard-step-title {
            display: none; } }
      .wizard .steps > ul li .bd-wizard-step-subtitle {
        font-size: 15px;
        line-height: 18px;
        color: #1c3bbc;
        margin-bottom: 0; }
        @media (max-width: 767px) {
          .wizard .steps > ul li .bd-wizard-step-subtitle {
            display: none; } }
      .wizard .steps > ul li.current .bd-wizard-step-icon, .wizard .steps > ul li.done .bd-wizard-step-icon {
        opacity: 1; }
      .wizard .steps > ul li.current .bd-wizard-step-title, .wizard .steps > ul li.done .bd-wizard-step-title {
        opacity: 1; }
  .wizard .content {
    margin-bottom: 30px; }
    .wizard .content .logo {
      height: 21px;
      margin-bottom: 16px; }
    .wizard .content .title {
      display: none; }
    .wizard .content .section-heading {
      font-weight: bold;
      color: #030303;
      margin-bottom: 15px; }
      .wizard .content .section-heading + p {
        margin-bottom: 52px; }
    .wizard .content p {
      font-size: 15px;
      line-height: 1.6;
      color: #000000;
      opacity: 0.44; }
    .wizard .content label {
      font-size: 15px;
      color: #919aa3;
      font-weight: normal;
      margin-bottom: 4px; }
    .wizard .content .form-group {
      margin-bottom: 30px; }
    .wizard .content .form-control {
      padding: 16px 29px;
      min-height: 50px;
      border-radius: 4px;
      border: solid 1px #ececec; }
      .wizard .content .form-control::-webkit-input-placeholder {
        color: #919aa3; }
      .wizard .content .form-control::-moz-placeholder {
        color: #919aa3; }
      .wizard .content .form-control:-ms-input-placeholder {
        color: #919aa3; }
      .wizard .content .form-control::-ms-input-placeholder {
        color: #919aa3; }
      .wizard .content .form-control::placeholder {
        color: #919aa3; }
    .wizard .content .purpose-radio {
      position: relative;
      display: inline-block; }
      .wizard .content .purpose-radio .purpose-radio-input {
        position: absolute;
        opacity: 0; }
        .wizard .content .purpose-radio .purpose-radio-input:checked + .purpose-radio-label {
          border-color: #fea500; }
          .wizard .content .purpose-radio .purpose-radio-input:checked + .purpose-radio-label .label-icon {
            color: #fea500; }
            .wizard .content .purpose-radio .purpose-radio-input:checked + .purpose-radio-label .label-icon .label-icon-default {
              display: none; }
            .wizard .content .purpose-radio .purpose-radio-input:checked + .purpose-radio-label .label-icon .label-icon-active {
              display: inline-block; }
          .wizard .content .purpose-radio .purpose-radio-input:checked + .purpose-radio-label .label-text {
            color: #fea500;
            font-weight: bold; }
      .wizard .content .purpose-radio .purpose-radio-label {
        display: flex;
        width: 165px;
        height: 150px;
        max-width: 100%;
        border: 2px solid #7b7f89;
        border-radius: 4px;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease-in-out;
        cursor: pointer; }
        @media (max-width: 575px) {
          .wizard .content .purpose-radio .purpose-radio-label {
            width: 100%; } }
        .wizard .content .purpose-radio .purpose-radio-label .label-icon {
          font-size: 21px;
          color: #000000;
          margin-bottom: 17px;
          transition: all 0.2s ease-in-out; }
          .wizard .content .purpose-radio .purpose-radio-label .label-icon .label-icon-active {
            display: none; }
        .wizard .content .purpose-radio .purpose-radio-label .label-text {
          font-size: 16px;
          color: #030303;
          transition: all 0.2s ease-in-out; }
    .wizard .content .purpose-radios-wrapper {
      margin-top: 60px; }
      .wizard .content .purpose-radios-wrapper .purpose-radio {
        margin-right: 18px;
        max-width: calc(33% - 18px); }
        @media (max-width: 575px) {
          .wizard .content .purpose-radios-wrapper .purpose-radio {
            margin-right: 0;
            margin-bottom: 18px;
            width: 100%;
            max-width: none; } }
        .wizard .content .purpose-radios-wrapper .purpose-radio:last-child {
          margin-right: 0; }
  .wizard .actions > ul {
    list-style: none;
    padding-left: 0;
    display: flex;
    margin-bottom: 0; }
  .wizard .actions li {
    margin-left: 12px; }
    .wizard .actions li:first-child, .wizard .actions li:first-child.disabled + li {
      margin-left: 0; }
    .wizard .actions li a {
      display: inline-block;
      border-radius: 6px;
      background-color: #fea500;
      padding: 16px 30px;
      font-size: 15px;
      font-weight: bold;
      color: #000000; }
      .wizard .actions li a:hover {
        text-decoration: none; }
    .wizard .actions li.disabled {
      display: none; }

</style>
