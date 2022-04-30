<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Condiciones</div>
      </q-card-section>
      <q-card-section>
        <q-btn
          @click="$router.push('/condiciones/create')"
          color="primary"
          label="Crear condición"
          no-caps
          icon="add"
          push
        />
      </q-card-section>
      <q-separator inset></q-separator>
      <Table
        @request="
          ({ page, rowsPerPage, filter }) =>
            getCondiciones(page, rowsPerPage, filter)
        "
        @edit="(condicion) => router.push('/condiciones/edit/' + condicion.id)"
        @delete="(condicion) => deleteCondicion(condicion)"
        :columns="columns"
        :data="condicionesList"
      ></Table>
    </q-card>
  </q-layout>
</template>
<script>
import Table from "../../components/Table.vue";
import mixin from "../../mixins/mixin";
import { useCondicionesStore } from "../../stores/Condiciones";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
export default {
  name: "Condiciones",
  components: {
    Table,
  },
  setup() {
    const $q = useQuasar();
    const { showLoading, hideLoading, showNoty } = mixin();
    const condiciones = useCondicionesStore();
    const router = useRouter();
    const condicionesList = computed(() => {
      return useCondicionesStore().condiciones;
    });
    const columns = ref([
      { name: "id", label: "Id", field: "id" },
      { name: "programa", label: "Programa académico", field: "programa" },
      { name: "capitulo", label: "Capítulo", field: "capitulo" },
      { name: "condicion", label: "Condición", field: "condicion" },
      { name: "descripcion", label: "Descripción", field: "descripcion" },
    ]);

    const getCondiciones = (page = 1, rowsPerPage = 50, filter = null) => {
      showLoading("Consultando condiciones...");
      condiciones
        .getCondiciones(page, rowsPerPage, filter)
        .then((response) => {
          hideLoading();
        })
        .catch((error) => {
          showNoty("error", "Ocurrió un error al consultar las condiciones.");
          hideLoading();
        });
    };

    onMounted(() => {
      getCondiciones();
    });

    const deleteCondicion = (element) => {
      $q.dialog({
        title: "Eliminar condición",
        message: `Esta seguro de querer eliminar la condición ${element.condicion}?`,
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
          showLoading("Eliminando condición...");
          programas
            .deletePrograma(element.id)
            .then((response) => {
              hideLoading();
              showNoty("success", response.data.message);
              getCondiciones();
            })
            .catch((error) => {
              hideLoading();
              showNoty("error", "Ocurrió un error al eliminar la condición.");
            });
        })
        .onCancel(() => {});
    };

    return {
      router,
      columns,
      getCondiciones,
      deleteCondicion,
      condicionesList,
    };
  },
};
</script>
