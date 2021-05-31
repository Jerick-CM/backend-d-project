<template>
  <b-modal centered id="modal-selection-user" title="Select Receiver" @ok="handleConfirm">
      <b-form-group>
        <b-form-input v-model="search" type="text" placeholder="Search" @input="searchUser"></b-form-input>
      </b-form-group>        
      <div id="list-container">
        <div v-if="filteredUsers.length > 0">
          <b-list-group>
            <b-list-group-item button
              v-for="(u, idx) in filteredUsers"
              v-bind:key="idx"
              v-bind:active="isSelectedUser(u)"
              v-on:click="setSelectedUser(u)">
            <img class="rounded-circle img-thumbnail img-thumbnail__mini" v-bind:src="u.avatar" />
            {{ u.name }}
            </b-list-group-item>
          </b-list-group>
          <infinite-loading v-if="!isListComplete" @infinite="fetchUsers"></infinite-loading>
        </div>
        <div v-else-if="!isFetchingUsers" class="p-3">
          No users found
        </div>
        <div v-else class="p-3">
          Fetching users...
        </div>
      </div>
    </b-modal>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  mounted() {
    this.fetchUsers();
  },
  data() {
    return {
      users: [],
      search: null,
      lastPage: 1,
      currentPage: 0,
      selectedUser: null,
      isFetchingUsers: false,
    }
  },
  methods: {
    fetchUsers() {
      if (this.isListComplete) {
        return false;
      }
      
      this.isFetchingUsers = true;

      this.$store
          .dispatch('fetchUsers', {
            page: (this.currentPage + 1),
            search: this.search,
          })
          .then((res) => {
            for (let user of res.data) {
              this.users.push(user);
            }

            this.lastPage = res.last_page;
            this.currentPage = res.current_page;
          })
          .finally(() => {
            this.isFetchingUsers = false;
          });
    },
    setSelectedUser(user) {
      this.selectedUser = user;
    },
    handleConfirm() {
      this.$emit('confirm', this.selectedUser);
    },
    searchUser: _.debounce(function () {
      this.users = [];
      this.lastPage = 1;
      this.currentPage = 0;
      this.fetchUsers();
    }, 1000),
  },
  computed: {
    ...mapGetters([
      'user',
    ]),
    filteredUsers() {
      // Exclude your own account on the list
      return this.users.filter(u => u.id !== this.user.id);
    },
    isListComplete() {
      return this.currentPage === this.lastPage;
    },
    isSelectedUser() {
      return (user) => {
        if (this.selectedUser === null) {
          return false;
        }

        return user.id === this.selectedUser.id;
      }
    }
  }
}
</script>

<style lang="scss" scoped>
#list-container {
  & {
    overflow: auto;
    max-height: 50vh;
    border-radius: 0.25rem;
    border: 1px solid rgba(0, 0, 0, 0.125);
  }
  .list-group-item {
    & {
      outline: none !important;
      border-width: 1px 0;
    }
    .img-thumbnail__mini {
      width: 36px;
      height: 36px;
      padding: 1px;
      margin-right: 4px;
    }
  }
  .list-group-item:first-child {
    border-top-width: 0;
  }
  .list-group-item:last-child {
    border-bottom-width: 0;
  }
}
</style>
