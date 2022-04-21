<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Crear asignatura</div>
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
      <div class="q-pa-md" style="max-width: 400px">
        <q-form ref="myForm" @submit="onSubmit" class="q-gutter-md">
          <q-select
            v-model="programa_id_fk"
            use-input
            input-debounce="300"
            label="Seleccione el programa"
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
            v-model="ciclo_id_fk"
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
            v-model="asignatura"
            label="Nombre de la asignatura"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="creditos"
            label="Número de créditos"
            type="tel"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />

          <div>
            <q-btn
              label="Crear programa académico"
              type="submit"
              color="primary"
            />
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
import { useRouter } from "vue-router";
export default {
  name: "AsignaturasCreate",
  setup(props, { root }) {
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const myForm = ref(null);
    const programas = useProgramsStore();
    const ciclos = useCiclosStore();
    const asignaturas = useAsignaturasStore();

    const programa_id_fk = ref(null);
    const ciclo_id_fk = ref(null);
    const asignatura = ref(null);
    const creditos = ref(null);

    const programasList = ref([]);
    const ciclosList = ref([]);

    const createAsignatura = () => {
      asignaturas
        .createAsignatura({
          programa_id_fk: programa_id_fk.value.value,
          ciclo_id_fk: ciclo_id_fk.value.value,
          asignatura: asignatura.value.toUpperCase(),
          creditos: parseInt(creditos.value),
        })
        .then((response) => {
          hideLoading();
          showNoty("success", response.data.message);
          router.push("/asignaturas");
        })
        .catch((error) => {
          hideLoading();
          showNoty("error", "Ocurrió un error al crear la asignatura.");
        });
    };

    const onSubmit = () => {
      myForm.value.validate().then((success) => {
        if (success) {
          showLoading("Creando asignatura...");
          createAsignatura();
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
      ciclo_id_fk,
      programa_id_fk,
      asignatura,
      creditos,
      onFilterCiclo,
      onFilterPrograma,
    };
  },
};
</script>
