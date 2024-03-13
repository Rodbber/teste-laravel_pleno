<template>
  <div>
    <v-text-field
      label="Nome"
      v-model="form.name"
      autocomplete="off"
    ></v-text-field>
    <v-text-field
      label="Preço"
      v-model="form.price"
      autocomplete="off"
    ></v-text-field>
    <v-select
      :items="categories"
      density="compact"
      label="Selecione a categoria"
      item-title="name"
      item-value="id"
      v-model="form.category_id"
    ></v-select>
  </div>
</template>

  <script lang="ts">
import axios from "axios";
import { defineComponent } from "vue";

export default defineComponent({
  props: ["initialData"],
  emits: ["formChange"],
  data: () => {
    return {
      form: {
        name: null,
        price: null,
        category_id: null,
      },
      categories: [],
    };
  },
  methods: {
    getData() {
      axios.get("/api/categories").then((r) => {
        this.categories = r.data.data;
      });
    },
  },
  watch: {
    form: {
      handler(newValue) {
        this.$emit("formChange", newValue);
      },
      deep: true,
    },
  },
  mounted() {
    if (this.initialData) {
      this.form = this.initialData;
    }
    this.getData();
  },
});
</script>
