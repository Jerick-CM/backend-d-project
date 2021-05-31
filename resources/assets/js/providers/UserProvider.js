export default new class {
  constructor() {
    this.api = {
      getUser: '/api/user',
      getUsers: '/api/users',
    }
  }

  getUser() {
    return new Promise((resolve, reject) => {
      axios.get(this.api.getUser)
        .then((res) => {
          resolve(res);
        })
        .catch((err) => {
          reject(err.response);
        });
    });
  }

  getUsers(params) {
    return new Promise((resolve, reject) => {
      axios.get(this.api.getUsers, {
        params: params
      }).then((res) => {
        resolve(res);
      }).catch((err) => {
        reject(err.response);
      });
    });
  }
}