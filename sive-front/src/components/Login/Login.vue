<template>
  <q-card-section class="animated slideInLeft">
    <q-form ref="myForm" @submit="onSubmit" class="q-gutter-md">
      <q-input
        filled
        v-model="email"
        label="email"
        dense
        lazy-rules
        type="email"
        :rules="[(val) => (val && val !== '') || `Campo requerido.`]"
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
          type="submit"
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
import mixin from "../../mixins/mixin";
import { useUserStore } from "../../stores/User";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
export default {
  name: "login-login",
  setup() {
    const $q = useQuasar();
    const router = useRouter();
    const { showLoading, hideLoading, showNoty } = mixin();
    const user = useUserStore();

    const myForm = ref(null);

    const email = ref(null);
    const password = ref(null);

    const onSubmit = () => {
      myForm.value.validate().then((success) => {
        if (success) {
          showLoading("Ingresando...");
          user
            .login(email.value, password.value)
            .then((data) => {
              $q.sessionStorage.set("token", data.token);
              $q.sessionStorage.set("permisos", data.permisos);
              hideLoading();
              router.push("/dashboard");
            })
            .catch((error) => {
              hideLoading();
              showNoty("error", error.message);
            });
        }
      });
    };

    return {
      email,
      myForm,
      password,
      onSubmit,
    };
  },
};
</script>
