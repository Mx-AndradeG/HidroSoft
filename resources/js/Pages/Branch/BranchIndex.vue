<template>
  <div>
    <branch-layout>
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">
                Este es el Layout de las Sucursales
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
    </branch-layout>
  </div>
</template>

<script>
import BranchLayout from "@/Layouts/BranchLayout.vue";

export default {
  data() {
    return {};
  },
  components: {
    BranchLayout,
  },
};
</script>
