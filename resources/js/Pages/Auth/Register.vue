<template>
  <body class="">
    <main class="bd-wizard-wrapper">
      <div class="card bd-wizard-card">
        <div
          id="wizard"
          class="card-body wizard clearfix vertical"
          role="application"
        >
          <div class="steps clearfix">
            <ul role="tablist">
              <li role="tab" :class="tab == 1 ? 'current' : 'disable'">
                <a
                  @click="changeTab(1)"
                  aria-controls="wizard-p-0"
                  style="cursor: pointer"
                >
                  <div class="bd-step-title-wrapper">
                    <div class="bd-wizard-step-icon">
                      <i class="ri-account-box-line"></i>
                    </div>
                    <h6 class="bd-wizard-step-title">Datos personales</h6>
                    <p class="bd-wizard-step-subtitle">
                      Completa la siguiente información.
                    </p>
                  </div>
                </a>
              </li>
              <li role="tab" :class="tab == 2 ? 'current' : 'disable'">
                <a
                  @click="changeTab(2)"
                  aria-controls="wizard-p-1"
                  style="cursor: pointer"
                >
                  <div class="bd-step-title-wrapper">
                    <div class="bd-wizard-step-icon">
                      <i class="ri-building-4-line"></i>
                    </div>
                    <h6 class="bd-wizard-step-title">Crear empresa</h6>
                    <p class="bd-wizard-step-subtitle">
                      Necesitamos algunos datos basicos del negocio.
                    </p>
                  </div>
                </a>
              </li>
              <li
                role="tab"
                :class="tab == 3 ? 'current' : 'disable'"
                aria-disabled="false"
                aria-selected="true"
              >
                <a
                  @click="changeTab(3)"
                  aria-controls="wizard-p-2"
                  style="cursor: pointer"
                >
                  <div class="bd-step-title-wrapper">
                    <div class="bd-wizard-step-icon">
                      <i class="ri-bank-card-2-line"></i>
                    </div>
                    <h6 class="bd-wizard-step-title">Plan</h6>
                    <p class="bd-wizard-step-subtitle">
                      Elige el tipo de plan a contratar.
                    </p>
                  </div>
                </a>
              </li>
              <li role="tab" :class="tab == 4 ? 'current' : 'disable'">
                <a
                  @click="changeTab(4)"
                  aria-controls="wizard-p-3"
                  style="cursor: pointer"
                >
                  <div class="bd-step-title-wrapper">
                    <div class="bd-wizard-step-icon">
                      <i class="ri-send-plane-2-line"></i>
                    </div>
                    <h6 class="bd-wizard-step-title">Registrarse</h6>
                  </div>
                </a>
              </li>
            </ul>
          </div>
          <div v-if="tab == 1" class="content clearfix">
            <section class="body current">
              <h4 class="section-heading">Ingresa tus datos personales.</h4>
              <div class="form-group">
                <label for="text" class="sr-only">Nombre</label>
                <input
                  type="text"
                  v-model="item.user.name"
                  name="text"
                  id="text"
                  class="form-control"
                  placeholder="Juan perez"
                />
              </div>
              <div class="form-group">
                <label for="text" class="sr-only">Correo</label>
                <input
                  type="email"
                  v-model="item.user.email"
                  name="email"
                  id="text"
                  class="form-control"
                  placeholder="correo@gmail.com"
                />
              </div>
              <div class="form-group">
                <label for="password" class="sr-only">Contraseña</label>
                <input
                  type="password"
                  v-model="item.user.password"
                  name="password"
                  id="password"
                  class="form-control"
                />
              </div>
              <div></div>
            </section>
          </div>
          <div v-if="tab == 2" class="content clearfix">
            <section class="body current">
              <h4 class="section-heading">Datos de tu empresa</h4>
              <div class="form-group">
                <label for="company_name" class="sr-only"
                  >Nombre de la empresa</label
                >
                <input
                  type="text"
                  v-model="item.company.name"
                  name="company_name"
                  id="company_name"
                  class="form-control"
                  placeholder="Tienda don jose."
                />
              </div>
              <div class="form-group">
                <label for="phone" class="sr-only">Telefono</label>
                <input
                  type="text"
                  v-model="item.company.phone"
                  name="phone"
                  id="phone"
                  class="form-control"
                  placeholder="449-123-45-67"
                />
              </div>
              <div class="form-group">
                <label for="email" class="sr-only">Correo</label>
                <input
                  type="text"
                  v-model="item.company.email"
                  name="email"
                  id="email"
                  class="form-control"
                  placeholder="TiendaJose@correo.com"
                />
              </div>
              <div></div>
            </section>
          </div>

          <div v-if="tab == 3" class="content clearfix">
            <section class="body current">
              <h4 class="section-heading">Selecciona tu plan</h4>
              <div class="purpose-radios-wrapper">
                <div class="purpose-radio">
                  <input
                    type="radio"
                    name="purpose"
                    id="branding"
                    class="purpose-radio-input"
                    value="Branding"
                    checked=""
                  />
                  <label for="branding" class="purpose-radio-label">
                    <span class="label-icon">
                      <img alt="branding" class="label-icon-default" />
                      <img alt="branding" class="label-icon-active" />
                    </span>
                    <span class="label-text">Mensual</span>
                  </label>
                </div>
                <div class="purpose-radio">
                  <input
                    type="radio"
                    name="purpose"
                    id="mobile-design"
                    class="purpose-radio-input"
                    value="Moile Design"
                  />
                  <label for="mobile-design" class="purpose-radio-label">
                    <span class="label-icon">
                      <img alt="branding" class="label-icon-default" />
                      <img alt="branding" class="label-icon-active" />
                    </span>
                    <span class="label-text">Personalizado</span>
                  </label>
                </div>
                <div class="purpose-radio">
                  <input
                    type="radio"
                    name="purpose"
                    id="web-design"
                    class="purpose-radio-input"
                    value="Web Design"
                  />
                  <label for="web-design" class="purpose-radio-label">
                    <span class="label-icon">
                      <img alt="branding" class="label-icon-default" />
                      <img alt="branding" class="label-icon-active" />
                    </span>
                    <span class="label-text">Anual</span>
                  </label>
                </div>
              </div>
              <div></div>
            </section>
          </div>

          <div v-if="tab == 4" class="content clearfix">
            <section
              id="wizard-p-3"
              role="tabpanel"
              aria-labelledby="wizard-h-3"
              class="body current"
              aria-hidden="false"
              style=""
            >
              <h4 class="section-heading">Acepto terminos y condiciones.</h4>
              <div class="form-check mt-4">
                <label class="form-check-label">
                  <input
                    v-model="terms"
                    type="checkbox"
                    class="form-check-input"
                    name="termsAgreement"
                    id="termsAgreement"
                    value="termsAgreed"
                  />
                  Estoy de acuerdo con los terminos de condiciones.
                </label>
              </div>
            </section>
          </div>

          <div class="actions clearfix">
            <ul role="menu" aria-label="Pagination">
              <li
                class=""
                aria-disabled="false"
                v-if="tab != 1"
                @click="changeTab(tab - 1)"
              >
                <a role="menuitem" style="cursor: pointer">Anterior</a>
              </li>
              <li
                aria-hidden="false"
                v-if="tab != 4"
                aria-disabled="false"
                class=""
                style="display: list-item; cursor: pointer"
                @click="changeTab(tab + 1)"
              >
                <a role="menuitem">Siguiente</a>
              </li>
              <li aria-hidden="true" v-if="tab == 4 && terms">
                <a @click="submit" role="menuitem" style="cursor: pointer"
                  >Terminar</a
                >
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
const toast = useToast();

