<template>
  <header>
    <div class="container">
      <router-link class="brand" to="/">REWARD PORTAL</router-link>
      <ul>
        <li>
          <a href="/logout">Logout</a>
        </li>
      </ul>
    </div>
  </header>
</template>

<style lang="scss" scoped>
header {
  & {
    height: 56px;
    background-color: #000000;
    @media (min-width: 992px) {
      height: 64px;
    }
  }
  & > .container {
    & > a.brand,
    & > ul > li > a {
      line-height: 56px;
      @media (min-width: 992px) {
        line-height: 64px;
      }
    }
    & > a.brand {
      color: #FFFFFF;
    }
    & > ul {
      & {
        float: right;
        margin: 0;
        padding: 0;
        list-style-type: none;
      }
      & > li > a {
        color: #BABABA;
      }
    }
  }
}
</style>