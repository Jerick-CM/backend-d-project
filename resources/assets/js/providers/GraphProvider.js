import Store from '../store/store';

export default new class {
  constructor() {
    this.config = {
      api: "https://graph.microsoft.com",
      version: "beta",
    }
  }

  run(method, url, data = null, params = null, responseType = 'json') {
    return new Promise((resolve, reject) => {
      axios({
        method: method,
        url: this.getApiRoot() + url,
        data,
        params,
        headers: {
          Authorization: 'Bearer ' + this.getAccessToken(),
        },
        responseType
      }).then((res) => {
        resolve(res);
      }).catch((err) => {
        reject(err.response);
      });
    });
  }

  getApiRoot() {
    return `${this.config.api}/${this.config.version}`;
  }

  getAccessToken() {
    return Store.state.user.azure_token.access_token;
  }

  setApiVersion(version) {
    this.config.version = version;
    return this;
  }
}
