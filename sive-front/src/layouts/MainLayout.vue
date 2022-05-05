<template>
  <q-layout view="hHh lpr fff">
    <q-header bordered class="bg-primary text-white">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

        <q-toolbar-title class="cursor-pointer" @click="router.push('/')">
          <q-avatar>
            <img src="icons/logo.png" />
          </q-avatar>
          SISEVID - Software de evidencia de actividades.
        </q-toolbar-title>
        <q-btn @click="logOut()" flat round dense icon="fas fa-sign-out-alt" />
      </q-toolbar>
    </q-header>

    <q-drawer
      class="bg-dark text-white"
      v-model="leftDrawerOpen"
      side="left"
      behavior="desktop"
    >
      <div
        class="full-height"
        :class="$q.dark.isActive ? 'drawer_dark' : 'drawer_normal'"
      >
        <div style="height: calc(100% - 117px); padding: 10px">
          <q-toolbar>
            <q-avatar>
              <img src="icons/logo.png" />
            </q-avatar>

            <q-toolbar-title>SISEVID - Menú</q-toolbar-title>
          </q-toolbar>
          <hr />
          <q-scroll-area style="height: 100%">
            <q-list padding>
              <q-item
                active-class="tab-active"
                to="/users"
                exact
                class="q-ma-sm navigation-item"
                clickable
                v-ripple
              >
                <q-item-section avatar>
                  <q-icon name="people" />
                </q-item-section>

                <q-item-section> Usuarios </q-item-section>
              </q-item>
              <q-item
                active-class="tab-active"
                to="/facultades"
                exact
                class="q-ma-sm navigation-item"
                clickable
                v-ripple
              >
                <q-item-section avatar>
                  <q-icon name="school" />
                </q-item-section>

                <q-item-section> Facultades </q-item-section>
              </q-item>
              <q-item
                active-class="tab-active"
                to="/programs"
                exact
                class="q-ma-sm navigation-item"
                clickable
                v-ripple
              >
                <q-item-section avatar>
                  <q-icon name="menu_book" />
                </q-item-section>

                <q-item-section> Programas académicos </q-item-section>
              </q-item>
              <q-item
                active-class="tab-active"
                to="/capitulos"
                exact
                class="q-ma-sm navigation-item"
                clickable
                v-ripple
              >
                <q-item-section avatar>
                  <q-icon name="menu" />
                </q-item-section>

                <q-item-section> Capítulos </q-item-section>
              </q-item>
              <q-item
                active-class="tab-active"
                to="/ciclos"
                exact
                class="q-ma-sm navigation-item"
                clickable
                v-ripple
              >
                <q-item-section avatar>
                  <q-icon name="insights" />
                </q-item-section>

                <q-item-section> Ciclos </q-item-section>
              </q-item>
              <q-item
                active-class="tab-active"
                to="/asignaturas"
                exact
                class="q-ma-sm navigation-item"
                clickable
                v-ripple
              >
                <q-item-section avatar>
                  <q-icon name="card_membership" />
                </q-item-section>

                <q-item-section> Asignaturas </q-item-section>
              </q-item>
            </q-list>
          </q-scroll-area>
        </div>
      </div>
    </q-drawer>
    <q-page-container>
      <!-- <div class="q-pa-md">
        <q-breadcrumbs>
          <q-breadcrumbs-el label="Home" />
          <q-breadcrumbs-el label="Components" />
          <q-breadcrumbs-el label="Breadcrumbs" />
        </q-breadcrumbs>
      </div> -->

      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useUserStore } from "../stores/User";
import { useQuasar } from "quasar";
import mixin from "../mixins/mixin";
export default {
  name: "MainLayout",
  setup() {
    const $q = useQuasar();
    const user = useUserStore();
    const { showLoading, hideLoading, showNoty } = mixin();
    const leftDrawerOpen = ref(true);
    const router = useRouter();

    const logOut = () => {
      showLoading("Cerrando sesión...");
      user
        .logOut()
        .then((response) => {
          hideLoading();
          $q.localStorage.remove("token");
          router.push("/login");
        })
        .catch((error) => {
          hideLoading();
          showNoty("error", "Ocurrió un error al cerrar sesión.");
        });
    };

    return {
      leftDrawerOpen,
      toggleLeftDrawer() {
        leftDrawerOpen.value = !leftDrawerOpen.value;
      },
      router,
      logOut,
    };
  },
};
</script>
