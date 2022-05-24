<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Evidencias</div>
      </q-card-section>
      <q-card-section>
        <q-btn
          @click="$router.push('/evidencias/create')"
          color="primary"
          label="Crear evidencia"
          no-caps
          icon="add"
          push
        />
      </q-card-section>
      <q-separator inset></q-separator>
      <Table
        @request="
          ({ page, rowsPerPage, filter }) =>
            getEvidencias(page, rowsPerPage, filter)
        "
        @edit="(evidencia) => router.push('/evidencias/edit/' + evidencia.id)"
        @delete="(evidencia) => deleteEvidencia(evidencia)"
        :columns="columns"
        :data="evidencias"
      ></Table>
    </q-card>
  </q-layout>
</template>
<script>
import Table from "../../components/Table.vue";
import mixin from "../../mixins/mixin";
import { useEvidenciaStore } from "../../stores/Evidencia";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
export default {
  name: "Evidencias",
  components: {
    Table,
  },
  setup() {
    const $q = useQuasar();
    const { showLoading, hideLoading, showNoty } = mixin();
    const evidencia = useEvidenciaStore();
    const router = useRouter();
    const evidencias = computed(() => {
      return useEvidenciaStore().evidencias;
    });
    const columns = ref([
      { name: "id", label: "Id", field: "id" },
      { name: "tipo", label: "Tipo de evidencia", field: "tipo" },
      { name: "autor", label: "Autor", field: "autor" },
      { name: "codigo", label: "Código", field: "codigo" },
      { name: "titulo", label: "Título", field: "titulo" },
      {
        name: "fecha_creacion",
        label: "Fecha creación",
        field: "fecha_creacion",
      },
      { name: "url", label: "Evidencia", field: "url" },
    ]);

    const getEvidencias = (page = 1, rowsPerPage = 50, filter = null) => {
      showLoading("Consultando evidencias...");
      evidencia
        .getEvidencias(page, rowsPerPage, filter)
        .then((response) => {
          hideLoading();
        })
        .catch((error) => {
          showNoty("error", "Ocurrió un error al consultar las evidencias.");
          hideLoading();
        });
    };

    onMounted(() => {
      getEvidencias();
    });

    const deleteEvidencia = (element) => {
      $q.dialog({
        title: "Eliminar evidencia",
        message: `Esta seguro de querer eliminar la evidencia ${element.titulo}?`,
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
          showLoading("Eliminando evidencia...");
          evidencia
            .deleteEvidencia(element.id)
            .then((response) => {
              hideLoading();
              showNoty("success", "Evidencia eliminada correctamente.");
              getUsers();
            })
            .catch((error) => {
              console.log("ERROR:::::", error);
              showNoty("error", "Ocurrió un error al eliminar la evidencia.");
              hideLoading();
            });
        })
        .onCancel(() => {});
    };

    return {
      columns,
      evidencias,
      getEvidencias,
      deleteEvidencia,
      router,
    };
  },
};
</script>
