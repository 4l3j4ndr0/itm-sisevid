<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Editar ciclo</div>
      </q-card-section>
      <q-card-section>
        <q-btn
          @click="router.push('/ciclos')"
          color="primary"
          label="Regresar a ciclos"
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
          v-if="ciclo"
        >
          <q-input
            v-model="ciclo.ciclo"
            label="Nombre del ciclo"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />

          <q-input
            dense
            v-model="ciclo.desde"
            mask="date"
            label="Fecha inicio"
            lazy-rules
            :rules="[
              'date',
              (val) => (val && val.length > 0) || 'El campo es requerido.',
            ]"
          >
            <template v-slot:append>
              <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy
                  ref="desdeRef"
                  transition-show="scale"
                  transition-hide="scale"
                >
                  <q-date
                    subtitle="Fecha de inicio del ciclo"
                    v-model="ciclo.desde"
                    @input="() => desdeRef.hide()"
                  />
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>

          <q-input
            dense
            v-model="ciclo.hasta"
            mask="date"
            label="Fecha fin"
            lazy-rules
            :rules="[
              'date',
              (val) => (val && val.length > 0) || 'El campo es requerido.',
            ]"
          >
            <template v-slot:append>
              <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy
                  ref="hastaRef"
                  transition-show="scale"
                  transition-hide="scale"
                >
                  <q-date
                    subtitle="Fecha de fin del ciclo"
                    v-model="ciclo.hasta"
                    @input="() => hastaRef.hide()"
                  />
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>
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
import { useCiclosStore } from "../../stores/Ciclos";
import { ref, onMounted, computed, watch } from "vue";
import { useRouter, useRoute } from "vue-router";
export default {
  name: "CiclosEdit",
  setup(props, { root }) {
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const route = useRoute();
    const myForm = ref(null);
    const ciclos = useCiclosStore();

    const desdeRef = ref(null);
    const hastaRef = ref(null);

    const ciclo = computed(() => {
      return useCiclosStore().ciclo;
    });

    onMounted(() => {
      showLoading("Consultando ciclo...");
      ciclos.getCiclo(route.params.id).then(() => {
        hideLoading();
      });
    });

    const updateCiclo = () => {
      ciclos
        .updateCiclo(ciclo.value)
        .then(() => {
          hideLoading();
          showNoty("success", "Ciclo actualizado correctamente.");
          router.push("/ciclos");
        })
        .catch(() => {
          hideLoading();
          showNoty("error", "Error al actualizar ciclo.");
        });
    };

    const onSubmit = () => {
      myForm.value.validate().then((success) => {
        if (success) {
          showLoading("Guardando información...");
          updateCiclo();
        }
      });
    };

    return {
      myForm,
      onSubmit,
      router,
      ciclo,
      desdeRef,
      hastaRef,
    };
  },
};
</script>
