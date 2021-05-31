<template>
  <b-modal centered id="modal-selection-badge" title="Select Badge" @ok="handleConfirm">
    <!-- <b-form-radio-group id="badges" v-model="badge_id" name="selectedBadge">
      <b-form-radio v-for="(b, idx) in badges"
        v-bind:key="idx"
        v-bind:value="b.id">
        {{ b.title }}
      </b-form-radio>
    </b-form-radio-group> -->
    <b-row v-if="badges.length" class="text-center justify-content-md-center mb-3">
      <b-col cols="3" v-for="i in 4" v-bind:key="i">
        <a class="badge-link"
          v-on:click="selectBadge(badges[i-1].id)"
          v-bind:class="{ 'active': isSelectedBadge(badges[i-1]) }">
          <img v-bind:src="badges[i-1].image"
            v-bind:alt="badges[i-1].title"
            class="modal-selection-badge--badge" />
          <div>
            {{ badges[i-1].title }}
          </div>
        </a>
      </b-col>
    </b-row>
    <b-row v-if="badges.length" class="text-center justify-content-md-center">
      <b-col cols="3" v-for="i in 3" v-bind:key="i">
        <a class="badge-link"
          v-on:click="selectBadge(badges[i+3].id)"
          v-bind:class="{ 'active': isSelectedBadge(badges[i+3]) }">
          <img v-bind:src="badges[i+3].image"
            v-bind:alt="badges[i+3].title"
            class="modal-selection-badge--badge" />
          <div>
            {{ badges[i+3].title }}
          </div>
        </a>
      </b-col>
    </b-row>
  </b-modal>
</template>

<script>
export default {
  mounted() {
    this.initialize();
  },
  data() {
    return {
      badges: [],
      badge_id: null,
    }
  },
  methods: {
    initialize() {
      this.badges = $h.getConstant('badges');
    },
    selectBadge(id) {
      this.badge_id = id;
    },
    handleConfirm() {
      let selectedBadge = _.find(this.badges, { id: this.badge_id });

      if (selectedBadge === undefined) {
        alert("You must select a badge!")
      } else {
        this.$emit('confirm', selectedBadge);
      }
    }
  },
  computed: {
    isSelectedBadge() {
      return (badge) => {
        return this.badge_id === badge.id;
      }
    }
  }
}
</script>

<style lang="scss" scoped>
#modal-selection-badge {
  .badge-link {
    & {
      display: block;
      padding: 8px;
      border-radius: 4px;
      font-size: 0.75rem;
    }
    .modal-selection-badge--badge {
      width: 50px;
      padding: 2px;
      margin-bottom: 4px;
      border-radius: 100%;
      background-color: #FFFFFF;
    }
  }
  .badge-link:hover {
    background-color: rgba(#000000, 0.06);
  }
  .badge-link.active {
    color: #FFFFFF !important;
    background-color: #00a73b !important;
  }
}
</style>
