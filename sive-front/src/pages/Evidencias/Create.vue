<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Crear evidencia</div>
      </q-card-section>
      <q-card-section>
        <q-btn
          @click="router.push('/evidencias')"
          color="primary"
          label="Regresar a evidencias"
          icon="arrow_back"
          no-caps
          flat
          push
        />
      </q-card-section>
      <q-separator inset></q-separator>
      <div class="q-pa-md" style="max-width: 400px">
        <div class="q-pa-md">
          <q-uploader
            label="Cargar evidencia"
            auto-upload
            @added="(file) => addEvidencia(file)"
            max-files="1"
          />
        </div>
        <q-form ref="myForm" @submit="onSubmit" class="q-gutter-md">
          <q-select
            v-model="tipo_evidencia_id_fk"
            :options="tipoEvidencias"
            label="Tipo de evidencia"
          />
          <q-input
            v-model="autor"
            label="Autor"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="codigo"
            label="Código"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="titulo"
            label="Título"
            type="tel"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input v-model="descripcion" label="Descripción" type="textarea" />
          <div>
            <q-btn label="Crear evidencia" type="submit" color="primary" />
          </div>
        </q-form>
      </div>
    </q-card>
  </q-layout>
</template>
<script>
import mixin from "../../mixins/mixin";
import { useEvidenciaStore } from "../../stores/Evidencia";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
export default {
  name: "EvidenciasCreate",
  setup(props, { root }) {
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const myForm = ref(null);
    const evidencia = useEvidenciaStore();

    const tipo_evidencia_id_fk = ref(null);
    const autor = ref(null);
    const codigo = ref(null);
    const titulo = ref(null);
    const descripcion = ref(null);
    const evidenciaFile = ref(null);
    const file = ref(null);

    const tipoEvidencias = computed(() => {
      return useEvidenciaStore().tipoEvidencias;
    });

    const createEvidencia = async () => {
      const url_evidencia = await evidencia.uploadFile(
        evidenciaFile.value,
        file.value.name
      );
      evidencia
        .createEvidencia({
          tipo_evidencia_id_fk: tipo_evidencia_id_fk.value.value,
          autor: autor.value,
          codigo: codigo.value,
          titulo: titulo.value,
          descripcion: descripcion.value,
          url_evidencia,
        })
        .then((response) => {
          hideLoading();
          showNoty("success", response.data.message);
          router.push("/evidencias");
        })
        .catch((error) => {
          hideLoading();
          showNoty("error", "Ocurrió un error al crear la evidencia.");
        });
    };

    const addEvidencia = (files) => {
      file.value = files[0];
      const formData = new FormData();
      formData.append(file.value.name, file.value);
      evidenciaFile.value = formData;
    };

    onMounted(() => {
      evidencia.getTiposEvidencia();
    });

    const onSubmit = () => {
      myForm.value.validate().then((success) => {
        if (success) {
          showLoading("Creando evidencia...");
          createEvidencia();
        }
      });
    };

    return {
      tipoEvidencias,
      myForm,
      tipo_evidencia_id_fk,
      autor,
      codigo,
      titulo,
      descripcion,
      onSubmit,
      router,
      addEvidencia,
      file,
      evidenciaFile,
    };
  },
};
</script>
