<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Crear condición</div>
      </q-card-section>
      <q-card-section>
        <q-btn
          @click="router.push('/programs')"
          color="primary"
          label="Regresar a programas"
          icon="arrow_back"
          no-caps
          flat
          push
        />
      </q-card-section>
      <q-separator inset></q-separator>
      <div class="q-pa-md" style="max-width: 400px">
        <q-form ref="myForm" @submit="onSubmit" class="q-gutter-md">
          <q-input
            v-model="programa"
            label="Programa académico"
            lazy-rules
            readonly
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-select
            v-model="capitulo_id_fk"
            use-input
            input-debounce="300"
            label="Seleccione el capítulo"
            :options="capitulosList"
            @filter="onFilterCapitulos"
          >
            <template v-slot:no-option>
              <q-item>
                <q-item-section class="text-grey"> No results </q-item-section>
              </q-item>
            </template>
          </q-select>
          <q-input
            v-model="condicion"
            label="Nombre de la condición"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />

          <q-input
            v-model="descripcion"
            label="Descripción de la condición"
            type="textarea"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />

          <div>
            <q-btn label="Crear condición" type="submit" color="primary" />
          </div>
        </q-form>
      </div>
    </q-card>
  </q-layout>
</template>
<script>
import mixin from "../../mixins/mixin";
import { useProgramsStore } from "../../stores/Programas";
import { useCapitulosStore } from "../../stores/Capitulos";
import { useCondicionesStore } from "../../stores/Condiciones";
import { ref, onMounted, computed } from "vue";
import { useRouter, useRoute } from "vue-router";
export default {
  name: "CondicionesCreate",
  setup(props, { root }) {
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const route = useRoute();
    const myForm = ref(null);
    const programas = useProgramsStore();
    const capitulos = useCapitulosStore();
    const condiciones = useCondicionesStore();

    const programa_academico_id_fk = ref(null);
    const programa = ref(null);
    const capitulosList = ref([]);
    const capitulo_id_fk = ref(null);
    const condicion = ref(null);
    const descripcion = ref(null);

    onMounted(() => {
      programa_academico_id_fk.value = route.params.program_id;
      programa.value = route.params.program_name;
    });

    const createCondicion = () => {
      condiciones
        .createCondicion({
          programa_academico_id_fk: programa_academico_id_fk.value,
          capitulo_id_fk: capitulo_id_fk.value.value,
          condicion: condicion.value.toUpperCase(),
          descripcion: descripcion.value,
        })
        .then((response) => {
          hideLoading();
          showNoty("success", response.data.message);
          router.push("/programs");
        })
        .catch((error) => {
          hideLoading();
          showNoty("error", "Ocurrió un error al crear la condición.");
        });
    };

    const onSubmit = () => {
      myForm.value.validate().then((success) => {
        if (success) {
          showLoading("Creando condición...");
          createCondicion();
        }
      });
    };

    const onFilterCapitulos = (val, update) => {
      capitulos.getCapitulos(1, 25, val).then((response) => {
        update(() => {
          let newCapitulos = [];
          response.map((capitulo) => {
            newCapitulos.push({
              label: capitulo.capitulo,
              value: capitulo.id,
            });
          });
          capitulosList.value = newCapitulos;
        });
      });
    };

    return {
      capitulosList,
      myForm,
      onSubmit,
      router,
      programa,
      capitulo_id_fk,
      condicion,
      descripcion,
      onFilterCapitulos,
    };
  },
};
</script>
