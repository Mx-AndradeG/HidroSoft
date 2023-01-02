<template>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <nav class="header-nav w-100">
            <div class="d-flex align-items-center justify-content-between flex-row">
                <i @click="burger" class="bi bi-list toggle-sidebar-btn"></i>
                <a :href="route('Dashboard')" style="transform: scale(.8);"
                   class="logo d-flex align-items-center justify-content-center nav-item">
                    <img src="../../../Templates/NiceAdmin/img/logo.png" alt="">
                    <span class="d-none d-lg-block">HidroSoft</span>
                </a>
                <section class="d-flex flex-row align-items-end">
                    <div class="nav-item dropdown">

                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-bell"></i>
                            <span class="badge bg-primary badge-number">{{total == 0 ? '': total}}</span>
                        </a><!-- End Notification Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                            <li class="dropdown-header">
                              Tienes {{ total }} notificacion(es) nuevas
                                <!-- <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a> -->
                            </li>
                            <template v-for="(notification, index) in notifications">
                                <div>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li class="notification-item">
                                        <div>
                                            <p>{{ notification.menssage }}</p>
                                        </div>
                                        <i class="bi bi-check-circle text-success " 
                                            data-toggle="tooltip" 
                                            data-placement="top" 
                                            title="Marcar como visto" 
                                            @click="markNotificationAsView(notification.id)"
                                            style="cursor: pointer;">
                                        </i>
                                    </li>
                                </div>
                            </template>


                        </ul><!-- End Notification Dropdown Items -->

                    </div><!-- End Notification Nav -->
                    <div class="nav-item dropdown">
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                            <li class="dropdown-header">
                                You have 3 new messages
                                <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li class="message-item">
                                <a href="#">
                                    <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                                    <div>
                                        <h4>Maria Hudson</h4>
                                        <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                        <p>4 hrs. ago</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li class="message-item">
                                <a href="#">
                                    <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                                    <div>
                                        <h4>Anna Nelson</h4>
                                        <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                        <p>6 hrs. ago</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li class="message-item">
                                <a href="#">
                                    <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                                    <div>
                                        <h4>David Muldon</h4>
                                        <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                        <p>8 hrs. ago</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li class="dropdown-footer">
                                <a href="#">Show all messages</a>
                            </li>

                        </ul><!-- End Messages Dropdown Items -->

                    </div><!-- End Messages Nav -->
                    <div class="nav-item dropdown pe-3 ps-3">
                        <a class="nav-link nav-profile  p-0 d-flex" id="dropdownMenuProfile"
                           style="width: 50px; height: 50px;"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <img style="object-fit: contain; width: inherit;"
                                 :src="'/images/profile-default-image.png'"
                                 class="rounded-circle img-fluid d-inline align-self-center" alt="...">
                        </a><!-- End Profile Iamge Icon -->
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuProfile">
                            <li><a class="dropdown-item" :href="route('UserProfile')">Ir a Perfil</a></li>
                            <li><a class="dropdown-item" @click="$inertia.post(route('user.logout'))">Cerrar sesión</a></li>
                        </ul>
                    </div><!-- End Profile Nav -->
                </section>
            </div>
        </nav><!-- End Icons Navigation -->
    </header><!-- End Header -->
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue'

const select = (el, all = false) => {
    el = el.trim()
    if (all) {
        return [...document.querySelectorAll(el)]
    } else {
        return document.querySelector(el)
    }
}
const burger = () => {
    select('body').classList.toggle('toggle-sidebar')
}

const notifications = ref([]);
const total = ref(0);

onMounted(() => {
    getCurrentNotification();
})

const getCurrentNotification = () => {
    axios
    .get(
      route("notification.index", {
        columns: JSON.stringify([
          "id",
          "menssage",
          "viewed",
          "Formatted_created_at",
        ]),
      })
    )
    .then((response) => {
      notifications.value = response.data.data;
      total.value = response.data.count;
    });
}

const markNotificationAsView = (id) => {
    axios
    .get(
      route("sale.notification.viwed",id)
    )
    .then(() => {
        getCurrentNotification();
    });
}

</script>