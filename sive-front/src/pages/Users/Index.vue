<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Usuarios</div>
      </q-card-section>
      <q-card-section>
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
        @rowClick="goEditUserPage"
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
export default {
  name: "Users",
  components: {
    Table,
  },
  setup() {
    const { showLoading, hideLoading, showNoty } = mixin();
    const user = useUserStore();
    const router = useRouter();
    const users = computed(() => {
      return useUserStore().users;
    });
    const columns = ref([
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

    const goEditUserPage = (id) => {
      router.push(`/users/edit/${id}`);
    };

    onMounted(() => {
      getUsers();
    });

    return {
      columns,
      users,
      getUsers,
      goEditUserPage,
    };
  },
};
</script>
