import PartialHeader from './header.vue';
import PartialNavbar from './navbar.vue';

import RewardGiving from './reward-giving.vue';

import ModalSelectionUser from './modal-selection-user.vue';
import ModalSelectionBadge from './modal-selection-badge.vue';

import ActivityBoard from './activity-board.vue';
import ActivityBoardCard from './activity-board-card.vue';

Vue.component('partial-header', PartialHeader);
Vue.component('partial-navbar', PartialNavbar);

Vue.component('reward-giving', RewardGiving);

Vue.component('modal-selection-user', ModalSelectionUser);
Vue.component('modal-selection-badge', ModalSelectionBadge);

Vue.component('activity-board', ActivityBoard);
Vue.component('activity-board-card', ActivityBoardCard);
