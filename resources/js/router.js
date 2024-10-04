import { createRouter, createWebHistory } from 'vue-router';

import ClienteForm from '@views/Cliente/Create.vue';
import ClienteList from '@views/Cliente/List.vue';
import ClienteEdit from '@views/Cliente/Edit.vue';

import CidadeForm from '@views/Cidade/Create.vue';
import CidadeList from '@views/Cidade/List.vue';
import CidadeEdit from '@views/Cidade/Edit.vue';

import RepresentanteForm from '@views/Representante/Create.vue';
import RepresentanteList from '@views/Representante/List.vue';
import RepresentanteEdit from '@views/Representante/Edit.vue';

const routes = [
  {
    path: '/clientes',
    name: 'clientes',
    component: ClienteForm,
  },
  {
    path: '/clientes/list',
    name: 'cliente-list',
    component: ClienteList, 
  },
  {
    path: '/clientes/:id/edit',
    name: 'cliente-edit',
    component: ClienteEdit,
  },

  {
    path: '/cidades',
    name: 'cidades',
    component: CidadeForm,
  },
  {
    path: '/cidades/list',
    name: 'cidade-list',
    component: CidadeList, 
  },
  {
    path: '/cidades/:id/edit',
    name: 'cidade-edit',
    component: CidadeEdit,
  },

  {
    path: '/representantes',
    name: 'representantes',
    component: RepresentanteForm,
  },
  {
    path: '/representantes/list',
    name: 'representante-list',
    component: RepresentanteList, 
  },
  {
    path: '/representantes/:id/edit',
    name: 'representante-edit',
    component: RepresentanteEdit,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
