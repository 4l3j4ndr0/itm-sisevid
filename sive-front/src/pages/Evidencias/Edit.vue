<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Editar evidencia</div>
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
      <div class="q-pa-md" style="max-width: 400px" v-if="evidencia">
        <div class="q-pa-md">
          <q-uploader
            label="Adjuntar evidencia"
            @added="(file) => addEvidencia(file)"
            max-files="1"
          >
            <template v-slot:list="scope">
              <q-item>
                <q-item-section>
                  <q-item-label class="full-width ellipsis">
                    <a :href="evidencia.url_evidencia">{{
                      evidencia.url_evidencia
                    }}</a>
                  </q-item-label>
                </q-item-section>
              </q-item>
            </template>
          </q-uploader>
        </div>
        <q-form ref="myForm" @submit="onSubmit" class="q-gutter-md">
          <q-select
            v-model="evidencia.tipo_evidencia_id_fk"
            :options="tipoEvidencias"
            label="Tipo de evidencia"
          />
          <q-input
            v-model="evidencia.autor"
            label="Autor"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="evidencia.codigo"
            label="Código"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-input
            v-model="evidencia.titulo"
            label="Título"
            type="tel"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />
          <q-select
            v-model="usuariosSelect"
            label="Asociar usuarios"
            use-input
            use-chips
            multiple
            input-debounce="300"
            :options="usuarios"
            @filter="filterUsers"
          />
          <q-select
            v-model="asignaturasSelect"
            label="Asociar asignaturas"
            use-input
            use-chips
            multiple
            input-debounce="300"
            :options="asignaturas"
            @filter="filterAsignaturas"
          />
          <q-input
            v-model="evidencia.descripcion"
            label="Descripción"
            type="textarea"
          />
          <div>
            <q-btn label="Guardar cambios" type="submit" color="primary" />
          </div>
        </q-form>
      </div>
      <div></div>
    </q-card>
  </q-layout>
</template>
<script>
import mixin from "../../mixins/mixin";
import { useEvidenciaStore } from "../../stores/Evidencia";
import { useUserStore } from "../../stores/User";
import { useAsignaturasStore } from "../../stores/Asignaturas";
import { ref, onMounted, computed } from "vue";
import { useRouter, useRoute } from "vue-router";
export default {
  name: "EvidenciasEdit",
  setup(props, { root }) {
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const route = useRoute();
    const evidencias = useEvidenciaStore();
    const user = useUserStore();
    const asignatura = useAsignaturasStore();
    const myForm = ref(null);
    const file = ref(null);
    const evidenciaFile = ref(null);
    const usuarios = ref([]);
    const asignaturas = ref([]);
    const asignaturasSelect = ref([]);
    const usuariosSelect = ref([]);

    const evidencia = computed(() => {
      return useEvidenciaStore().evidencia;
    });

    const tipoEvidencias = computed(() => {
      return useEvidenciaStore().tipoEvidencias;
    });

    const getUsers = (
      page = 1,
      rowsPerPage = 50,
      filter = null,
      onlyStudentTeacher = true
    ) => {
      user
        .getUsers(page, rowsPerPage, filter, onlyStudentTeacher)
        .then((users) => {
          usuarios.value = [];
          users.forEach((user) => {
            usuarios.value.push({
              label: `${user.nombre} ${user.apellidos} (${user.tipo})`,
              value: user.id,
            });
          });
        });
    };

    const filterUsers = (val, update) => {
      update(() => {
        getUsers(1, 50, val);
      });
    };

    const getAsignaturas = (page = 1, rowsPerPage = 50, filter = null) => {
      asignatura.getAsignaturas(page, rowsPerPage, filter).then((data) => {
        asignaturas.value = [];
        data.forEach((asignatura) => {
          asignaturas.value.push({
            label: asignatura.asignatura,
            value: asignatura.id,
          });
        });
      });
    };

    const filterAsignaturas = (val, update) => {
      update(() => {
        getAsignaturas(1, 50, val);
      });
    };

    const updateEvidencia = async () => {
      if (file.value) {
        const url_evidencia = await evidencias.uploadFile(
          evidenciaFile.value,
          file.value.name
        );
      }
      evidencias
        .updateEvidencia(
          evidencia.value,
          usuariosSelect.value,
          asignaturasSelect.value
        )
        .then((response) => {
          hideLoading();
          showNoty("success", response.data.message);
          router.push("/evidencias");
        })
        .catch((error) => {
          console.log("ERROR:::::", error);
          hideLoading();
          showNoty("error", "Ocurrió un error al actualizar la evidencia.");
        });
    };

    const addEvidencia = (files) => {
      file.value = files[0];
      const formData = new FormData();
      formData.append(file.value.name, file.value);
      evidenciaFile.value = formData;
    };

    onMounted(() => {
      showLoading("Cargando la evidencia...");
      getUsers();
      getAsignaturas();
      evidencias
        .getEvidencia(route.params.id)
        .then((e) => {
          usuariosSelect.value = e.usuariosSelect;
          asignaturasSelect.value = e.asignaturasSelect;
          hideLoading();
        })
        .catch((error) => {
          console.log("ERRRO:::::", error);
          hideLoading();
          showNoty("error", "Ocurrió un error al cargar la evidencia.");
        });
      evidencias.getTiposEvidencia();
    });

    const onSubmit = () => {
      myForm.value.validate().then((success) => {
        if (success) {
          showLoading("Actualizando evidencia...");
          updateEvidencia();
        }
      });
    };

    return {
      tipoEvidencias,
      myForm,
      filterUsers,
      filterAsignaturas,
      usuariosSelect,
      usuarios,
      asignaturas,
      asignaturasSelect,
      evidencia,
      onSubmit,
      router,
      addEvidencia,
    };
  },
};
</script>
