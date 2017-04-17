const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

elixir((mix) => {
    mix.styles([
        'vendors/semantic.css',
        'vendors/slick.css',
        'vendors/slick-theme.css',
        'vendors/remodal.css',
        'vendors/remodal-default-theme.css',
        'vendors/iziToast.min.css',
        ], 'public/css/vendors.css');

    mix.scripts(
        [
            'vendors/jquery.min.js',
            'vendors/semantic.js',
            'vendors/slick.js',
            'vendors/hammer.min.js',
            'vendors/eg.js',
            'vendors/remodal.js',
            'vendors/siema.min.js',
            'vendors/clipboard.min.js',
        ]
        , 'public/js/vendors.js');

    mix.webpack('home/page.js', 'public/js/home.js');

    mix.webpack('auth/register.js', 'public/js/register.js');

    mix.webpack('ads/create.js', 'public/js/create.js');
    mix.webpack('ads/edit.js', 'public/js/edit.js');
    mix.webpack('ads/multiple.js', 'public/js/multiple.js');
    mix.webpack('ads/single.js', 'public/js/single.js');

    mix.webpack('profile/settings.js', 'public/js/user-settings.js');
    mix.webpack('profile/profile.js', 'public/js/user-profile.js');

    mix.webpack('admin/pages/layout.js', 'public/js/admin-page-layout.js');
    mix.webpack('admin/pages/ads.js', 'public/js/admin-page-ads.js');
    mix.webpack('admin/pages/review-ad.js', 'public/js/admin-page-review-ad.js');
});
