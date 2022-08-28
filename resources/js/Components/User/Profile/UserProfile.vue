<template>
    <main class="row justify-content-around align-items-center h-100">
        <section class="col-3 card rounded-3">
            <article class="d-flex flex-column justify-content-center align-items-center mb-3">
                <div style="width: 180px; height: 180px" class="mt-3 mb-3">
                    <img style="object-fit: contain; width: inherit;" :src="$asset('images/profile-default-image.png')">
                </div>
                <h3 class="text-center">{{ auth.name.substring(0, 25) }}</h3>
                <h6 class="text-muted ">{{ auth.user_type_name }}</h6>
                <span class="badge rounded-pill m-1" style="background-color: #75a2ca;">
                    <i class="bi bi-envelope me-1"></i>{{ auth.email }}
                </span>
                <span v-if="auth.user_company_name" class="badge rounded-pill m-1" style="background-color: #75a2ca;">
                    <i class="bi bi-building me-1"></i>{{ auth.user_company_name }}
                </span>
                <span v-if="auth.user_branch_name" class="badge rounded-pill m-1" style="background-color: #75a2ca;">
                    <i class="bi bi-diagram-2-fill me-1"></i>{{ auth.user_branch_name }}
                </span>
                <div class="d-flex flex-row align-items-center justify-content-center w-75 mt-3 mb-2">
                    <hr class=" w-100 opacity-25">
                    <small style="font-size: 11px" class="m-2 fw-bolder text-muted opacity-75">NAVEGAR</small>
                    <hr class="w-100 opacity-25">
                </div>
                <div class="d-flex w-75 flex-row justify-content-around">
                    <div @click="active_tab = 'data_tab'" style="cursor: pointer"
                         class="user-profile-navigation-button d-flex m-2 align-items-center flex-column justify-content-center card shadow-sm rounded-5 w-100 p-2">
                        <i style="font-size: 40px; color: #75a2ca;" class="bi bi-person-bounding-box"></i>
                        <small>Datos</small>
                        <hr v-if="active_tab == 'data_tab'" class="user-profile-hr-line">
                    </div>
                    <div @click="active_tab = 'activity_tab'" style="cursor: pointer"
                         class="user-profile-navigation-button m-2 d-flex flex-column align-items-center justify-content-center card shadow-sm rounded-5 w-100 p-2">
                        <i style="font-size: 40px; color: #75a2ca;" class="bi bi-activity"></i>
                        <small>Actividad</small>
                        <hr v-if="active_tab == 'activity_tab'" class="user-profile-hr-line">
                    </div>
                </div>
                <div class="d-flex w-75 flex-row justify-content-around">
                    <div @click="active_tab = 'security_tab'" style="cursor: pointer"
                         class=" user-profile-navigation-button d-flex m-2 align-items-center flex-column justify-content-center card shadow-sm rounded-5 w-50 p-2">
                        <i style="font-size: 40px; color: #75a2ca;" class="bi bi-shield"></i>
                        <small>Seguridad</small>
                        <hr v-if="active_tab == 'security_tab'" class="user-profile-hr-line">
                    </div>
                </div>
            </article>
        </section>
        <section class="col-8">
            <user-account-data-card v-if="active_tab === 'data_tab'"></user-account-data-card>
            <user-activity-card v-else-if="active_tab === 'activity_tab'"></user-activity-card>
            <user-account-security-card v-else-if="active_tab === 'security_tab'"></user-account-security-card>
        </section>
    </main>
</template>

<script>
import UserAccountDataCard from "./UserProfileSections/UserAccountDataCard";
import UserActivityCard from "./UserProfileSections/UserActivityCard";
import UserAccountSecurityCard from "./UserProfileSections/UserAccountSecurityCard";

export default {
    name: "UserProfile",
    data() {
        return {
            active_tab: 'data_tab'
        }
    },
    components: {UserAccountSecurityCard, UserActivityCard, UserAccountDataCard}
}
</script>
