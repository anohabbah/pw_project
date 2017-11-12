require('./bootstrap');

window.Vue = require('vue');
import Buefy from 'buefy';


window.events = new Vue();
window.flash = function (message) {
    window.events.$emit('flash', message);
};

Vue.use(Buefy);

Vue.component('flash', require('./components/FlashComponent.vue'));

Vue.component('cat-create-view', require('./pages/categories/Create.vue'));

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
