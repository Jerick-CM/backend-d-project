import Vuex from 'vuex';

export default new Vuex.Store({
  state: require('./state/_state').default,
  actions: require('./actions/_actions').default,
  getters: require('./getters/_getters').default,
  mutations: require('./mutations/_mutations').default,
});
