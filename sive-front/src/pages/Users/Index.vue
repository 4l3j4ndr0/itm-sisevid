<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section v-if="!hideOptions">
        <div class="text-h6">Usuarios</div>
      </q-card-section>
      <q-card-section v-if="!hideOptions">
        <q-btn
          @click="$router.push('/users/create')"
          color="primary"
          label="Crear usuario"
          no-caps
          icon="add"
          push
        />
      </q-card-section>
      <q-separator inset></q-separator>
      <Table
        @request="
          ({ page, rowsPerPage, filter }) => getUsers(page, rowsPerPage, filter)
        "
        @edit="(user) => router.push('/users/edit/' + user.id)"
        @delete="(user) => deleteUser(user)"
        :columns="columns"
        :data="users"
      ></Table>
    </q-card>
  </q-layout>
</template>
<script>
import Table from "../../components/Table.vue";
import mixin from "../../mixins/mixin";
import { useUserStore } from "../../stores/User";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
export default {
  name: "Users",
  components: {
    Table,
  },
  setup() {
    const $q = useQuasar();
    const { showLoading, hideLoading, showNoty } = mixin();
    const user = useUserStore();
    const router = useRouter();
    const users = computed(() => {
      return useUserStore().users;
    });
    const columns = ref([
      { name: "id", label: "Id", field: "id" },
      { name: "tipo", label: "Tipo de usuario", field: "tipo" },
      { name: "nombre", label: "Nombre", field: "nombre" },
      { name: "apellidos", label: "Apellidos", field: "apellidos" },
      { name: "cedula", label: "Cédula", field: "cedula" },
      { name: "celular", label: "Celular", field: "celular" },
      { name: "email", label: "Email", field: "email" },
    ]);

    const getUsers = (page = 1, rowsPerPage = 50, filter = null) => {
      showLoading("Consultando usuarios...");
      user
        .getUsers(page, rowsPerPage, filter)
        .then((response) => {
          hideLoading();
        })
        .catch((error) => {
          showNoty("error", "Ocurrió un error al consultar los usuarios.");
          hideLoading();
        });
    };

    onMounted(() => {
      getUsers();
    });

    const deleteUser = (element) => {
      $q.dialog({
        title: "Eliminar usuario",
        message: `Esta seguro de querer eliminar el usuario ${element.nombre} ${element.apellidos}?`,
        cancel: {
          label: "Cancelar",
          color: "blue",
        },
        ok: {
          label: "Eliminar",
          color: "red",
          push: true,
        },
        persistent: true,
      })
        .onOk(() => {
          showLoading("Eliminando usuario...");
          user
            .deleteUser(element.id)
            .then((response) => {
              hideLoading();
              showNoty("success", "Usuario eliminado correctamente.");
              getUsers();
            })
            .catch((error) => {
              console.log("ERROR:::::", error);
              showNoty("error", "Ocurrió un error al eliminar el usuario.");
              hideLoading();
            });
        })
        .onCancel(() => {});
    };

    return {
      columns,
      users,
      getUsers,
      deleteUser,
      router,
    };
  },
};
</script>
