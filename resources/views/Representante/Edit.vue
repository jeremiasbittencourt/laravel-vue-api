<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Editar Representante
      </h2>
      <form @submit.prevent="updateRepresentante" class="mt-8 space-y-6">
        <div class="flex flex-col md:flex-row gap-4">
          <div class="w-full md:w-1/2">
            <label for="nome" class="block text-sm font-medium text-gray-700">
              Nome
            </label>
            <input
              v-model="representante.nome"
              id="nome"
              name="nome"
              type="text"
              maxlength="255"
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
          <div class="w-full md:w-1/2">
            <label for="email" class="block text-sm font-medium text-gray-700">
              Email
            </label>
            <input
              v-model="representante.email"
              id="email"
              name="email"
              type="email"
              maxlength="255"
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
        </div>

        <div class="flex flex-col md:flex-row gap-4">
          <div class="w-full md:w-1/2">
            <label for="celular" class="block text-sm font-medium text-gray-700">
              Celular
            </label>
            <input
              v-model="representante.celular"
              id="celular"
              name="celular"
              type="text"
              v-mask="'(##) # ####-####'"
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
          <div class="w-full md:w-1/2">
            <label for="local_trabalho" class="block text-sm font-medium text-gray-700">
              Local de Trabalho
            </label>
            <input
              v-model="representante.local_trabalho"
              id="local_trabalho"
              name="local_trabalho"
              type="text"
              maxlength="255"
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
        </div>

        <div class="flex flex-col gap-4">
          <div class="w-full">
            <label for="cidade_id" class="block text-sm font-medium text-gray-700">
              Cidade
            </label>
            <select
              v-model="representante.cidade_id"
              id="cidade_id"
              name="cidade_id"
              class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
              <option v-for="cidade in cidades" :key="cidade.id" :value="cidade.id">
                {{ cidade.nome }} ({{ cidade.estado }})
              </option>
            </select>
          </div>
        </div>

        <div class="w-full">
          <button
            type="submit"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            :disabled="isSubmitting"
          >
            {{ isSubmitting ? "Salvando..." : "Atualizar Representante" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';

const route = useRoute();
const router = useRouter();
const toast = useToast();

const isSubmitting = ref(false);

const representante = ref({
  nome: '',
  email: '',
  celular: '',
  local_trabalho: '',
  cidade_id: null,
});

const cidades = ref([]);

const loadRepresentante = async () => {
  try {
    const { data } = await axios.get(`/api/representantes/${route.params.id}/edit`);
    representante.value = data;
  } catch (error) {
    console.error('Erro ao carregar representante:', error);
    toast.error('Erro ao carregar representante.');
  }
};

const loadCidades = async () => {
  try {
    const { data } = await axios.get('/api/cidades');
    cidades.value = data;
  } catch (error) {
    console.error('Erro ao carregar cidades:', error);
    toast.error('Erro ao carregar cidades.');
  }
};

const updateRepresentante = async () => {
  if (!validateForm()) return;

  isSubmitting.value = true;
  try {
    await axios.put(`/api/representantes/${route.params.id}`, representante.value);
    toast.success('Representante atualizado com sucesso!');
    router.push('/representantes/list');
  } catch (error) {
    console.error('Erro ao atualizar representante:', error);
    toast.error('Erro ao atualizar representante.');
  } finally {
    isSubmitting.value = false;
  }
};

const validateForm = () => {
  if (!representante.value.nome) {
    toast.error('O campo Nome é obrigatório');
    return false;
  }
  if (!representante.value.email) {
    toast.error('O campo Email é obrigatório');
    return false;
  }
  if (!representante.value.celular) {
    toast.error('O campo Celular é obrigatório');
    return false;
  }
  if (!representante.value.local_trabalho) {
    toast.error('O campo Local de Trabalho é obrigatório');
    return false;
  }
  if (!representante.value.cidade_id) {
    toast.error('O campo Cidade é obrigatório');
    return false;
  }
  return true;
};

onMounted(() => {
  loadRepresentante();
  loadCidades();
});
</script>
