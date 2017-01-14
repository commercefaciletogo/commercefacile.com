const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

elixir((mix) => {
    mix.styles(['vendors/semantic.css'], 'public/css/vendors.css');

    mix.scripts(['vendors/jquery.min.js', 'vendors/semantic.js', 'vendors/sly.js'], 'public/js/vendors.js');

    mix.webpack('home/page.js', 'public/js/home.js');
    mix.webpack('ads/create.js', 'public/js/create.js');

    mix.version(['css/vendors.css', 'js/vendors.js']);
});
