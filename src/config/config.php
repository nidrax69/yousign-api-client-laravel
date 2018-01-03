<?php
return array(
    /*
    # Environnements de la l'API possibles
    *   - demo
    *       Environnement de démo.
    *       Les signatures de cette environnement ne sont pas légales.
    *   - prod
    *       Environnement de production.
    *       Les signatures de cette environnement sont (bien sûr) légales.
    *
    */
    'environment' => "demo",
    // Votre identifiant Yousign
    'login' => "VOTRE_LOGIN",
    // Votre mot de passe Yousign
    'password' => "VOTRE_MOT_DE_PASSE",
    // Indique si le mot de passe passé et crypté ou non (A décommenter si le mot de passe passé et crypté)
    'isEncryptedPassword' => false,
    // clef d'api
    'api_key' => "VOTRE_API_KEY",
);
