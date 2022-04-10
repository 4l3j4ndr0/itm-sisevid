<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Editar usuario</div>
      </q-card-section>
      <q-card-section>
        <q-btn
          @click="router.push('/users')"
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
        <q-form
          ref="myForm"
          @submit="onSubmit"
          class="q-gutter-md"
          v-if="usuario"
        >
          <q-select
            v-model="usuario.tipo_personas_id_fk"
            :options="tipoPersonas"
            label="Tipo de usuario"
          />
          <q-input
            v-model="usuario.nombre"
            label="Nombre"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="usuario.apellidos"
            label="Apellidos"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="usuario.cedula"
            label="Cédula"
            type="tel"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="usuario.celular"
            label="Celular"
            type="tel"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="usuario.email"
            label="Email"
            type="email"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="usuario.password"
            label="Contraseña"
            type="password"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <div>
            <q-btn label="Guardar cambios" type="submit" color="primary" />
          </div>
        </q-form>
      </div>
    </q-card>
  </q-layout>
</template>
<script>
import mixin from "../../mixins/mixin";
import { useUserStore } from "../../stores/User";
import { ref, onMounted, computed, watch } from "vue";
import { useRouter, useRoute } from "vue-router";
export default {
  name: "UsersEdit",
  setup(props, { root }) {
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const route = useRoute();
    const myForm = ref(null);
    const user = useUserStore();

    const tipoPersonas = computed(() => {
      return useUserStore().tipoPersonas;
    });

    const usuario = computed(() => {
      return useUserStore().user;
    });

    const goUsersPage = () => {
      router.push("/users");
    };

    onMounted(() => {
      showLoading("Cargando usuario...");
      user.getTiposUsuarios();
      user.getUser(route.params.id).then(() => {
        hideLoading();
      });
    });

    const updateUser = () => {
      user
        .updateUser(usuario.value)
        .then(() => {
          hideLoading();
          showNoty("success", "Usuario actualizado correctamente.");
          goUsersPage();
        })
        .catch(() => {
          hideLoading();
          showNoty("error", "Error al actualizar usuario");
        });
    };

    const onSubmit = () => {
      myForm.value.validate().then((success) => {
        if (success) {
          showLoading("Guardando información...");
          updateUser();
        }
      });
    };

    return {
      tipoPersonas,
      myForm,
      onSubmit,
      router,
      usuario,
    };
  },
};
</script>
