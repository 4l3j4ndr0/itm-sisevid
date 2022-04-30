<template>
  <q-card-section class="animated slideInLeft">
    <q-form ref="onLogin" @submit="onSubmit" class="q-gutter-md">
      <q-input
        filled
        v-model="email"
        label="email"
        dense
        lazy-rules
        :rules="[
          (val) => (val && val !== '') || `Campo requerido.`,
          (val) => validateEmail(val) || `Debe ser un email válido.`,
        ]"
      />
      <q-input
        type="password"
        filled
        v-model="password"
        label="Contraseña"
        dense
        lazy-rules
        :rules="[(val) => (val && val !== '') || `Campo requerido.`]"
      />
      <!-- <div style="text-align: center" class="q-gutter-sm justify-center">
        <p class="text-grey-6">
          <a
            style="cursor: pointer; text-decoration: underline"
            @click="$router.push('/forgotPassword')"
            >Olvidó la contraseña?</a
          >
        </p>
      </div> -->

      <div class="items-center">
        <q-btn
          style="width: 100%"
          label="Ingresar"
          to="/dashboard"
          color="primary"
          push
        />
      </div>
      <!-- <q-card-section>
        <div class="text-center q-gutter-sm">
          <p class="text-grey-6">Proveedores de autenticación</p>
          <q-btn round color="red-8" @click="registerProvider('google')">
            <q-icon name="fab fa-google-plus-g" size="1.2rem" />
          </q-btn>
          <q-btn round color="dark" @click="registerProvider('github')">
            <q-icon name="fab fa-github" size="1.2rem" />
          </q-btn>
        </div>
      </q-card-section> -->
    </q-form>
  </q-card-section>
</template>

<script type="text/javascript"></script>
<script>
import { Loading, Noty, Auxiliars } from "../../mixins/index";
export default {
  name: "login-login",
  mixins: [Loading, Noty, Auxiliars],
  components: {},
  data() {
    return {
      persistSession: false,
      email: null,
      password: null,
    };
  },
  methods: {
    onSubmit() {
      this.$refs.onLogin.validate().then((success) => {
        if (success) {
          this.showLoading("Iniciando sesión...");
          if (this.persistSession) {
            this.$loginPersistence(this.email, this.password)
              .then((user) => {
                this.hideLoading();
                this.redirectToDashboard(user);
              })
              .catch((e) => {
                this.hideLoading();
                this.errorLogin();
              });
          } else {
            this.$login(this.email, this.password)
              .then((user) => {
                this.hideLoading();
                this.redirectToDashboard(user);
              })
              .catch((e) => {
                this.hideLoading();
                this.errorLogin();
              });
          }
        }
      });
    },
    registerProvider(provider) {
      this.$loginWithProvider(provider)
        .then((user) => {
          this.redirectToDashboard(user);
        })
        .catch((e) => {
          this.errorLogin(e.message);
        });
    },
    redirectToDashboard(user) {
      this.NotyHtml(
        "success",
        "Sesión iniciada",
        `Bienvenido ${user.user.displayName ? user.user.displayName : ""}`
      );
      this.$router.push("/dashboard");
    },
    errorLogin(error = null) {
      this.Noty(
        "error",
        `${
          error
            ? error
            : "Se presentó un error al iniciar sesión, intenta nuevamente."
        }`
      );
    },
  },
};
</script>
