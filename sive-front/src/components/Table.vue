<template>
  <q-card flat bordered class v-if="columns.length > 0">
    <q-card-section>
      <q-table
        v-model:pagination="pagination"
        :rows="data"
        row-key="name"
        :filter="filter"
        @request="onRequest"
        @row-click="onRowClick"
      >
        <template v-slot:no-data="{ filter }">
          <div class="full-width row flex-center text-red q-gutter-sm">
            <q-icon size="2em" name="sentiment_dissatisfied" />
            <span>
              {{
                filter
                  ? `No se logró encontrar información con el filtro ${filter}`
                  : "No encontramos información."
              }}
            </span>
          </div>
        </template>
        <template v-slot:top-right="props">
          <div class="row q-gutter-md q-pt-md">
            <q-input
              dense
              borderless
              debounce="300"
              v-model="filter"
              outlined
              placeholder="Buscar"
            >
              <template v-slot:append>
                <q-icon name="search" />
              </template>
            </q-input>
          </div>
        </template>
      </q-table>
    </q-card-section>
  </q-card>
</template>
<script>
export default {
  name: "TableComponent",
  props: {
    data: {
      type: Array,
      required: true,
    },
    columns: {
      type: Array,
      default: [],
      required: true,
    },
  },
  data() {
    return {
      filter: "",
      pagination: {
        page: 1,
        rowsPerPage: 50,
      },
    };
  },
  watch: {
    filter() {
      this.onRequest();
    },
  },
  methods: {
    onRequest(props) {
      const { page, rowsPerPage } = props ? props.pagination : this.pagination;
      this.$emit("request", { page, rowsPerPage, filter: this.filter });
    },
    onRowClick(evt, row) {
      this.$emit("rowClick", row.id);
    },
  },
};
</script>
