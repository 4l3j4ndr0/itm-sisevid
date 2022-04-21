<template>
  <q-layout view="lHh lpr lFf" class="shadow-2 rounded-borders">
    <q-card flat bordered class>
      <q-card-section>
        <div class="text-h6">Crear ciclo</div>
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
        <q-form ref="myForm" @submit="onSubmit" class="q-gutter-md">
          <q-input
            v-model="ciclo"
            label="Nombre del ciclo"
            lazy-rules
            :rules="[(val) => (val && val.length > 0) || 'Campo requerido.']"
          />

          <q-input
            dense
            v-model="desde"
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
                    v-model="desde"
                    @input="() => desdeRef.hide()"
                  />
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>

          <q-input
            dense
            v-model="hasta"
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
                    v-model="hasta"
                    @input="() => hastaRef.hide()"
                  />
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>

          <div>
            <q-btn label="Crear ciclo" type="submit" color="primary" />
          </div>
        </q-form>
      </div>
    </q-card>
  </q-layout>
</template>
<script>
import mixin from "../../mixins/mixin";
import { useCiclosStore } from "../../stores/Ciclos";
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import moment from "moment";
export default {
  name: "FacultadCreate",
  setup(props, { root }) {
    const { showLoading, hideLoading, showNoty } = mixin();
    const router = useRouter();
    const myForm = ref(null);
    const ciclos = useCiclosStore();

    const desdeRef = ref(null);
    const hastaRef = ref(null);

    const ciclo = ref(null);
    const desde = ref(null);
    const hasta = ref(null);

    const createCiclo = () => {
      ciclos
        .createCiclo({
          ciclo: ciclo.value,
          desde: moment(desde.value).format("YYYY-MM-DD 00:00:00"),
          hasta: moment(hasta.value).format("YYYY-MM-DD 23:59:59"),
        })
        .then((response) => {
          hideLoading();
          showNoty("success", response.data.message);
          router.push("/ciclos");
        })
        .catch((error) => {
          hideLoading();
          showNoty("error", "Ocurrió un error al crear el ciclo.");
        });
    };

    const onSubmit = () => {
      myForm.value.validate().then((success) => {
        if (success) {
          showLoading("Creando ciclo...");
          createCiclo();
        }
      });
    };

    return {
      myForm,
      onSubmit,
      router,
      ciclo,
      desde,
      hasta,
      desdeRef,
      hastaRef,
    };
  },
};
</script>
