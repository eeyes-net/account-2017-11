require('./bootstrap');

window.Vue = require('vue');

Vue.component('admin-user', require('./components/admin/User.vue'));
Vue.component('admin-role', require('./components/admin/Role.vue'));
Vue.component('admin-permission', require('./components/admin/Permission.vue'));

const app = new Vue({
    el: '#admin'
});
