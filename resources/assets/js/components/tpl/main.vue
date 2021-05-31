<template>
  <div id="main-tpl">
    <partial-header></partial-header>
    <partial-navbar></partial-navbar>
    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.$store.dispatch('fetchUserProfileData');
  }
}
</script>
