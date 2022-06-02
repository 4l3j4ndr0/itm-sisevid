<template>
  <router-view />
</template>

<script lang="ts">
import { useQuasar } from "quasar";
import { defineComponent, onMounted } from "vue";
import { useUserStore } from "./stores/User";

export default defineComponent({
  name: "App",
  setup() {
    const $q = useQuasar();
    const user = useUserStore();

    const setToken = (token) => {
      user.setToken(token);
    };

    const setPermisos = (permisos) => {
      user.setPermisos(permisos);
    };

    onMounted(() => {
      const token = $q.sessionStorage.getItem("token");
      const permisos = $q.sessionStorage.getItem("permisos");
      if (token) {
        setToken(token);
        setPermisos(permisos);
      }
    });
  },
});
</script>
