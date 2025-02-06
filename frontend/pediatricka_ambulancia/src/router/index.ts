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
import SuccessPageView from '@/views/SuccessPageView.vue';
import VerificationSuccessView from '@/views/VerificationSuccessView.vue';
import AdminDoctorContentView from '@/views/Admin/AdminDoctorContentView.vue';
import BlogList from '@/components/Blogs.vue';
import BlogDetail from '@/components/BlogDetail.vue';
import AdminBlogManager from '@/views/Admin/AdminBlogManager.vue';
import AdminTestimonialView from '@/views/Admin/AdminTestimonialView.vue';
import AdminServiceView from '@/views/Admin/AdminServiceView.vue';
import AdminPatientView from '@/views/Admin/AdminPatientView.vue';
import AdminPatientDetailView from '@/views/Admin/AdminPatientDetailView.vue';
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
      path: '/success-page',
      name: 'success-page',
      component: SuccessPageView
    },
    {
      path: '/verification-success',
      name: 'verification-success',
      component: VerificationSuccessView
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
      path: '/admin/doctor/manage',
      name: 'admin-doctor-manage',
      component: AdminDoctorContentView,
      meta: { requiresAuth: true }
    },
    {
      path: '/admin/blogs/manage',
      name: 'admin-blogs-manage',
      component: AdminBlogManager,
      meta: { requiresAuth: true }
    },
    {
      path: '/admin/testimonials/manage',
      name: 'admin-testimonials-manage',
      component: AdminTestimonialView,
      meta: { requiresAuth: true }
    },
    {
      path: '/admin/service/manage',
      name: 'admin-service-manage',
      component: AdminServiceView,
      meta: { requiresAuth: true }
    },
    {
      path: '/admin/patient',
      name: 'admin-patient',
      component: AdminPatientView,
      meta: { requiresAuth: true }
    },
    { path: '/admin/patients/:id', component: AdminPatientDetailView, meta: { requiresAuth: true } },
    
    { path: '/blogs', component: BlogList },
    { path: '/blog/:slug', component: BlogDetail, props: true },
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
  return !!token; 
}

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated()) {
      next('/login');
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router
