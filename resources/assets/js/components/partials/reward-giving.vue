<template>
  <div id="reward-giving">
    <b-card-group deck>
      <b-card header="Nominations">
        <b-row align-v="center" class="text-center">
          <b-col cols="5">
            <img class="img-thumbnail rounded-circle" v-bind:src="user.avatar" /><br>
            <strong>{{ user.name || "You" }}</strong>
          </b-col>
          <b-col cols="2">
            <em>To</em><br>
            <i class="fas fa-arrow-right"></i>
          </b-col>
          <b-col cols="5">
            <b-btn v-b-modal.modal-selection-user variant="link" class="p-0">
              <img class="img-thumbnail rounded-circle" v-bind:src="receiver.avatar" />
            </b-btn>
            <br>
            <strong>{{ receiver.name }}</strong>
          </b-col>
        </b-row>
        <br>
        <b-row>
          <b-col cols="12">
            <b-form-textarea id="textarea1"
              v-model="message"
              v-bind:placeholder="'Your message here, ' + (user.name || 'User')"
              v-bind:rows="3"
              v-bind:max-rows="6">
            </b-form-textarea>
          </b-col>
        </b-row>
        <br>
        <b-row align-v="center">
          <b-col cols="6">
            <div class="nominations--button">C</div>
            <input class="currency-input" type="number" v-model="credits" min="1">
          </b-col>
          <b-col cols="6" class="text-right">
            <span class="nominations--button-label nominations--button-label__right">
              {{ badge.title || 'Select a badge' }}
            </span>
            <a v-show="isBadgeEmpty" v-b-modal.modal-selection-badge class="nominations--button">
              <i class="fas fa-star"></i>
            </a>
            <a v-show="!isBadgeEmpty" v-b-modal.modal-selection-badge class="nominations--button">
              <img v-bind:src="badge.image" v-bind:alt="badge.title" />
            </a>
          </b-col>
        </b-row>
        <hr>
        <b-button variant="success" block @click="submitNomination">Post</b-button>
      </b-card>
    </b-card-group>

    <!-- Modal Component -->
    <modal-selection-user @confirm="onRecipientSelected"></modal-selection-user>
    <modal-selection-badge @confirm="onBadgeSelected"></modal-selection-badge>
    
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  data() {
    return {
      message: null,
      recipient: {},
      credits: 1,
      badge: {},
    }
  },
  methods: {
    onRecipientSelected(user) {
      this.recipient = user;
    },
    onBadgeSelected(badge) {
      this.badge = badge;
    },
    submitNomination() {
      if (_.isEmpty(this.recipient) || ! this.recipient.hasOwnProperty('id')) {
        return alert("Please select a valid recipient!");
      }

      if (_.isEmpty(this.badge) || ! this.badge.hasOwnProperty('id')) {
        return alert("Please select a valid badge!");
      }

      this.$store
          .dispatch('sendNomination', this.getPayload())
          .then((res) => {
            this.resetForm();
          })
          .catch((err) => {
            _.forEach(err.data, (val, key) => {
              this.$toast.error(val[0], 'Error', {
                position: 'topRight'
              });
            });
          });
    },
    getPayload() {
      return {
        id: this.recipient.id,
        badge_id: this.badge.id,
        credits: Number(this.credits),
        message: this.message,
      };
    },
    resetForm() {
      this.message = null;
      this.recipient = {};
      this.credits = 1;
      this.badge = {};
    }
  },
  computed: {
    ...mapGetters([
      'user',
    ]),
    isBadgeEmpty() {
      return _.isEmpty(this.badge);
    },
    receiver() {
      if (_.isEmpty(this.recipient)) {
        return {
          id: null,
          name: 'Who?',
          avatar: '/img/default-avatar.png',
        }
      }

      return this.recipient;
    }
  }
}
</script>

<style lang="scss" scoped>
.nominations--button {
  & {
    width: 38px;
    height: 38px;
    line-height: 38px;
    display: inline-block;
    background: #00a73b;
    border-radius: 100%;
    color: #FFFFFF !important;
    text-align: center;
    vertical-align: middle;
  }
  img {
    width: 100%;
    height: 100%;
    display: block;
  }
}
.nominations--button-label {
  top: 0;
  bottom: 0;
  margin-top: auto;
  margin-bottom: auto;
  display: table;
  position: absolute;
  vertical-align: middle;
  font-size: 0.75rem;
}
.nominations--button-label__right {
  right: 0;
  margin-left: 15px;
  margin-right: 61px;
}
.nominations--button-label__left {
  left: 0;
  margin-left: 61px;
  margin-right: 15px;
}
.currency-input {
  display: inline-block;
  width: 50px;
  vertical-align: sub;
}
</style>

