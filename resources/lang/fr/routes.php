<?php
return [
    "login" => "utilisateur/connexion",
    "logout" => "utilisateur/deconnexion",
    "register" => "utilisateur/inscription",
    "password-email" => "utilisateur/mot-de-passe/email",
    "password-reset" => "utilisateur/mot-de-passe/recomposer",
    "password-reset-token" => "utilisateur/mot-de-passe/recomposer/{token}",

    "ads" => "annonces",
    "ads-create" => "annonces/créer",
    "ads-single" => "annonces/{id}",
    "ads-single-edit" => "annonces/{id}/modifier",
    "ads-single-update" => "annonces/{id}/mettre-a-jour",
    "ads-single-update-cancel" => "annonces/{id}/abandoner-mettre-a-jour",
    "ads-single-delete" => "annonces/{id}/effacer",
    "ads-single-favorite" => "annonces/{id}/favorie",
    "ads-single-report" => "annonces/{id}/reporter",

    "user-settings" => "{user_name}/paramètres",
    "user-favorites" => "{user_name}/favoris",
    "phone" => "utilisateur/numéro-de-téléphone",
    "phone_verify" => "utilisateur/verifier-numéro-de-téléphone",
    "user" => "utilisateur"
];