<template>
  <q-card flat bordered class v-if="columns.length > 0">
    <div class="row q-gutter-md q-pt-md q-pa-sm">
      <q-input
        dense
        borderless
        debounce="300"
        v-model="filter"
        outlined
        placeholder="Buscar programa"
      >
        <template v-slot:append>
          <q-icon name="search" />
        </template>
      </q-input>
      <q-pagination
        v-model="current"
        :max="pagination.last_page"
        direction-links
        boundary-links
        icon-first="skip_previous"
        icon-last="skip_next"
        icon-prev="fast_rewind"
        icon-next="fast_forward"
      />
    </div>
    <q-list bordered class="rounded-borders q-pa-sm">
      <div class="column">
        <q-expansion-item
          v-for="program in data"
          expand-separator
          :label="`${program.programa}`"
          :caption="`Facultad: ${program.facultad}`"
          @show="getCondiciones(program)"
        >
          <q-separator />
          <div class="row q-gutter-sm q-pa-sm">
            <q-btn
              @click="$emit('edit', program)"
              icon="edit"
              no-caps
              push
              dense
              color="blue"
              round
            />
            <q-btn
              @click="$emit('delete', program)"
              icon="delete"
              no-caps
              push
              dense
              color="red"
              round
            />
          </div>
          <q-separator />
          <div class="column q-gutter-sm q-pa-sm">
            <label class="subtitle">{{
              program.condiciones && program.condiciones.length === 0
                ? `No se han configurado condiciones.`
                : "Condiciones:"
            }}</label>
            <Table
              v-if="program.condiciones && program.condiciones.length > 0"
              :hideSearch="true"
              :hidePagination="true"
              @request="null"
              @edit="
                (condicion) => router.push('/condiciones/edit/' + condicion.id)
              "
              @delete="(condicion) => deleteCondicion(condicion)"
              :columns="cols"
              :data="program.condiciones"
            ></Table>
            <q-btn
              v-if="program.condiciones && program.condiciones.length < 9"
              @click="
                router.push(
                  `/condiciones/create/${program.id}/${program.programa}`
                )
              "
              icon="add"
              no-caps
              push
              dense
              color="green"
              label="Agregar condición"
            />
          </div>
        </q-expansion-item>
      </div>
    </q-list>
  </q-card>
</template>
<script>
import mixin from "../mixins/mixin";
import { useProgramsStore } from "../stores/Programas";
import { useCondicionesStore } from "../stores/Condiciones";
import { ref, computed, toRefs, watchEffect, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
import Table from "./Table.vue";
export default {
  name: "TableProgramsComponent",
  components: {
    Table,
  },
  props: {
    data: {
      type: Array,
      required: true,
    },
    columns: {
      type: Array,
      default: [],
      required: true,
    },
    pagination: {
      type: Object,
      required: true,
    },
  },
  setup(props, { emit }) {
    const $q = useQuasar();
    const { data, columns, pagination } = toRefs(props);
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const programas = useProgramsStore();
    const condiciones = useCondicionesStore();

    const cols = ref([
      { name: "id", label: "Id", field: "id" },
      { name: "condicion", label: "Condición", field: "condicion" },
      { name: "capitulo", label: "Capítulo", field: "capitulo" },
    ]);

    const filter = ref(null);
    const current = ref(pagination.value.current_page);

    const onRequest = () => {
      emit("request", {
        page: current.value,
        rowsPerPage: 50,
        filter: filter.value,
      });
    };

    const getCondiciones = (programa) => {
      showLoading("Consultando dondiciones del programa...");
      programas
        .getCondiciones(programa.id)
        .then((condiciones) => {
          hideLoading();
          programa.condiciones = condiciones;
          data = data.map((program) => {
            if (program.id === programa.id) {
              program.condiciones = condiciones;
            }
            return program;
          });
          data = console.log("EL PROGRAM UODATE:::::", programa);
        })
        .catch((e) => {});
    };

    watchEffect(() => {
      onRequest();
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
          condiciones.deleteCondicion(element.id).then(() => {
            hideLoading();
            showNoty("Condición eliminada correctamente", "success");
          });
        })
        .onCancel(() => {});
    };

    return {
      router,
      data,
      columns,
      cols,
      pagination,
      onRequest,
      filter,
      current,
      getCondiciones,
      deleteCondicion,
    };
  },
};
</script>
