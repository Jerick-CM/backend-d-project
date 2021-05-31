<template>
  <b-card-group id="activity-board" class="mb-3" deck>
    <b-col v-for="(n, idx) in nominations"
          v-bind:key="idx"
          cols="12"
          md="4"
          lg="3"
          v-if="nominations.length > 0">
      <activity-board-card v-bind:nomination="n">
      </activity-board-card>
    </b-col>
    <b-col v-if="nominations.length && !isLastPage" cols="12">
      <infinite-loading @infinite="getNominations"></infinite-loading>
    </b-col>
  </b-card-group>
</template>

<script>
export default {
  mounted() {
    this.getNominations();
  },
  data() {
    return {
      start: null,
      lastPage: 1,
      currentPage: 0,
      nominations: [],
      isFetchingNominations: false,
    };
  },
  methods: {
    getNominations($state) {
      if (this.isLastPage) {
        return false;
      }

      this.isFetchingNominations = true;

      this.$store
        .dispatch('listNominations', {
          page: this.currentPage + 1,
          start: this.start,
        })
        .then((res) => {
          if (! this.nominations.length) {
            this.start = res.data[0].id;
          }

          for (let nomination of res.data) {
            this.nominations.push(nomination);
          }

          this.lastPage    = res.last_page;
          this.currentPage = res.current_page;
        })
        .catch((err) => {
          console.error(err);
          // Prompt error toast
          this.$toast.error("Something went wrong", 'Error', {
            position: 'topRight'
          });
        })
        .finally(() => {
          if ($state !== undefined) {
            $state.loaded();
          }

          this.isFetchingNominations = false;
        });
    }
  },
  computed: {
    isLastPage() {
      return this.lastPage <= this.currentPage;
    }
  }
}
</script>
