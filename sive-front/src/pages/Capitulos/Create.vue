<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Crear capítulo</div>
      </q-card-section>
      <q-card-section>
        <q-btn
          @click="router.push('/capitulos')"
          color="primary"
          label="Regresar a capítulos"
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
            v-model="codigo"
            label="Capítulo"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="descripcion"
            label="Descripción del capítulo"
            type="text-area"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />

          <div>
            <q-btn label="Crear capítulo" type="submit" color="primary" />
          </div>
        </q-form>
      </div>
    </q-card>
  </q-layout>
</template>
<script>
import mixin from "../../mixins/mixin";
import { useCapitulosStore } from "../../stores/Capitulos";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
export default {
  name: "CapitulosCreate",
  setup(props, { root }) {
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const myForm = ref(null);
    const capitulos = useCapitulosStore();

    const codigo = ref(null);
    const descripcion = ref(null);

    const createCapitulo = () => {
      capitulos
        .createCapitulo({
          codigo: codigo.value.toUpperCase(),
          descripcion: descripcion.value,
        })
        .then((response) => {
          hideLoading();
          showNoty("success", response.data.message);
          router.push("/capitulos");
        })
        .catch((error) => {
          hideLoading();
          showNoty("error", "Ocurrió un error al crear el capítulo.");
        });
    };

    const onSubmit = () => {
      myForm.value.validate().then((success) => {
        if (success) {
          showLoading("Creando capítulo...");
          createCapitulo();
        }
      });
    };

    return {
      myForm,
      onSubmit,
      router,
      codigo,
      descripcion,
    };
  },
};
</script>
