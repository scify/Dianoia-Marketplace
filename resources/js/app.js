import "./jquery-global";
import "bootstrap";
import Vue from "vue";

import "./bootstrap";
import route from "./backend-route";

window.route = route;
import store from "./store/store";

import getLodash from "lodash/get";
import eachRightLodash from "lodash/eachRight";
import replaceLodash from "lodash/replace";
import * as Sentry from "@sentry/browser";
import ModalComponent from "./vue-components/common/ModalComponent.vue";
import ExercisesWithFilters from "./vue-components/resources/ExercisesWithFilters.vue";
import ExerciseComponent from "./vue-components/resources/ExerciseComponent.vue";

if (import.meta.env.VITE_SENTRY_DSN_PUBLIC) {
	Sentry.init({
		dsn: import.meta.env.VITE_SENTRY_DSN_PUBLIC,
	});
}

window.translate = function (string, args) {
	let value = getLodash(window.i18n, string);

	eachRightLodash(args, (paramVal, paramKey) => {
		value = replaceLodash(value, `:${paramKey}`, paramVal);
	});
	return value;
};

Vue.prototype.trans = (string, args) => {
	return window.translate(string, args);
};

Vue.component("modal-component", ModalComponent);
Vue.component("exercises-with-filters", ExercisesWithFilters);
Vue.component("exercise-component", ExerciseComponent);


new Vue({
	el: "#app",
	store: store
});
(function ($) {

	let init = function () {
		closeDismissableAlerts();
	};

	let closeDismissableAlerts = function () {
		setTimeout(function () {
			/*Close any flash message after some time*/
			$(".alert-dismissible").fadeTo(4000, 500).slideUp(500);
		}, 3000);
	};

	$(function () {
		$(document).ready(function () {
			init();
		});
	});

})(window.jQuery);

