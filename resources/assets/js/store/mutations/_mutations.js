export default {
  user: (state, user) => {
    state.user = user;
  },
  profile: (state, profile) => {
    state.profile = profile;
  },
  async avatar(state, avatar) {
    state.avatar = avatar;
  },
}
