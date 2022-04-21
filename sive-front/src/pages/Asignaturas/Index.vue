<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Asignaturas</div>
      </q-card-section>
      <q-card-section>
        <q-btn
          @click="$router.push('/asignaturas/create')"
          color="primary"
          label="Crear asignatura"
          no-caps
          icon="add"
          push
        />
      </q-card-section>
      <q-separator inset></q-separator>
      <Table
        @request="
          ({ page, rowsPerPage, filter }) =>
            getAsignaturas(page, rowsPerPage, filter)
        "
        @edit="
          (asignatura) => router.push('/asignaturas/edit/' + asignatura.id)
        "
        @delete="(asignatura) => deleteAsignatura(asignatura)"
        :columns="columns"
        :data="asignaturas"
      ></Table>
    </q-card>
  </q-layout>
</template>
<script>
import Table from "../../components/Table.vue";
import mixin from "../../mixins/mixin";
import { useAsignaturasStore } from "../../stores/Asignaturas";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
export default {
  name: "Asignaturas",
  components: {
    Table,
  },
  setup() {
    const $q = useQuasar();
    const { showLoading, hideLoading, showNoty } = mixin();
    const asignatura = useAsignaturasStore();
    const router = useRouter();
    const asignaturas = computed(() => {
      return useAsignaturasStore().asignaturas;
    });
    const columns = ref([
      { name: "id", label: "Id", field: "id" },
      { name: "programa", label: "Programa", field: "programa" },
      { name: "ciclo", label: "Ciclo", field: "ciclo" },
      { name: "asignatura", label: "Asignatura", field: "asignatura" },
      { name: "Créditos", label: "creditos", field: "creditos" },
    ]);

    const getAsignaturas = (page = 1, rowsPerPage = 50, filter = null) => {
      showLoading("Consultando asignaturas...");
      asignatura
        .getAsignaturas(page, rowsPerPage, filter)
        .then((response) => {
          hideLoading();
        })
        .catch((error) => {
          showNoty("error", "Ocurrió un error al consultar las asignaturas.");
          hideLoading();
        });
    };

    onMounted(() => {
      getAsignaturas();
    });

    const deleteAsignatura = (element) => {
      $q.dialog({
        title: "Eliminar asignatura",
        message: `Esta seguro de querer eliminar la asignatura ${element.asignatura}?`,
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
          showLoading("Eliminando asignatura...");
          asignatura
            .deleteAsignatura(element.id)
            .then((response) => {
              hideLoading();
              showNoty("success", response.data.message);
              getAsignaturas();
            })
            .catch((error) => {
              hideLoading();
              showNoty("error", "Ocurrió un error al eliminar la asignatura.");
            });
        })
        .onCancel(() => {});
    };

    return {
      router,
      columns,
      asignaturas,
      getAsignaturas,
      deleteAsignatura,
    };
  },
};
</script>
