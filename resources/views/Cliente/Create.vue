<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Cadastro de Cliente
      </h2>
      <form @submit.prevent="salvarCliente" class="mt-8 space-y-6">

        <div class="flex flex-col md:flex-row gap-4">
          <div class="w-full md:w-1/2">
            <label for="nome" class="block text-sm font-medium text-gray-700">
              Nome
            </label>
            <input
              v-model="cliente.nome"
              id="nome"
              name="nome"
              type="text"
              maxlength="255"
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
          <div class="w-full md:w-1/2">
            <label for="cpfCnpj" class="block text-sm font-medium text-gray-700">
              CPF/CNPJ
            </label>
            <input
              v-model="cliente.cpfCnpj"
              id="cpfCnpj"
              name="cpfCnpj"
              type="text"
              v-mask="cpfCnpjMask"
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
        </div>

        <div class="flex flex-col md:flex-row gap-4">
          <div class="w-full md:w-1/2">
            <label for="email" class="block text-sm font-medium text-gray-700">
              Email
            </label>
            <input
              v-model="cliente.email"
              id="email"
              name="email"
              type="email"
              maxlength="255"
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
          <div class="w-full md:w-1/2">
            <label for="celular" class="block text-sm font-medium text-gray-700">
              Celular
            </label>
            <input
              v-model="cliente.celular"
              id="celular"
              name="celular"
              type="text"
              v-mask="'(##) # ####-####'"
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
        </div>

        <div class="flex flex-col md:flex-row gap-4">
          <div class="w-full md:w-1/3">
            <label for="data_nascimento" class="block text-sm font-medium text-gray-700">
              Data de Nascimento
            </label>
            <input
              v-model="cliente.data_nascimento"
              id="data_nascimento"
              name="data_nascimento"
              type="date"
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
          <div class="w-full md:w-1/3">
            <label for="sexo" class="block text-sm font-medium text-gray-700">
              Sexo
            </label>
            <select
              v-model="cliente.sexo"
              id="sexo"
              name="sexo"
              class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
              <option value="Masculino">Masculino</option>
              <option value="Feminino">Feminino</option>
              <option value="Outro">Outro</option>
            </select>
          </div>
          <div class="w-full md:w-1/3">
            <label for="cidade_id" class="block text-sm font-medium text-gray-700">
              Cidade
            </label>
            <select
              v-model="cliente.cidade_id"
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
          {{ isSubmitting ? "Salvando..." : "Cadastrar Cliente" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { useToast } from "vue-toastification";

const isSubmitting = ref(false);
const toast = useToast();

const cliente = ref({
  cpfCnpj: '',
  nome: '',
  email: '',
  celular: '',
  data_nascimento: '',
  sexo: '',
  cidade_id: null,
});

const cidades = ref([]);

const cpfCnpjMask = computed(() => {
  return cliente.value.cpfCnpj.replace(/\D/g, '').length <= 11
    ? '###.###.###-##' 
    : '##.###.###/####-##'; 
});

const formValidate = () => {
  if (!cliente.value.cpfCnpj) {
    toast.error("O campo CPF/CNPJ é obrigatório");
    return false;
  }
  if (!cliente.value.nome) {
    toast.error("O campo Nome é obrigatório");
    return false;
  }
  if (!cliente.value.email) {
    toast.error("O campo Email é obrigatório");
    return false;
  }
  if (!cliente.value.celular) {
    toast.error("O campo Celular é obrigatório");
    return false;
  }
  if (!cliente.value.data_nascimento) {
    toast.error("O campo Data de Nascimento é obrigatório");
    return false;
  }
  if (!cliente.value.sexo) {
    toast.error("O campo Sexo é obrigatório");
    return false;
  }
  if (!cliente.value.cidade_id) {
    toast.error("O campo Cidade é obrigatório");
    return false;
  }

  return true; 
};


const salvarCliente = async () => {
  if (!formValidate()) {
    return; 
  }

  try {
    isSubmitting.value = true;

    const response = await axios.post('/api/clientes', cliente.value);
    
    cliente.value = {
      cpfCnpj: '',
      nome: '',
      email: '',
      celular: '',
      data_nascimento: '',
      sexo: '',
      cidade_id: null
    };

    toast.success("Cliente cadastrado com sucesso!");

  } catch (error) {
    console.error("Erro ao salvar cliente:", error);
    toast.error("Erro ao cadastrar o cliente. Verifique os dados.");
  } finally {
    isSubmitting.value = false; 
  }
};

onMounted(async () => {
  try {
    const response = await axios.get('/api/cidades');
    cidades.value = response.data;
  } catch (error) {
    console.error('Erro ao carregar as cidades:', error);
  }
});
</script>
