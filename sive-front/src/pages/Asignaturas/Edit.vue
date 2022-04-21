<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Editar asignatura</div>
      </q-card-section>
      <q-card-section>
        <q-btn
          @click="router.push('/asignaturas')"
          color="primary"
          label="Regresar a asignaturas"
          icon="arrow_back"
          no-caps
          flat
          push
        />
      </q-card-section>
      <q-separator inset></q-separator>
      <div class="q-pa-md" style="max-width: 400px" v-if="asignatura">
        <q-form ref="myForm" @submit="onSubmit" class="q-gutter-md">
          <q-select
            v-model="asignatura.programa_id_fk"
            use-input
            input-debounce="300"
            label="Seleccione la asignatura"
            :options="programasList"
            @filter="onFilterPrograma"
          >
            <template v-slot:no-option>
              <q-item>
                <q-item-section class="text-grey"> No results </q-item-section>
              </q-item>
            </template>
          </q-select>
          <q-select
            v-model="asignatura.ciclo_id_fk"
            use-input
            input-debounce="300"
            label="Seleccione el ciclo"
            :options="ciclosList"
            @filter="onFilterCiclo"
          >
            <template v-slot:no-option>
              <q-item>
                <q-item-section class="text-grey"> No results </q-item-section>
              </q-item>
            </template>
          </q-select>

          <q-input
            v-model="asignatura.asignatura"
            label="Asignatura"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="asignatura.creditos"
            label="Número de créditos"
            type="tel"
            lazy-rules
          />

          <div>
            <q-btn label="Guardar cambios" type="submit" color="primary" />
          </div>
        </q-form>
      </div>
    </q-card>
  </q-layout>
</template>
<script>
import mixin from "../../mixins/mixin";
import { useAsignaturasStore } from "../../stores/Asignaturas";
import { useProgramsStore } from "../../stores/Programas";
import { useCiclosStore } from "../../stores/Ciclos";
import { ref, onMounted, computed } from "vue";
import { useRouter, useRoute } from "vue-router";
export default {
  name: "AsignaturasEdit",
  setup(props, { root }) {
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const route = useRoute();
    const myForm = ref(null);
    const programas = useProgramsStore();
    const ciclos = useCiclosStore();
    const asignaturas = useAsignaturasStore();

    const programasList = ref([]);
    const ciclosList = ref([]);

    const asignatura = computed(() => {
      return useAsignaturasStore().asignatura;
    });

    const facultadesList = ref([]);

    onMounted(() => {
      showLoading("Cargando asignatura...");
      asignaturas.getAsignatura(route.params.id).then(() => {
        hideLoading();
      });
    });

    const updateAsignatura = () => {
      asignaturas
        .updateAsignatura(asignatura.value)
        .then(() => {
          hideLoading();
          showNoty("success", "Asignatura actualizada correctamente.");
          router.push("/asignaturas");
        })
        .catch(() => {
          hideLoading();
          showNoty("error", "Error al actualizar la asignatura.");
        });
    };

    const onSubmit = () => {
      myForm.value.validate().then((success) => {
        if (success) {
          showLoading("Guardando información...");
          updateAsignatura();
        }
      });
    };

    const onFilterPrograma = (val, update) => {
      programas.getProgramas(1, 25, val).then((response) => {
        update(() => {
          let newProgramas = [];
          response.map((programa) => {
            newProgramas.push({
              label: programa.programa,
              value: programa.id,
            });
          });
          programasList.value = newProgramas;
        });
      });
    };

    const onFilterCiclo = (val, update) => {
      ciclos.getCiclos(1, 25, val).then((response) => {
        update(() => {
          let newCiclos = [];
          response.map((ciclo) => {
            newCiclos.push({
              label: ciclo.ciclo,
              value: ciclo.id,
            });
          });
          ciclosList.value = newCiclos;
        });
      });
    };

    return {
      programasList,
      ciclosList,
      myForm,
      onSubmit,
      router,
      asignatura,
      onFilterPrograma,
      onFilterCiclo,
    };
  },
};
</script>
