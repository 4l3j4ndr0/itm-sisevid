<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Crear facultad</div>
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
        <q-form ref="myForm" @submit="onSubmit" class="q-gutter-md">
          <q-select v-model="decano_id_fk" :options="decanos" label="Decano" />
          <q-input
            v-model="facultad"
            label="Nombre de la facultad"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />

          <div>
            <q-btn label="Crear facultad" type="submit" color="primary" />
          </div>
        </q-form>
      </div>
    </q-card>
  </q-layout>
</template>
<script>
import mixin from "../../mixins/mixin";
import { useFacultadesStore } from "../../stores/Facultades";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
export default {
  name: "FacultadCreate",
  setup(props, { root }) {
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const myForm = ref(null);
    const facultades = useFacultadesStore();

    const decano_id_fk = ref(null);
    const facultad = ref(null);

    const decanos = computed(() => {
      return useFacultadesStore().decanos;
    });

    const createFacultad = () => {
      facultades
        .createFacultad({
          decano_id_fk: decano_id_fk.value.value,
          facultad: facultad.value.toUpperCase(),
        })
        .then((response) => {
          hideLoading();
          showNoty("success", response.data.message);
          router.push("/facultades");
        })
        .catch((error) => {
          hideLoading();
          showNoty("error", "Ocurrió un error al crear la facultad.");
        });
    };

    onMounted(() => {
      facultades.getDecanos();
    });

    const onSubmit = () => {
      myForm.value.validate().then((success) => {
        if (success) {
          showLoading("Creando facultad...");
          createFacultad();
        }
      });
    };

    return {
      decanos,
      myForm,
      onSubmit,
      router,
      decano_id_fk,
      facultad,
    };
  },
};
</script>
