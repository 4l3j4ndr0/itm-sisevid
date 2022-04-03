<template>
  <div
    class="animated bounceInUp"
    v-bind:style="$q.screen.lt.sm ? { width: '90%' } : { width: '35%' }"
  >
    <q-card>
      <q-card-section>
        <q-avatar
          style="z-index: 1"
          size="103px"
          class="absolute-center shadow-19"
        >
          <img src="icons/logo.png" />
        </q-avatar>
      </q-card-section>
      <q-card-section>
        <!--  -->
      </q-card-section>
      <login-form></login-form>
    </q-card>
  </div>
</template>

<script>
import LoginForm from "./Login.vue";
export default {
  name: "login",
  components: {
    LoginForm,
  },
  data() {
    return {
      tab: "login",
    };
  },
  methods: {},
};
</script>
