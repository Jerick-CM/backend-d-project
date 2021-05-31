const UserProvider = $h.getProvider('UserProvider');
const GraphProvider = $h.getProvider('GraphProvider');

export default {
  async fetchUserProfileData({commit}) {
    try {
      const getUserReq = await UserProvider.getUser();
      commit('user', await getUserReq.data);
    } catch(error) {
      console.error(error);
    }
  },
  async queryUserData({ commit }, azureID) {
    let profile = {};
    let dbData = {};
    let avatar = 'https://www.ebunch.ca/wp-content/uploads/avatar-2.png';

    try {
      const getProfileReq = await GraphProvider.run('GET', `/users/${azureID}`);
      profile = getProfileReq.data;
    } catch(error) {
      console.error(error);
    }

    try {
      const getAvatarReq = await GraphProvider.run('GET', `/users/${azureID}/photo/$value`, null, null, 'blob');
      avatar = URL.createObjectURL(getAvatarReq.data);
    } catch(error) {
      console.error(error);
    }

    try {
      const getDBDataReq = await axios.post('/api/users/firstOrCreate', { azure_id: azureID });;
      dbData = getDBDataReq.data;
    } catch(error) {
      console.error(error);
    }

    return { profile, dbData, avatar };
  },

  fetchUsers({commit}, params) {
    return new Promise((resolve, reject) => {
      UserProvider.getUsers(params)
        .then((res) => {
          resolve(res.data);
        })
        .catch((err) => {
          reject(err);
        });
    });
  },

  sendNomination({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post('/api/nominations', payload)
           .then((res) => { resolve(res); })
           .catch((err) => { reject(err.response); });
    });
  },
  
  listNominations({commit}, params) {
    return new Promise((resolve, reject) => {
      axios.get('/api/nominations', { params: params })
           .then((res) => { resolve(res.data); })
           .catch((err) => { reject(err); });
    });
  }
}
