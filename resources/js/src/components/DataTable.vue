<template>
  <div>
    <v-row justify="end" class="mb-5">
      <v-col cols="auto" align-self="center" title="Adicionar novo">
        <v-btn
          density="compact"
          icon="mdi-plus"
          color="#5865f2"
          @click="modalActiveNew = true"
        ></v-btn>
      </v-col>
      <v-col cols="3" v-if="urlBaseData == '/api/products'">
        <v-text-field
          density="compact"
          variant="solo"
          label="Buscar preço maior que:"
          single-line
          hide-details
          v-model="value"
          @input="priceGreaterThan"
          type="number"
        ></v-text-field>
      </v-col>
      <v-col cols="3">
        <v-text-field
          density="compact"
          variant="solo"
          label="Search"
          append-inner-icon="mdi-magnify"
          single-line
          hide-details
          v-model="search"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-data-table-server
      v-model:items-per-page="itemsPerPage"
      :search="search"
      :headers="headers"
      :items-length="totalItems"
      :items="serverItems"
      :loading="loading"
      item-value="name"
      @update:options="loadItems"
    >
      <template v-slot:item.price="{ item }">
        <span v-if="item.price !== null">
          {{ formatData.price(item.price) }}
        </span>
        <span v-else>-</span>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon
          size="small"
          class="me-2"
          @click="openModalChangeFileName(item)"
        >
          mdi-pencil
        </v-icon>
        <v-icon size="small" @click="openModalExclude(item)">
          mdi-delete
        </v-icon>
      </template>
    </v-data-table-server>
    <modal-vue
      @close="closeModalExclude"
      :is-active="modalActiveExclude"
      @confirm="deleteFile"
    >
      <template #modal-body>
        <div>
          <span
            >Do you confirm that you want to remove
            {{ selectedItemExclude.file_name }}?</span
          >
        </div>
      </template>
    </modal-vue>
    <modal-vue
      @close="closeModalRename"
      :is-active="modalActiveUpdate"
      @confirm="updateData"
    >
      <template #modal-body>
        <component
          :is="urlBaseData == '/api/users' ? 'UserForm' : 'ProductForm'"
          :initialData="selectedItemUpdate"
          @formChange="formChange"
        ></component>
      </template>
    </modal-vue>
    <modal-vue
      @close="modalActiveNew = false"
      :is-active="modalActiveNew"
      @confirm="newData"
    >
      <template #modal-body>
        <component
          :is="urlBaseData == '/api/users' ? 'UserForm' : 'ProductForm'"
          @formChange="formChange"
        ></component>
      </template>
    </modal-vue>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import axios from "axios";
import ModalVue from "./Modal.vue";

import UserForm from "../User/Form.vue";
import ProductForm from "../Product/Form.vue";

export default defineComponent({
  props: ["urlBaseData", "headers", "formatData"],
  components: { ModalVue, UserForm, ProductForm },
  data: () => ({
    // modal exclude
    modalActiveExclude: false,
    selectedItemExclude: null,

    // modal edit
    modalActiveUpdate: false,
    selectedItemUpdate: null,

    // modal novo
    modalActiveNew: false,
    itemsPerPage: 10,
    loading: true,
    totalItems: 0,
    search: "",
    form: {},
    serverItems: [],
    value: null,
  }),
  methods: {
    formChange(newForm) {
      this.form = newForm;
    },
    openModalChangeFileName(item: any) {
      this.selectedItemUpdate = { ...item };
      this.modalActiveUpdate = true;
    },
    closeModalRename() {
      this.modalActiveUpdate = false;
    },
    openModalExclude(item: any) {
      this.selectedItemExclude = item;
      this.modalActiveExclude = true;
    },
    closeModalExclude() {
      this.modalActiveExclude = false;
    },
    deleteFile() {
      axios
        .delete(this.urlBaseData + "/" + this.selectedItemExclude.id)
        .then((r) => {
          this.loadItems({ page: this.page, itemsPerPage: this.itemsPerPage });
        })
        .catch((e) => {
          console.log(e);
        });
    },
    getData({ page = 1, itemsPerPage = 10, sortBy = null }) {
      return axios.get(this.urlBaseData, {
        params: {
          page,
          itemsPerPage,
          sortBy,
          search: this.search,
          value: this.value,
        },
      });
    },
    loadItems({ page, itemsPerPage, sortBy }) {
      this.loading = true;
      this.getData({ page, itemsPerPage, sortBy, search: this.search }).then(
        ({ data: { data: items, total } }) => {
          this.serverItems = items;
        //   if (this.formatData) {
        //     this.serverItems.map((item) => {
        //       for (let i in this.formatData) {
        //         item[i] = this.formatData[i](item[i]);
        //       }
        //       return item;
        //     });
        //   }
          this.totalItems = total;
          this.loading = false;
        }
      );
    },
    updateData() {
      axios
        .patch(this.urlBaseData + "/" + this.selectedItemUpdate.id, this.form)
        .then((r) => {
          this.loadItems({ page: 1, itemsPerPage: this.itemsPerPage });
        })
        .catch((e) => {
          console.log(e);
        });
    },
    newData() {
      axios
        .post(this.urlBaseData, this.form)
        .then((r) => {
          this.loadItems({ page: 1, itemsPerPage: this.itemsPerPage });
        })
        .catch((e) => {
          console.log(e);
        });
    },
    priceGreaterThan() {
      axios
        .get(`${this.urlBaseData}/price-greater-than/${this.value}`)
        .then((r) => {
          this.loadItems({ page: 1, itemsPerPage: this.itemsPerPage });
        })
        .catch((e) => {
          console.log(e);
        });
    },
  },
});
</script>
