<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Cadastro de Cidade
      </h2>
      <form @submit.prevent="salvarCidade" class="mt-8 space-y-6">

        <div class="flex flex-col md:flex-row gap-4">
          <div class="w-full">
            <label for="nome" class="block text-sm font-medium text-gray-700">
              Nome da Cidade
            </label>
            <input
              v-model="cidade.nome"
              id="nome"
              name="nome"
              type="text"
              maxlength="255"
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
        </div>

        <div class="flex flex-col md:flex-row gap-4">
          <div class="w-full">
            <label for="estado" class="block text-sm font-medium text-gray-700">
              Estado
            </label>
            <input
              v-model="cidade.estado"
              id="estado"
              name="estado"
              type="text"
              maxlength="255"
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
        </div>

        <div class="w-full">
          <button
            type="submit"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            :disabled="isSubmitting"
          >
            {{ isSubmitting ? "Salvando..." : "Cadastrar Cidade" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useToast } from "vue-toastification";

const isSubmitting = ref(false);
const toast = useToast();

const cidade = ref({
  nome: '',
  estado: '',
});

const formValidate = () => {
  if (!cidade.value.nome) {
    toast.error("O campo Nome da Cidade é obrigatório");
    return false;
  }
  if (!cidade.value.estado) {
    toast.error("O campo Estado é obrigatório");
    return false;
  }

  return true; 
};

const salvarCidade = async () => {
  if (!formValidate()) {
    return; 
  }

  try {
    isSubmitting.value = true; 

    await axios.post('/api/cidades', cidade.value);

    cidade.value = {
      nome: '',
      estado: ''
    };

    toast.success("Cidade cadastrada com sucesso!");

  } catch (error) {
    console.error("Erro ao salvar cidade:", error);
    toast.error("Erro ao cadastrar a cidade. Verifique os dados.");
  } finally {
    isSubmitting.value = false;
  }
};
</script>
