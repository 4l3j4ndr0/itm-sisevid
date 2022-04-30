<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Editar condición</div>
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
      <div class="q-pa-md" style="max-width: 400px" v-if="condicion">
        <q-form ref="myForm" @submit="onSubmit" class="q-gutter-md">
          <q-input
            v-model="condicion.capitulo_id_fk"
            label="Capítulo"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />

          <q-input
            v-model="condicion.condicion"
            label="Descripción del programa"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />

          <q-input
            v-model="condicion.descripcion"
            label="Descripción del programa"
            type="textarea"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />

          <div>
            <q-btn label="Guaardar cambios" type="submit" color="primary" />
          </div>
        </q-form>
      </div>
    </q-card>
  </q-layout>
</template>
<script>
import mixin from "../../mixins/mixin";
import { useCapitulosStore } from "../../stores/Capitulos";
import { useCondicionesStore } from "../../stores/Condiciones";
import { ref, onMounted, computed } from "vue";
import { useRouter, useRoute } from "vue-router";
export default {
  name: "CondicionEdit",
  setup(props, { root }) {
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const route = useRoute();
    const myForm = ref(null);
    const capitulos = useCapitulosStore();
    const condiciones = useCondicionesStore();

    const condicion = computed(() => {
      return useCondicionesStore().condicion;
    });

    const capitulosList = ref([]);

    onMounted(() => {
      showLoading("Cargando condición...");
      condiciones.getCondicion(route.params.id).then(() => {
        hideLoading();
      });
    });

    const updateCondicion = () => {
      condiciones
        .updateCondicion(condicion.value)
        .then(() => {
          hideLoading();
          showNoty("success", "Condición actualizada correctamente.");
          router.push("/condiciones");
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
          updateCondicion();
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
      condicion,
      onFilterCapitulos,
    };
  },
};
</script>
