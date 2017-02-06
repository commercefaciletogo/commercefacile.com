const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

elixir((mix) => {
    mix.styles([
        'vendors/semantic.css',
        'vendors/slick.css',
        'vendors/slick-theme.css',
        'vendors/remodal.css',
        'vendors/remodal-default-theme.css',
        ], 'public/css/vendors.css');

    mix.scripts(
        [
            'vendors/jquery.min.js',
            'vendors/semantic.js',
            'vendors/slick.js',
            'vendors/hammer.min.js',
            'vendors/eg.js',
            'vendors/remodal.js',
        ]
        , 'public/js/vendors.js');

    mix.webpack('event.js', 'public/js/event.js');

    mix.webpack('home/page.js', 'public/js/home.js');
    mix.webpack('ads/create.js', 'public/js/create.js');
    mix.webpack('ads/multiple.js', 'public/js/multiple.js');

    mix.version(['css/vendors.css', 'js/vendors.js']);
});
