<template>
  <div>
    <company-layout>
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">
                Este es el layout de las empresas
              </p>
              <h5 class="font-weight-bolder">$53,000</h5>
              <p class="mb-0">
                <span class="text-success text-sm font-weight-bolder"
                  >+55%</span
                >
                since yesterday
              </p>
            </div>
          </div>
          <div class="col-4 text-end">
            <div
              class="
                icon icon-shape
                bg-gradient-primary
                shadow-primary
                text-center
                rounded-circle
              "
            >
              <i
                class="ni ni-money-coins text-lg opacity-10"
                aria-hidden="true"
              ></i>
            </div>
          </div>
        </div>
      </div>
    </company-layout>
  </div>
</template>

<script>
import CompanyLayout from "@/Layouts/CompanyLayout.vue";

export default {
  data() {
    return {};
  },
  components: {
    CompanyLayout,
  },
};
</script>
