import { createRouter, createWebHistory } from 'vue-router'

import IndexView from "@/views/IndexView.vue";
import ServiceView from "@/views/ServiceView.vue";
import ContactView from "@/views/ContactView.vue";
import LoginView from "@/views/LoginView.vue";
import RegisterView from "@/views/RegisterView.vue";
import AdminView from '@/views/Admin/AdminView.vue';
import AdminAppointmentsView from '@/views/Admin/AdminAppointmentsView.vue';
import AdminScheduleView from '@/views/Admin/AdminScheduleView.vue';
import AdminManageScheduleView from '@/views/Admin/AdminManageScheduleView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: IndexView
    },
    {
      path: '/service',
      name: 'service',
      component: ServiceView
    },
    {
      path: '/contact',
      name: 'contact',
      component: ContactView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView,
      meta: { requiresAuth: true }
    },
    {
      path: '/admin',
      name: 'admin',
      component: AdminView,
      meta: { requiresAuth: true }
    },
    {
      path: '/admin/appointments',
      name: 'admin-appointments',
      component: AdminAppointmentsView,
      meta: { requiresAuth: true }
    },
    {
      path: '/admin/schedule',
      name: 'admin-schedule',
      component: AdminScheduleView,
      meta: { requiresAuth: true }
    },
    {
      path: '/admin/schedule/manage',
      name: 'admin-schedule-manage',
      component: AdminManageScheduleView,
      meta: { requiresAuth: true }
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/appointment',
      name: 'appointment',
      component: () => import('../views/AppointmentView.vue')
    }

  ]
});
function isAuthenticated() {
  const token = localStorage.getItem('userToken');
  return !!token; // Convert to boolean
}

// Navigation guard to check authentication before accessing routes
router.beforeEach((to, from, next) => {
  // Check if the route requires authentication
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // If authentication is required
    if (!isAuthenticated()) {
      // If not authenticated, redirect to login page
      next('/login');
    } else {
      // If authenticated, proceed to the route
      next();
    }
  } else {
    // If the route doesn't require authentication, proceed to the route
    next();
  }
});

export default router
