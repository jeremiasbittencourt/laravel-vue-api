<template>
  <div class="flex min-h-screen bg-gray-100">
    <!-- Menu lateral -->
    <aside :class="isSidebarOpen ? 'w-64' : 'w-16'" class="bg-indigo-600 shadow-md text-white transition-all duration-300">
      <!-- Botão para abrir/fechar o menu lateral -->
      <div class="p-4 flex items-center justify-between">
        <h2 v-if="isSidebarOpen" class="text-xl font-bold">Menu</h2>
        <button @click="toggleSidebar" class="text-white focus:outline-none">
          <i :class="isSidebarOpen ? 'pi pi-angle-left' : 'pi pi-angle-right'" class="pi text-2xl"></i>
        </button>
      </div>
      <div v-if="isSidebarOpen" class="p-4">
        <ul class="mt-4 space-y-2">
          <!-- Clientes -->
          <li>
            <div @click="toggleSubmenu('clientes')" class="flex items-center justify-between cursor-pointer hover:bg-indigo-500 px-4 py-2 rounded-lg">
              <div class="flex items-center space-x-2">
                <i class="pi pi-users"></i>
                <h3 class="text-lg font-semibold">Clientes</h3>
              </div>
              <i :class="isSubmenuOpen.clientes ? 'pi pi-angle-down' : 'pi pi-angle-right'" class="pi"></i>
            </div>
            <ul v-if="isSubmenuOpen.clientes" class="pl-8 mt-2 space-y-1">
              <li>
                <router-link to="/clientes" class="block text-sm px-4 py-2 text-gray-300 hover:bg-indigo-500 hover:text-white rounded-lg">
                  Cadastro
                </router-link>
              </li>
              <li>
                <router-link to="/clientes/list" class="block text-sm px-4 py-2 text-gray-300 hover:bg-indigo-500 hover:text-white rounded-lg">
                  Listagem
                </router-link>
              </li>
            </ul>
          </li>

          <!-- Cidades -->
          <li>
            <div @click="toggleSubmenu('cidades')" class="flex items-center justify-between cursor-pointer hover:bg-indigo-500 px-4 py-2 rounded-lg">
              <div class="flex items-center space-x-2">
                <i class="pi pi-map-marker"></i>
                <h3 class="text-lg font-semibold">Cidades</h3>
              </div>
              <i :class="isSubmenuOpen.cidades ? 'pi pi-angle-down' : 'pi pi-angle-right'" class="pi"></i>
            </div>
            <ul v-if="isSubmenuOpen.cidades" class="pl-8 mt-2 space-y-1">
              <li>
                <router-link to="/cidades" class="block text-sm px-4 py-2 text-gray-300 hover:bg-indigo-500 hover:text-white rounded-lg">
                  Cadastro
                </router-link>
              </li>
              <li>
                <router-link to="/cidades/list" class="block text-sm px-4 py-2 text-gray-300 hover:bg-indigo-500 hover:text-white rounded-lg">
                  Listagem
                </router-link>
              </li>
            </ul>
          </li>

          <!-- Representantes -->
          <li>
            <div @click="toggleSubmenu('representantes')" class="flex items-center justify-between cursor-pointer hover:bg-indigo-500 px-4 py-2 rounded-lg">
              <div class="flex items-center space-x-2">
                <i class="pi pi-briefcase"></i>
                <h3 class="text-lg font-semibold">Representantes</h3>
              </div>
              <i :class="isSubmenuOpen.representantes ? 'pi pi-angle-down' : 'pi pi-angle-right'" class="pi"></i>
            </div>
            <ul v-if="isSubmenuOpen.representantes" class="pl-8 mt-2 space-y-1">
              <li>
                <router-link to="/representantes" class="block text-sm px-4 py-2 text-gray-300 hover:bg-indigo-500 hover:text-white rounded-lg">
                  Cadastro
                </router-link>
              </li>
              <li>
                <router-link to="/representantes/list" class="block text-sm px-4 py-2 text-gray-300 hover:bg-indigo-500 hover:text-white rounded-lg">
                  Listagem
                </router-link>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </aside>

    <main class="flex-1 p-6">
      <router-view></router-view> <!-- Renderiza as rotas dinâmicas aqui -->
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const isSidebarOpen = ref(true);

const isSubmenuOpen = ref({
  clientes: false,
  cidades: false,
  representantes: false,
});

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

const toggleSubmenu = (menu) => {
  isSubmenuOpen.value[menu] = !isSubmenuOpen.value[menu];
};
</script>

<style scoped>
aside {
  transition: width 0.3s;
}
</style>
