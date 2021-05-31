<template>
  <div id="activity-board-card">
    <b-card class="activity-card text-center m-0 mb-4" v-if="recipient !== null && sender !== null">
      <header>
        <b-row align-v="center" class="m-0">
          <b-col cols="3" class="m-0 p-0">
            <img class="img-thumbnail rounded-circle avatar" v-bind:src="recipient.avatar" alt="Account Avatar" />
          </b-col>
          <b-col cols="9" class="receiver-detail m-0 pr-0 text-justify">
            <span class="name text-truncate">{{ recipient.name }}</span><br>
            <span class="department">HR Dept.</span>
          </b-col>
        </b-row>
      </header>
      <hr>
      <div class="testimonial text-left">
        <div v-if="badge" class="text-center mb-3 testimonial--badge">
          <img v-bind:src="badge.image" v-bind:alt="badge.title" class="mb-1">
          <div class="testimonial--badge-label">{{ badge.title }}</div>
        </div>
        <div class="testimony-container">
          <span class="giver-name">{{ recipient.name }}</span>,<br>
          <div class="testimony">{{ nomination.message }}</div>
        </div>
      </div>
      <hr>
      <footer>
        <a href="#" class="text-dark"><i class="far fa-thumbs-up"></i> Great Job!</a>
      </footer>
    </b-card>
    <b-card class="text-center m-0 mb-4" v-else>
      <hr>
      <h1>Fetching data...</h1>
      <hr>
    </b-card>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  mounted() {
    this.initialize();
  },
  data() {
    return {
      recipient: null,
      sender: null,
      badges: $h.getConstant('badges'),
    };
  },
  methods: {
    initialize() {
      this.recipient = this.nomination.recipient;
      this.sender = this.nomination.sender;
      this.badges = $h.getConstant('badges');
    }
  },
  computed: {
    badge() {
      let badge = _.find(this.badges, { id: this.nomination.badge_id });

      if (badge === undefined) {
        return null;
      }

      return badge;
    }
  },
  props: {
    nomination: { type: Object, required: true }
  },
}
</script>

<style lang="scss" scoped>
#activity-board-card {
  .activity-card {
    height: 93%;

    .avatar {
      width: 50px;
      height: 50px;
    }
    .testimonial {
      .testimonial--badge {
        img {
          width: 50%;
        }
        .testimonial--badge-label {
          font-weight: 600;
        }
      }
      .testimony-container {
        & {
          height: 70px;
          overflow: auto;
        }
        .testimony {
          text-overflow: ellipsis;
          overflow: hidden;
        }
      }
    }
    .receiver-detail {
      line-height: 20px;

      .name {
        font-weight: bold;
      }
      .department {
        font-size: 0.8rem;
      }
    }
  }
}
</style>
