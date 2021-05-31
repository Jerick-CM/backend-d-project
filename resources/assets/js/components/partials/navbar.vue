<template>
  <nav>
    <b-container class="mt-1 mb-1">
      <ul>
        <li>
          <router-link to="/">
            <i class="fa-fw fas fa-home"></i>
          </router-link>
        </li>
        <li>
          <router-link to="#">
            <i class="fa-fw fas fa-user"></i>
          </router-link>
        </li>
        <li>
          <router-link to="#">
            <i class="fa-fw fas fa-gift"></i>
          </router-link>
        </li>
      </ul>
      <ul class="float-right">
        <li>
          <form action="#">
            <b-input-group>
              <b-form-input type="text"></b-form-input>
              <b-input-group-append>
                <b-btn type="submit">
                  <i class="fas fa-search"></i>
                </b-btn>
              </b-input-group-append>
            </b-input-group>
          </form>
        </li>
        <li>
          <router-link to="#">
            <i class="fa-fw fas fa-shopping-cart"></i>
            <span class="badge">0</span>
          </router-link>
        </li>
        <li>
          <div class="wallet">
            {{ user.credits }}
          </div>
        </li>
      </ul>
    </b-container>
  </nav>
</template>

<script>
export default {
  computed: {
    user() {
      return this.$store.getters.user;
    }
  }
}
</script>


<style lang="scss" scoped>
nav {
  & > .container {
    & > ul {
      & {
        margin: 0;
        padding: 0;
        height: 80px;
        display: inline-block;
        list-style-type: none;
      }
      & > li {
        & {
          display: inline-block;
        }
        & > a {
          padding: 0 24px;
          display: block;
          color: #757575;
          line-height: 80px;
          font-size: 1.5rem;
        }
        & > a.router-link-active {
          color: #ffffff;
          background-color: #757575;
        }
        & > div.wallet {
          & {
            padding: 0 8px;
            border: 1px solid #757575;
            border-radius: 16px;
          }
          &:before {
            content: 'C';
          }
        }
      }
    }
  }
}
</style>
