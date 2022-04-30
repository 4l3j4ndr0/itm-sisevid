<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Editar capítulo</div>
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
        <q-form
          ref="myForm"
          @submit="onSubmit"
          class="q-gutter-md"
          v-if="capitulo"
        >
          <q-input
            v-model="capitulo.codigo"
            label="Capítulo"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="capitulo.descripcion"
            label="Descripción del capítulo"
            type="text-area"
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
import { useCapitulosStore } from "../../stores/Capitulos";
import { ref, onMounted, computed, watch } from "vue";
import { useRouter, useRoute } from "vue-router";
export default {
  name: "CapitulosEdit",
  setup(props, { root }) {
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const route = useRoute();
    const myForm = ref(null);
    const capitulos = useCapitulosStore();

    const capitulo = computed(() => {
      return useCapitulosStore().capitulo;
    });

    onMounted(() => {
      showLoading("Consultando capítulo...");
      capitulos.getCapitulo(route.params.id).then(() => {
        hideLoading();
      });
    });

    const updateCapitulo = () => {
      capitulos
        .updateCapitulo(capitulo.value)
        .then(() => {
          hideLoading();
          showNoty("success", "Capítulo actualizado correctamente.");
          router.push("/capitulos");
        })
        .catch(() => {
          hideLoading();
          showNoty("error", "Error al actualizar capítulo.");
        });
    };

    const onSubmit = () => {
      myForm.value.validate().then((success) => {
        if (success) {
          showLoading("Guardando información...");
          updateCapitulo();
        }
      });
    };

    return {
      myForm,
      onSubmit,
      router,
      capitulo,
    };
  },
};
</script>
