<template>
  <div class="py-10">
    <div class="py-5">
      <v-tabs v-model="tab" align-tabs="center" color="deep-purple-accent-4">
        <v-tab :value="'User'">Users</v-tab>
        <v-tab :value="'Product'">Products</v-tab>
      </v-tabs>
    </div>
    <!-- is prime -->

    <v-row justify="center">
      <v-col cols="10">
        <v-row justify="end" class="mb-5">
          <v-col cols="auto" align-self="center" title="Adicionar novo">
            <v-btn
              density="compact"
              color="#5865f2"
              @click="isPrime"
            >Verificar</v-btn>
          </v-col>
          <v-col cols="3">
            <v-text-field
              density="compact"
              variant="solo"
              label="Verificar numero primo"
              single-line
              hide-details
              v-model="number"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row justify="end" class="mb-5">
            {{ responseIsPrime }}
        </v-row>
      </v-col>
    </v-row>

    <v-row justify="center">
      <component :is="tab"></component>
    </v-row>
  </div>
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
import User from "./src/User.vue";
import Product from "./src/Product.vue";
import axios from "axios";

export default defineComponent({
  components: { User, Product },
  data: () => ({
    tab: "User",
    responseIsPrime: null,
    number: null,
  }),
  methods:{
    isPrime(){
        axios
        .get(`/api/is-prime/${this.number}`, this.form)
        .then((r) => {
          this.responseIsPrime = r.data.message
        })
        .catch((e) => {
          console.log(e);
        });
    }
  },
  watch: {
    tab(newValue) {},
  },
});
</script>
