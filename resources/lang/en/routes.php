<?php
return [
    "login" => "user/login",
    "logout" => "user/logout",
    "register" => "user/register",
    "user" => "user",
    "password-email" => "user/password/email",
    "password-reset" => "user/password/reset",
    "password-reset-token" => "user/password/reset/{token}",

    "ads" => "ads",
    "ads-create" => "ads/create",
    "ads-single" => "ads/{id}",
    "ads-single-edit" => "ads/{id}/edit",
    "ads-single-update" => "ads/{id}/update",
    "ads-single-update-cancel" => "ads/{id}/cancel-update",
    "ads-single-delete" => "ads/{id}/delete",
    "ads-single-favorite" => "ads/{id}/favorite",
    "ads-single-unfavorite" => "ads/{id}/unfavorite",
    "ads-single-report" => "ads/{id}/report",
    "ads-single-dereport" => "ads/{id}/dereport",

    "user-settings" => "{user_name}/settings",
    "user-favorites" => "{user_name}/favorites",
    "phone" => "user/phone-number",
    "phone_verify" => "user/verify-phone",
];