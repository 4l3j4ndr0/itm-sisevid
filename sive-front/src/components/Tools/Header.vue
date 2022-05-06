<template>
  <q-header reveal bordered class="bg-white text-black">
    <q-toolbar>
      <q-toolbar-title class="q-pa-sm">
        <img :src="logo" style="height: 35px; width: auto; display: block" />
      </q-toolbar-title>
    </q-toolbar>
  </q-header>
</template>

<script>
export default {
  name: "header",
  setup() {
    const logo = new URL("../../assets/icons/logo.png", import.meta.url).href;
    return {
      logo,
    };
  },
};
</script>
