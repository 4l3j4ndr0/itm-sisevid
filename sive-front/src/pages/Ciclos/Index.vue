<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Ciclos</div>
      </q-card-section>
      <q-card-section>
        <q-btn
          @click="$router.push('/ciclos/create')"
          color="primary"
          label="Crear ciclo"
          no-caps
          icon="add"
          push
        />
      </q-card-section>
      <q-separator inset></q-separator>
      <Table
        @request="
          ({ page, rowsPerPage, filter }) =>
            getCiclos(page, rowsPerPage, filter)
        "
        @edit="(ciclo) => router.push('/ciclos/edit/' + ciclo.id)"
        @delete="(ciclo) => deleteCiclo(ciclo)"
        :columns="columns"
        :data="ciclos"
      ></Table>
    </q-card>
  </q-layout>
</template>
<script>
import Table from "../../components/Table.vue";
import mixin from "../../mixins/mixin";
import { useCiclosStore } from "../../stores/Ciclos";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
export default {
  name: "Ciclos",
  components: {
    Table,
  },
  setup() {
    const $q = useQuasar();
    const { showLoading, hideLoading, showNoty } = mixin();
    const ciclo = useCiclosStore();
    const router = useRouter();
    const ciclos = computed(() => {
      return useCiclosStore().ciclos;
    });
    const columns = ref([
      { name: "id", label: "Id", field: "id" },
      { name: "ciclo", label: "Ciclo", field: "ciclo" },
      { name: "desde", label: "Desde", field: "desde" },
      { name: "hasta", label: "Hasta", field: "hasta" },
    ]);

    const getCiclos = (page = 1, rowsPerPage = 50, filter = null) => {
      showLoading("Consultando ciclos...");
      ciclo
        .getCiclos(page, rowsPerPage, filter)
        .then((response) => {
          hideLoading();
        })
        .catch((error) => {
          showNoty("error", "Ocurrió un error al consultar los ciclos.");
          hideLoading();
        });
    };

    onMounted(() => {
      getCiclos();
    });

    const deleteCiclo = (element) => {
      $q.dialog({
        title: "Eliminar ciclo",
        message: `Esta seguro de querer eliminar el ciclo ${element.ciclo}?`,
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
          showLoading("Eliminando ciclo...");
          ciclo
            .deleteCiclo(element.id)
            .then((response) => {
              hideLoading();
              showNoty("success", response.data.message);
              getCiclos();
            })
            .catch((error) => {
              hideLoading();
              showNoty("error", "Ocurrió un error al eliminar el ciclo.");
            });
        })
        .onCancel(() => {});
    };

    return {
      router,
      columns,
      ciclos,
      getCiclos,
      deleteCiclo,
    };
  },
};
</script>
