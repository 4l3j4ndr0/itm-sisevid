<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Editar programa académico</div>
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
      <div class="q-pa-md" style="max-width: 400px" v-if="programa">
        <q-form ref="myForm" @submit="onSubmit" class="q-gutter-md">
          <q-select
            v-model="programa.facultad_id_fk"
            use-input
            input-debounce="300"
            label="Seleccione la facultad"
            :options="facultadesList"
            @filter="onFilter"
            style="width: 250px"
          >
            <template v-slot:no-option>
              <q-item>
                <q-item-section class="text-grey"> No results </q-item-section>
              </q-item>
            </template>
          </q-select>
          <q-input
            v-model="programa.programa"
            label="Nombre del programa"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />

          <q-input
            v-model="programa.descripcion"
            label="Descripción del programa"
            type="textarea"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />

          <div>
            <q-btn
              label="Editar programa académico"
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
import { useRouter, useRoute } from "vue-router";
export default {
  name: "ProgramsEdit",
  setup(props, { root }) {
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const route = useRoute();
    const myForm = ref(null);
    const programas = useProgramsStore();
    const facultades = useFacultadesStore();

    const programa = computed(() => {
      return useProgramsStore().programa;
    });

    const facultadesList = ref([]);

    onMounted(() => {
      showLoading("Cargando programa académico...");
      programas.getProgram(route.params.id).then(() => {
        hideLoading();
      });
    });

    const updatePrograma = () => {
      programas
        .updatePrograma(programa.value)
        .then(() => {
          hideLoading();
          showNoty("success", "Programa actualizado correctamente.");
          router.push("/programs");
        })
        .catch(() => {
          hideLoading();
          showNoty("error", "Error al actualizar el programa.");
        });
    };

    const onSubmit = () => {
      myForm.value.validate().then((success) => {
        if (success) {
          showLoading("Guardando información...");
          updatePrograma();
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
      programa,
      onFilter,
    };
  },
};
</script>
