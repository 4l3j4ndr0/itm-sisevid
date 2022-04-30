<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Capítulos</div>
      </q-card-section>
      <q-card-section>
        <q-btn
          @click="$router.push('/capitulos/create')"
          color="primary"
          label="Crear capítulo"
          no-caps
          icon="add"
          push
        />
      </q-card-section>
      <q-separator inset></q-separator>
      <Table
        @request="
          ({ page, rowsPerPage, filter }) =>
            getCapitulos(page, rowsPerPage, filter)
        "
        @edit="(capitulo) => router.push('/capitulos/edit/' + capitulo.id)"
        @delete="(capitulo) => deleteCapitulo(capitulo)"
        :columns="columns"
        :data="capitulosList"
      ></Table>
    </q-card>
  </q-layout>
</template>
<script>
import Table from "../../components/Table.vue";
import mixin from "../../mixins/mixin";
import { useCapitulosStore } from "../../stores/Capitulos";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
export default {
  name: "Capitulos",
  components: {
    Table,
  },
  setup() {
    const $q = useQuasar();
    const { showLoading, hideLoading, showNoty } = mixin();
    const capitulos = useCapitulosStore();
    const router = useRouter();
    const capitulosList = computed(() => {
      return useCapitulosStore().capitulos;
    });
    const columns = ref([
      { name: "id", label: "Id", field: "id" },
      { name: "capitulo", label: "Código", field: "capitulo" },
      { name: "descripcion", label: "Descripción", field: "descripcion" },
    ]);

    const getCapitulos = (page = 1, rowsPerPage = 50, filter = null) => {
      showLoading("Consultando capítulos...");
      capitulos
        .getCapitulos(page, rowsPerPage, filter)
        .then((response) => {
          hideLoading();
        })
        .catch((error) => {
          showNoty("error", "Ocurrió un error al consultar los capítulos.");
          hideLoading();
        });
    };

    onMounted(() => {
      getCapitulos();
    });

    const deleteCapitulo = (element) => {
      $q.dialog({
        title: "Eliminar capítulo",
        message: `Esta seguro de querer eliminar el capítulo ${element.capitulo}?`,
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
          showLoading("Eliminando capítulo...");
          capitulos
            .deleteCapitulo(element.id)
            .then((response) => {
              hideLoading();
              showNoty("success", response.data.message);
              getCapitulos();
            })
            .catch((error) => {
              console.log("ERRRO:::::", error);
              hideLoading();
              showNoty("error", "Ocurrió un error al eliminar el capítulo.");
            });
        })
        .onCancel(() => {});
    };

    return {
      router,
      columns,
      capitulos,
      getCapitulos,
      deleteCapitulo,
      capitulosList,
    };
  },
};
</script>
