require('./bootstrap');

window.Vue = require('vue');
import Buefy from 'buefy';
Vue.use(Buefy);

import * as VueGoogleMaps from 'vue2-google-maps'
Vue.use(VueGoogleMaps, {
    installComponents: true,
    load: {
        key: 'AIzaSyAiTDLF-TUKkzbnLoXSUpUh75TmvcuIkoE',
        libraries: 'places'
    }
});


window.events = new Vue();
window.flash = function (message, type = 'is-primary', position = 'is-bottom-right', duration = 3500, actionText = null, callback = null) {
    window.events.$emit('flash', {message, type, position, duration, actionText, callback});
};
window.toast = function (message) {
    window.events.$emit('toast', message);
};

Vue.component('flash', require('./components/FlashComponent.vue'));

Vue.component('cat-create-view', require('./pages/categories/Create.vue'));
Vue.component('prod-create-view', require('./pages/producers/Create.vue'));
Vue.component('prod-index-view', require('./pages/producers/Index.vue'));
Vue.component('prod-edit-view', require('./pages/producers/Edit.vue'));
Vue.component('prod-show-view', require('./pages/producers/Show.vue'));

const app = new Vue({
    el: '#app'
});

document.addEventListener('DOMContentLoaded', function () {
    var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
    if ($navbarBurgers.length > 0) {
        $navbarBurgers.forEach(function ($el) {
            $el.addEventListener('click', function () {
                var target = $el.dataset.target;
                var $target = document.getElementById(target);
                $el.classList.toggle('is-active');
                $target.classList.toggle('is-active');
            });
        });
    }

});
