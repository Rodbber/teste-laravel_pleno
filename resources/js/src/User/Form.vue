<template>
  <div>
    <v-text-field label="Nome" v-model="form.name" autocomplete="off"></v-text-field>
    <v-text-field label="Email" v-model="form.email"></v-text-field>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  props: ["initialData"],
  emits: ["formChange"],
  data: () => {
    return {
      form: {
        name: null,
        email: null,
      },
    };
  },
  watch: {
    form:{
        handler(newValue){
            this.$emit('formChange', newValue);
        },
        deep: true,
    }
  },
  mounted(){
    if(this.initialData){
        this.form = this.initialData;
    }
  }
});
</script>
