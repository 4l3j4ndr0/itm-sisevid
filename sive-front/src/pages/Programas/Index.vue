<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Programas académicos</div>
      </q-card-section>
      <q-card-section>
        <q-btn
          @click="$router.push('/programs/create')"
          color="primary"
          label="Crear programa académico"
          no-caps
          icon="add"
          push
        />
      </q-card-section>
      <q-separator inset></q-separator>
      <Table
        @request="
          ({ page, rowsPerPage, filter }) =>
            getProgramas(page, rowsPerPage, filter)
        "
        @edit="(programa) => router.push('/programs/edit/' + programa.id)"
        @delete="(programa) => deletePrograma(programa)"
        :columns="columns"
        :data="programasList"
      ></Table>
    </q-card>
  </q-layout>
</template>
<script>
import Table from "../../components/Table.vue";
import mixin from "../../mixins/mixin";
import { useProgramsStore } from "../../stores/Programas";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
export default {
  name: "ProgramasAcademicos",
  components: {
    Table,
  },
  setup() {
    const $q = useQuasar();
    const { showLoading, hideLoading, showNoty } = mixin();
    const programas = useProgramsStore();
    const router = useRouter();
    const programasList = computed(() => {
      return useProgramsStore().programas;
    });
    const columns = ref([
      { name: "id", label: "Id", field: "id" },
      { name: "facultad", label: "Facultad", field: "facultad" },
      { name: "programa", label: "Programa académico", field: "programa" },
      { name: "descripcion", label: "Descripción", field: "descripcion" },
    ]);

    const getProgramas = (page = 1, rowsPerPage = 50, filter = null) => {
      showLoading("Consultando programas académicos...");
      programas
        .getProgramas(page, rowsPerPage, filter)
        .then((response) => {
          hideLoading();
        })
        .catch((error) => {
          showNoty(
            "error",
            "Ocurrió un error al consultar los programas académicos."
          );
          hideLoading();
        });
    };

    onMounted(() => {
      getProgramas();
    });

    const deletePrograma = (element) => {
      $q.dialog({
        title: "Eliminar programa",
        message: `Esta seguro de querer eliminar el programa académico ${element.programa}?`,
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
          programas
            .deletePrograma(element.id)
            .then((response) => {
              hideLoading();
              showNoty("success", response.data.message);
              getFacultades();
            })
            .catch((error) => {
              hideLoading();
              showNoty(
                "error",
                "Ocurrió un error al eliminar el programa académico."
              );
            });
        })
        .onCancel(() => {});
    };

    return {
      router,
      columns,
      programas,
      getProgramas,
      deletePrograma,
      programasList,
    };
  },
};
</script>
