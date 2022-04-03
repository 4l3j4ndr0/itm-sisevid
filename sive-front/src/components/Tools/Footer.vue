<template>
  <q-footer
    bordered
    class="bg-dark text-white items-center"
    style="height: 15%"
  >
    <q-toolbar class="justify-center column q-gutter-md q-pt-md">
      <div class="justify-center">
        <div class="text-center q-gutter-sm">
          <q-btn size="sm" round outline>
            <q-icon
              @click="openNewTab('https://www.facebook.com/castanedaocampo')"
              name="fab fa-facebook-f"
              size="1.2rem"
            />
          </q-btn>
          <q-btn
            @click="openNewTab('https://www.instagram.com/alejandro.1994/')"
            size="sm"
            round
            outline
          >
            <q-icon name="fab fa-instagram" size="1.2rem" />
          </q-btn>
          <q-btn
            size="sm"
            round
            outline
            @click="openNewTab('https://github.com/4l3j4ndr0')"
          >
            <q-icon name="fab fa-github" size="1.2rem" />
          </q-btn>
        </div>
      </div>
      <q-separator style="width: 90%; background-color: white" />
      <div class="text-subtitle" style="padding">
        SISEVID © Alejandro Castañeda Ocampo
        {{ new Date().getFullYear() }}.
      </div>
    </q-toolbar>
  </q-footer>
</template>

<script>
export default {
  name: "footer",
  methods: {
    openNewTab(url) {
      window.open(url, "_blank");
    },
  },
};
</script>
