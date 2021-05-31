import VueRouter from 'vue-router';

const routes = [
  {
    path: '/',
    component: Vue.component('tpl-main'),
    children: [
      {
        path: '',
        name: 'home',
        component: Vue.component('page-home'),
      }
    ]
  }
];

export default new VueRouter({
  mode:   'history',
  routes: routes,
  //////////////////
  scrollBehavior(to, from, savedPosition) {
      if (savedPosition) {
        return savedPosition
      } else {
        return { x: 0, y: 0 }
      }
  }
});