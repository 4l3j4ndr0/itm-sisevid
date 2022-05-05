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

    onMounted(() => {
      const token = $q.localStorage.getItem("token");
      if (token) {
        setToken(token);
      }
    });
  },
});
</script>
