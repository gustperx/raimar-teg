<script setup>
import Multiselect from "vue-multiselect";

import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetButton from "@/Jetstream/Button.vue";

import ModalAdd from "@/Components/ModalAdd.vue";

import { useBrand } from "@/Composables/useBrand.js";
import { useModel } from "@/Composables/useModel.js";
import { useCategory } from "@/Composables/useCategory.js";

defineProps({
  actionSubmit: {
    required: true,
  },
  categories: {
    required: true,
  },
  statuses: {
    required: true,
  },
  departments: {
    required: true,
  },
  form: {
    required: true,
  },
});

const {
  brands,
  brandForm,
  isOpenModal,
  openModal,
  closeModal,
  saveBrand
} = useBrand(1);

const {
  models,
  modelForm,
  isOpenModal: modelIsOpenModal,
  openModal: modelOpenModal,
  closeModal: modelCloseModal,
  saveModel
} = useModel(1);

const {
  categories: ajaxCategories,
  categoryForm,
  isOpenModal: categoryIsOpenModal,
  openModal: categoryOpenModal,
  closeModal: categoryCloseModal,
  saveCategory,
} = useCategory(1);

</script>

<template>
  <JetFormSection @submitted="actionSubmit">
    <template #title> Equipos de cómputos </template>

    <template #description>
      Los equipos de cómputos pertenecen a una misma categoría, solo tiene que
      llenar las características que lo hace único como lo son el código y
      serial, además de la descripción, marca y modelo. También se registra un
      estatus para controlar el mantenimiento de los equipos y determinar su
      operatividad
    </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <div class="flex">
          <div class="basis-10/12">
            <JetLabel for="category_id" value="Categoría" />
            <Multiselect
              v-model="form.category_id"
              :options="ajaxCategories"
              :searchable="false"
              track-by="name"
              label="name"
              placeholder="Categorías"
            />
            <JetInputError :message="form.errors.category_id" class="mt-2" />
          </div>
          <div class="basis-2/12">
            <br>
            <JetButton type="button" @click="categoryOpenModal" class="ml-2">
              Nuevo
            </JetButton>
          </div>
        </div>
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="description" value="Descripción" />
        <JetInput
          id="description"
          v-model="form.description"
          type="text"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.description" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <div class="flex">
          <div class="basis-10/12">
            <JetLabel for="brand" value="Marca" />
            <Multiselect
              v-model="form.brand"
              :options="brands"
              :searchable="false"
              track-by="name"
              label="name"
              placeholder="Marcas"
            />
            <JetInputError :message="form.errors.brand" class="mt-2" />
          </div>
          <div class="basis-2/12">
            <br>
            <JetButton type="button" @click="openModal" class="ml-2">
              Nuevo
            </JetButton>
          </div>
        </div>
      </div>
      <div class="col-span-6 sm:col-span-4">
        <div class="flex">
          <div class="basis-10/12">
            <JetLabel for="model" value="Modelo" />
            <Multiselect
              v-model="form.model"
              :options="models"
              :searchable="false"
              track-by="name"
              label="name"
              placeholder="Modelos"
            />
            <JetInputError :message="form.errors.model" class="mt-2" />
          </div>
          <div class="basis-2/12">
            <br>
            <JetButton type="button" @click="modelOpenModal" class="ml-2">
              Nuevo
            </JetButton>
          </div>
        </div>
      </div>
      <!-- <div class="col-span-6 sm:col-span-4">
        <JetLabel for="code" value="Código" />
        <JetInput
          id="code"
          v-model="form.code"
          type="text"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.code" class="mt-2" />
      </div> -->
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="serial" value="Serial" />
        <JetInput
          id="serial"
          v-model="form.serial"
          type="text"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.serial" class="mt-2" />
      </div>
      <!-- <div class="col-span-6 sm:col-span-4">
        <JetLabel for="status_id" value="Estatus" />
        <Multiselect
          v-model="form.status_id"
          :options="statuses"
          :searchable="true"
        />
        <JetInputError :message="form.errors.status_id" class="mt-2" />
      </div> -->

      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="department_id" value="Departamento" />
        <Multiselect
          v-model="form.department_id"
          :options="departments"
          :searchable="false"
          track-by="name"
          label="name"
          placeholder="Departamento"
        />
        <JetInputError :message="form.errors.department_id" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
        Guardado.
      </JetActionMessage>

      <JetButton
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Guardar
      </JetButton>
    </template>
  </JetFormSection>

  <!-- Modal Brands -->
  <ModalAdd
    :isOpenModal="isOpenModal"
    :form="brandForm"
    @onConfirm="saveBrand"
    @onCancel="closeModal"
  />

  <!-- Modal Models -->
  <ModalAdd
    :isOpenModal="modelIsOpenModal"
    :form="modelForm"
    @onConfirm="saveModel"
    @onCancel="modelCloseModal"
  />

  <!-- Modal Categories -->
  <ModalAdd
    :isOpenModal="categoryIsOpenModal"
    :form="categoryForm"
    @onConfirm="saveCategory"
    @onCancel="categoryCloseModal"
  />
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
