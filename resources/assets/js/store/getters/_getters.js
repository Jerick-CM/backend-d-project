export default {
  user: (state) => {
    return state.user;
  },
  profile: (state) => {
    return state.profile;
  },
  avatar: (state) => {
    return state.avatar;
  },
  canMakeRequest: (state) => {
    return state.user.azure_id !== null;
  }
}
