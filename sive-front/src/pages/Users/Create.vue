<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Crear usuarios</div>
      </q-card-section>
      <q-card-section>
        <q-btn
          @click="$router.push('/users')"
          color="primary"
          label="Regresar usuarios"
          icon="arrow_back"
          no-caps
          flat
          push
        />
      </q-card-section>
      <q-separator inset></q-separator>
      <div class="q-pa-md" style="max-width: 400px">
        <q-form ref="myForm" @submit="onSubmit" class="q-gutter-md">
          <q-select
            v-model="tipo_personas_id_fk"
            :options="tipoPersonas"
            label="Tipo de usuario"
          />
          <q-input
            v-model="nombre"
            label="Nombre"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="apellidos"
            label="Apellidos"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="cedula"
            label="Cédula"
            type="tel"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="celular"
            label="Celular"
            type="tel"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="email"
            label="Email"
            type="email"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="password"
            label="Contraseña"
            type="password"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <div>
            <q-btn label="Crear usuario" type="submit" color="primary" />
          </div>
        </q-form>
      </div>
    </q-card>
  </q-layout>
</template>
<script>
import mixin from "../../mixins/mixin";
import { useUserStore } from "../../stores/User";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
export default {
  name: "UsersCreate",
  setup(props, { root }) {
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const myForm = ref(null);
    const user = useUserStore();

    const tipo_personas_id_fk = ref(null);
    const nombre = ref(null);
    const apellidos = ref(null);
    const cedula = ref(null);
    const celular = ref(null);
    const email = ref(null);
    const password = ref(null);

    const tipoPersonas = computed(() => {
      return useUserStore().tipoPersonas;
    });

    const goUsersPage = () => {
      router.push("/users");
    };

    const createUser = () => {
      user
        .createUser({
          tipo_personas_id_fk: tipo_personas_id_fk.value.value,
          nombre: nombre.value,
          apellidos: apellidos.value,
          cedula: cedula.value,
          celular: celular.value,
          email: email.value,
          password: password.value,
        })
        .then((response) => {
          hideLoading();
          showNoty("success", response.data.message);
          goUsersPage();
        })
        .catch((error) => {
          hideLoading();
          showNoty("error", "Ocurrió un error al crear el usuario.");
        });
    };

    onMounted(() => {
      user.getTiposUsuarios();
    });

    const onSubmit = () => {
      myForm.value.validate().then((success) => {
        if (success) {
          showLoading("Creando usuario...");
          createUser();
        }
      });
    };

    return {
      tipoPersonas,
      myForm,
      tipo_personas_id_fk,
      nombre,
      apellidos,
      cedula,
      celular,
      email,
      password,
      onSubmit,
    };
  },
};
</script>
