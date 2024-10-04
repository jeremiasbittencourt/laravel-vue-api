<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Editar Cidade
      </h2>
      <form @submit.prevent="updateCidade" class="mt-8 space-y-6">
        <div class="w-full">
          <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
          <input
            v-model="cidade.nome"
            id="nome"
            name="nome"
            type="text"
            maxlength="255"
            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>

        <div class="w-full">
          <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
          <input
            v-model="cidade.estado"
            id="estado"
            name="estado"
            type="text"
            maxlength="255"
            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>

        <div>
          <button
            type="submit"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Atualizar Cidade
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';

const route = useRoute();
const router = useRouter();
const toast = useToast();

const cidade = ref({
  nome: '',
  estado: '',
});

const validateForm = () => {
  if (!cidade.value.nome) {
    toast.error("O campo Nome é obrigatório");
    return false;
  }
  if (!cidade.value.estado) {
    toast.error("O campo Estado é obrigatório");
    return false;
  }
  return true;
};

const loadCidade = async () => {
  try {
    const { data } = await axios.get(`/api/cidades/${route.params.id}/edit`);
    cidade.value = data;
  } catch (error) {
    console.error("Erro ao carregar cidade:", error);
    toast.error("Erro ao carregar cidade.");
  }
};

const updateCidade = async () => {
  if (!validateForm()) return; 

  try {
    await axios.put(`/api/cidades/${route.params.id}`, cidade.value);
    toast.success("Cidade atualizada com sucesso!");
    router.push('/cidades/list');
  } catch (error) {
    console.error("Erro ao atualizar cidade:", error);
    toast.error("Erro ao atualizar cidade.");
  }
};

onMounted(() => {
  loadCidade();
});
</script>
