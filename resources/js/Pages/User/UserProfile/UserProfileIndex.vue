<template>
  <div>
    <admin-layout>
      <section class="section">
        <user-profile :auth="auth"></user-profile>
      </section>
    </admin-layout>
  </div>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { defineComponent } from "vue";
import UserProfile from "../../../Components/User/Profile/UserProfile";

export default defineComponent({
  name: "App",
    props: ['auth'],
  components: {UserProfile, AdminLayout },
});
</script>
