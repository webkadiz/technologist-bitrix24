import Vue from 'vue'
import VueRouter from 'vue-router'
import Old from '@/pages/Old'
import New from '@/pages/New'

Vue.use(VueRouter)

export default new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: Old
    },
    {
      path: '/new',
      component: New
    }
  ]
})