import { createRouter, createWebHistory } from 'vue-router'
import DashboardView from '../views/DashboardView.vue'
import LoginComponent from '@/components/LoginComponent.vue'
import RegisterComponent from '@/components/RegisterComponent.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'dashboard',
      component: DashboardView,
      children : [
        {
          path : '',
          name : 'popular',
          component: () => import ('../views/PopularProductsView.vue'),
        }
      ]
    },
    {
      path : '/login',
      name : 'login',
      component : LoginComponent,
    },
    {
      path: '/register',
      name : 'register',
      component : RegisterComponent,
    },    /*
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue'),
    },
    */
    {
      path: '/admin-panel',
      name : 'AdminPanel',
      component : () => import ('../views/AdminPanelView.vue'),
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'NotFound',
      component : () => import('../views/NotFoundView.vue'),
    },
  ],
})

export default router
