<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Crear programa académico</div>
      </q-card-section>
      <q-card-section>
        <q-btn
          @click="router.push('/programs')"
          color="primary"
          label="Regresar a programas académicos"
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
            v-model="facultad_id_fk"
            use-input
            input-debounce="300"
            label="Seleccione la facultad"
            :options="facultadesList"
            @filter="onFilter"
          >
            <template v-slot:no-option>
              <q-item>
                <q-item-section class="text-grey"> No results </q-item-section>
              </q-item>
            </template>
          </q-select>
          <q-input
            v-model="programa"
            label="Nombre del programa"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />

          <q-input
            v-model="descripcion"
            label="Descripción del programa"
            type="textarea"
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
import { useProgramsStore } from "../../stores/Programas";
import { useFacultadesStore } from "../../stores/Facultades";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
export default {
  name: "ProgramsCreate",
  setup(props, { root }) {
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const myForm = ref(null);
    const programas = useProgramsStore();
    const facultades = useFacultadesStore();

    const facultad_id_fk = ref(null);
    const programa = ref(null);
    const descripcion = ref(null);

    const facultadesList = ref([]);

    const createProgram = () => {
      programas
        .createProgram({
          facultad_id_fk: facultad_id_fk.value.value,
          programa: programa.value.toUpperCase(),
          descripcion: descripcion.value,
        })
        .then((response) => {
          hideLoading();
          showNoty("success", response.data.message);
          router.push("/programs");
        })
        .catch((error) => {
          hideLoading();
          showNoty("error", "Ocurrió un error al crear el programa.");
        });
    };

    onMounted(() => {});

    const onSubmit = () => {
      myForm.value.validate().then((success) => {
        if (success) {
          showLoading("Creando programa académico...");
          createProgram();
        }
      });
    };

    const onFilter = (val, update) => {
      facultades.getFacultades(1, 25, val).then((response) => {
        update(() => {
          let newFacultades = [];
          response.map((facultad) => {
            newFacultades.push({
              label: facultad.facultad,
              value: facultad.id,
            });
          });
          facultadesList.value = newFacultades;
        });
      });
    };

    return {
      facultadesList,
      myForm,
      onSubmit,
      router,
      facultad_id_fk,
      programa,
      descripcion,
      onFilter,
    };
  },
};
</script>
