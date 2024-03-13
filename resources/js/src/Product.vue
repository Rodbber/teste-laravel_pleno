<template>
  <v-col cols="10">
    <data-table
      urlBaseData="/api/products"
      :headers="headers"
      :formatData="{
        price: (value) =>
          Number(value).toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL',
          }),
      }"
    ></data-table>
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
        { title: "Preço", key: "price", align: "center", sortable: true },
        { title: "Categoria", key: "category.name", align: "center", sortable: true },
        { title: "Ações", key: "actions", sortable: false },
      ],
    };
  },
});
</script>
