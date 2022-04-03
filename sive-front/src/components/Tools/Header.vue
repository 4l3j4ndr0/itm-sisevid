<template>
  <q-header reveal bordered class="bg-white text-black">
    <q-toolbar>
      <q-toolbar-title class="q-pa-sm">
        <img
          src="/icons/logo.png"
          style="height: 35px; width: auto; display: block"
        />
      </q-toolbar-title>
      <q-btn
        v-if="route === '/forgotPassword'"
        label="Iniciar sesion"
        to="/"
        type="button"
        color="primary"
      />
    </q-toolbar>
  </q-header>
</template>

<script>
export default {
  name: "header",
  computed: {
    route: function () {
      return this.$route.path;
    },
  },
};
</script>