export default {
  components: {},

  data() {
    return {
      item: this.$inertia.form({
        user: {
          name: "",
          email: "",
          password: "",
        },
        company: {
          name: "",
          phone: "",
          email: "",
        },
      }),
      tab: 1,
      terms: false,
    };
  },

  methods: {
    changeTab(numberTab) {
      if (this.tab < numberTab) {
        switch (this.tab) {
          case 1:
            this.validateFields("user.first.step", this.item.user, numberTab);
            break;
          case 2:
            this.validateFields(
              "user.second.step",
              this.item.company,
              numberTab
            );
            break;
          default:
            this.tab = numberTab;
        }
      } else {
        this.tab = numberTab;
      }
    },
    validateFields(url, post_item, numberTab) {
      axios
        .post(this.route(url, post_item))
        .then((response) => {
          this.tab = numberTab;
        })
        .catch((errors) => {
          this.showToast(errors.response.data.message);
        });
    },

    showToast(message) {
      toast.warning(message, {
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
        rtl: false,
      });
    },
    submit() {
      this.item
        .transform((data) => ({
          ...data,
          remember: this.item.remember ? "on" : "",
        }))
        .post(this.route("register"), {
          onError: (errors) => {
            if (Object.values(errors)[0])
              this.$toast.open({
                duration: 2000,
                message: Object.values(errors)[0],
                type: "error",
              });
            else
              this.$toast.open({
                duration: 2000,
                message:
                  "Estas credenciales no coinciden con nuestros registros.",
                type: "error",
              });
            this.item.reset("password");
          },
        });
    },
  },
};
</script>
<style scoped>
body {
  font-family: "Karla", sans-serif;
  background-color: #ffffff00;
}
</style>