<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Facultades</div>
      </q-card-section>
      <q-card-section>
        <q-btn
          @click="$router.push('/facultades/create')"
          color="primary"
          label="Crear facultad"
          no-caps
          icon="add"
          push
        />
      </q-card-section>
      <q-separator inset></q-separator>
      <Table
        @request="
          ({ page, rowsPerPage, filter }) =>
            getFacultades(page, rowsPerPage, filter)
        "
        @edit="(facultad) => router.push('/facultades/edit/' + facultad.id)"
        @delete="(facultad) => deleteFacultad(facultad)"
        :columns="columns"
        :data="facultades"
      ></Table>
    </q-card>
  </q-layout>
</template>
<script>
import Table from "../../components/Table.vue";
import mixin from "../../mixins/mixin";
import { useFacultadesStore } from "../../stores/Facultades";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
export default {
  name: "Facultades",
  components: {
    Table,
  },
  setup() {
    const $q = useQuasar();
    const { showLoading, hideLoading, showNoty } = mixin();
    const facultad = useFacultadesStore();
    const router = useRouter();
    const facultades = computed(() => {
      return useFacultadesStore().facultades;
    });
    const columns = ref([
      { name: "id", label: "Id", field: "id" },
      { name: "facultad", label: "Facultad", field: "facultad" },
      { name: "decano", label: "Decano", field: "decano_id_fk" },
    ]);

    const getFacultades = (page = 1, rowsPerPage = 50, filter = null) => {
      showLoading("Consultando facultades...");
      facultad
        .getFacultades(page, rowsPerPage, filter)
        .then((response) => {
          hideLoading();
        })
        .catch((error) => {
          showNoty("error", "Ocurrió un error al consultar las facultades.");
          hideLoading();
        });
    };

    onMounted(() => {
      getFacultades();
    });

    const deleteFacultad = (element) => {
      $q.dialog({
        title: "Eliminar facultad",
        message: `Esta seguro de querer eliminar la facultad ${element.facultad}?`,
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
          showLoading("Eliminando facultad...");
          facultad
            .deleteFacultad(element.id)
            .then((response) => {
              hideLoading();
              showNoty("success", response.data.message);
              getFacultades();
            })
            .catch((error) => {
              hideLoading();
              showNoty("error", "Ocurrió un error al eliminar la facultad.");
            });
        })
        .onCancel(() => {});
    };

    return {
      router,
      columns,
      facultades,
      getFacultades,
      deleteFacultad,
    };
  },
};
</script>
