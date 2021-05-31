window.Vue = require('vue');

require('./helper');
require('./bootstrap');
require('./components/components');
require('./plugins/plugins');

const Store = require('./store/store').default;
const Router = require('./router/router').default;

const app = new Vue({
    el: '#app',
    store: Store,
    router: Router,
});
