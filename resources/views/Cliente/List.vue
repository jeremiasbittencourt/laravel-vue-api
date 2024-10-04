<template>
  <div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-md">
      <h2 class="text-2xl font-extrabold text-gray-900 mb-4">Listagem de Clientes</h2>
      <div class="flex flex-col md:flex-row gap-4 mb-6">
        <div class="w-full md:w-1/3">
          <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
          <input
            v-model="filters.nome"
            id="nome"
            type="text"
            placeholder="Pesquisar por nome"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>

        <div class="w-full md:w-1/3">
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input
            v-model="filters.email"
            id="email"
            type="text"
            placeholder="Pesquisar por email"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>

        <div class="w-full md:w-1/3">
          <label for="cidade_id" class="block text-sm font-medium text-gray-700">Cidade</label>
          <select
            v-model="filters.cidade_id"
            id="cidade_id"
            class="block w-full mt-1 px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          >
            <option value="">Todas</option>
            <option v-for="cidade in cidades" :key="cidade.id" :value="cidade.id">
              {{ cidade.nome }} ({{ cidade.estado }})
            </option>
          </select>
        </div>
      </div>

      <div class="mb-4">
        <button
          @click="loadClientes"
          class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Buscar
        </button>
      </div>

      <DataTable :value="clientes" class="p-datatable-striped">
        <Column field="nome" header="Nome"></Column>
        <Column field="email" header="Email"></Column>
        <Column field="celular" header="Celular"></Column>
        <Column field="data_nascimento" header="Data de Nascimento"></Column>
        <Column field="sexo" header="Sexo"></Column>
        <Column field="cidade.nome" header="Cidade"></Column>
        <Column header="Ações">
          <template #body="slotProps">
            <router-link :to="`/clientes/${slotProps.data.id}/edit`" class="text-indigo-600 hover:text-indigo-900">
            Editar
            </router-link>
            <button @click="deleteCliente(slotProps.data.id)" class="text-red-600 hover:text-red-900 ml-4">Excluir</button>
          </template>
        </Column>
      </DataTable>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from "primevue/usetoast";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

const clientes = ref([]);
const cidades = ref([]);
const filters = ref({
  nome: '',
  email: '',
  cidade_id: ''
});
const toast = useToast();

const loadClientes = async () => {
  try {
    const { data } = await axios.get('/api/clientes', { params: filters.value });
    clientes.value = data;
  } catch (error) {
    toast.add({ severity: 'error', summary: 'Erro', detail: 'Erro ao carregar clientes' });
  }
};

const loadCidades = async () => {
  try {
    const { data } = await axios.get('/api/cidades');
    cidades.value = data;
  } catch (error) {
    toast.add({ severity: 'error', summary: 'Erro', detail: 'Erro ao carregar cidades' });
  }
};

const deleteCliente = async (id) => {
  if (confirm("Tem certeza que deseja excluir este cliente?")) {
    try {
      await axios.delete(`/api/clientes/${id}`);
      toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Cliente excluído com sucesso' });
      loadClientes();
    } catch (error) {
      toast.add({ severity: 'error', summary: 'Erro', detail: 'Erro ao excluir cliente' });
    }
  }
};

onMounted(() => {
  loadClientes();
  loadCidades();
});
</script>
