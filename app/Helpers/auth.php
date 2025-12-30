<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Retourne true si un utilisateur est connecté
 * @return bool
 */
function isLogged(): bool {
    return !empty($_SESSION['user']);
}

/**
 * Retourne les données de l'utilisateur connecté ou null
 * @return array|null
 */
function currentUser(): ?array {
    return $_SESSION['user'] ?? null;
}

/**
 * Force la connexion : redirige vers la page de login si non connecté.
 * @param string $redirectTo url de retour après connexion (optionnel)
 */
function requireLogin(string $redirectTo = '/?page=auth&action=login') {
    if (!isLogged()) {
        header('Location: ' . $redirectTo);
        exit;
    }
}

/**
 * Vérifie si l'utilisateur est admin (utilise le champ 'role' si présent)
 * @return bool
 */
function isAdmin(): bool {
    $u = currentUser();
    if (!$u) return false;
    return isset($u['role']) && $u['role'] === 'admin';
}


function doLogin(array $user) {
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => $user['id'],
        'email' => $user['email'],
        'fullname' => $user['fullname'] ?? '',
        'role' => $user['role'] ?? 'user'
    ];
}


function doLogout() {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}
