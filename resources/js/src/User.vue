<template>
  <v-col cols="10">
    <data-table urlBaseData="/api/users" :headers="headers"></data-table>
  </v-col>
</template>

  <style>
.flex {
  display: flex;
  flex-direction: row;
}

.flex div {
  margin-left: 10px;
  margin-right: 10px;
}
</style>

  <script lang="ts">
import { defineComponent } from "vue";
import DataTable from "./components/DataTable.vue";

export default defineComponent({
  components: { DataTable },
  data: () => {
    return {
      headers: [
        {
          title: "Nome",
          align: "center",
          sortable: true,
          key: "name",
        },
        { title: "Email", key: "email", align: "center", sortable: true },
        { title: "Ações", key: "actions", sortable: false },
      ],
    };
  },
});
</script>
