<template>
    <div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-extrabold text-gray-900 mb-4">Listagem de Cidades</h2>
        <div class="flex flex-col md:flex-row gap-4 mb-6">
          <div class="w-full md:w-1/2">
            <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
            <input
              v-model="filters.nome"
              id="nome"
              type="text"
              placeholder="Pesquisar por nome"
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
  
          <div class="w-full md:w-1/2">
            <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
            <input
              v-model="filters.estado"
              id="estado"
              type="text"
              placeholder="Pesquisar por estado"
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
        </div>
  
        <div class="mb-4">
          <button
            @click="loadCidades"
            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Buscar
          </button>
        </div>
  
        <DataTable :value="cidades" class="p-datatable-striped">
          <Column field="nome" header="Nome"></Column>
          <Column field="estado" header="Estado"></Column>
          <Column header="Ações">
            <template #body="slotProps">
              <router-link :to="`/cidades/${slotProps.data.id}/edit`" class="text-indigo-600 hover:text-indigo-900">
                Editar
              </router-link>
              <button @click="deleteCidade(slotProps.data.id)" class="text-red-600 hover:text-red-900 ml-4">Excluir</button>
            </template>
          </Column>
        </DataTable>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { useToast } from 'primevue/usetoast';
  import DataTable from 'primevue/datatable';
  import Column from 'primevue/column';
  
  const cidades = ref([]);
  const filters = ref({
    nome: '',
    estado: ''
  });
  const toast = useToast();
  
  const loadCidades = async () => {
    try {
      const { data } = await axios.get('/api/cidades', { params: filters.value });
      cidades.value = data;
    } catch (error) {
      toast.add({ severity: 'error', summary: 'Erro', detail: 'Erro ao carregar cidades' });
    }
  };
  
  const deleteCidade = async (id) => {
    if (confirm("Tem certeza que deseja excluir esta cidade?")) {
      try {
        await axios.delete(`/api/cidades/${id}`);
        toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Cidade excluída com sucesso' });
        loadCidades(); 
      } catch (error) {
        toast.add({ severity: 'error', summary: 'Erro', detail: 'Erro ao excluir cidade' });
      }
    }
  };
  
  onMounted(() => {
    loadCidades();
  });
  </script>
  