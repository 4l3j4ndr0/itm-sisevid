<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Editar facultad</div>
      </q-card-section>
      <q-card-section>
        <q-btn
          @click="router.push('/facultades')"
          color="primary"
          label="Regresar a facultades"
          icon="arrow_back"
          no-caps
          flat
          push
        />
      </q-card-section>
      <q-separator inset></q-separator>
      <div class="q-pa-md" style="max-width: 400px">
        <q-form
          ref="myForm"
          @submit="onSubmit"
          class="q-gutter-md"
          v-if="facultad"
        >
          <q-select
            v-model="facultad.decano_id_fk"
            :options="decanos"
            label="Seleccione el decano"
          />
          <q-input
            v-model="facultad.facultad"
            label="Nombre"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
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
import { useFacultadesStore } from "../../stores/Facultades";
import { ref, onMounted, computed, watch } from "vue";
import { useRouter, useRoute } from "vue-router";
export default {
  name: "FacultadEdit",
  setup(props, { root }) {
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const route = useRoute();
    const myForm = ref(null);
    const facultades = useFacultadesStore();

    const decanos = computed(() => {
      return useFacultadesStore().decanos;
    });

    const facultad = computed(() => {
      return useFacultadesStore().facultad;
    });

    onMounted(() => {
      showLoading("Consultando facultad...");
      facultades.getDecanos();
      facultades.getFacultad(route.params.id).then(() => {
        hideLoading();
      });
    });

    const updateFacultad = () => {
      facultades
        .updateFacultad(facultad.value)
        .then(() => {
          hideLoading();
          showNoty("success", "Facultad actualizada correctamente.");
          router.push("/facultades");
        })
        .catch(() => {
          hideLoading();
          showNoty("error", "Error al actualizar usuario");
        });
    };

    const onSubmit = () => {
      myForm.value.validate().then((success) => {
        if (success) {
          showLoading("Guardando información...");
          updateFacultad();
        }
      });
    };

    return {
      myForm,
      onSubmit,
      router,
      facultad,
      decanos,
    };
  },
};
</script>
