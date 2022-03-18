<?php
// ========================================
// Section concernant les cookies
// ========================================

// Création d'une variable de cookie
// En paramètre le nom et la valeur de la variable
function create_cookie($nom_cookie, $valeur_cookie = "", $nb_jours = 365)
{
   // On créer notre variable de cookie à partir d'un paramètre
   setcookie($nom_cookie, $valeur_cookie, time() + $nb_jours * 24 * 3600, "/", null, false, true);
   //si tout s'est bien déroulé
   if (isset($_COOKIE[$nom_cookie])) {
      return true;
   } else {
      return false;
   }
}

// Lecture d'une variable de cookie
// En paramètre le nom de la variable
function read_cookie($nom_cookie)
{
   if (isset($_COOKIE[$nom_cookie])) {
      return $_COOKIE[$nom_cookie];
   } else {
      return false;
   }
}

// Mise à jour d'une variable de cookie
// En paramètre le nom et la valeur de la variable
function update_cookie($nom_cookie, $valeur_cookie, $nb_jours = 365)
{
   if (isset($_COOKIE[$nom_cookie])) {
      setcookie($nom_cookie, $valeur_cookie, time() + $nb_jours * 24 * 3600, null, null, false, true);
      return true;
   } else {
      return false;
   }
}

// Suppression d'une variable de cookie
// En paramètre le nom de la variable
function delete_cookie($nom_cookie)
{
   if (isset($_COOKIE[$nom_cookie])) {
      unset($_COOKIE[$nom_cookie]);
      setcookie($nom_cookie, '', time() - 3600, '/');
      return true;
   } else {
      return false;
   }
}

// Destruction compléte des cookies
// Source: http://www.php.net/manual/en/function.setcookie.php#73484
function destroy_cookies()
{
   // on réinitialise toutes les variables
   if (isset($_SERVER['HTTP_COOKIE'])) {
      $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
      foreach ($cookies as $cookie) {
         $parts = explode('=', $cookie);
         $name = trim($parts[0]);
         setcookie($name, '', time() - 1000);
         setcookie($name, '', time() - 1000, '/');
      }
      return true;
   } else {
      return false;
   }
}

// ========================================
// Section concernant les sessions
// ========================================


// Création d'une variable de session
// En paramètre le nom et la valeur de la variable
function create_session($nom_session, $valeur_session = "")
{
   // On créer notre variable de session à partir d'un paramètre
   $_SESSION[$nom_session] = $valeur_session;
   //si tout s'est bien déroulé
   if (isset($_SESSION[$nom_session])) {
      return true;
   } else {
      return false;
   }
}

// Lecture d'une variable de session
// En paramètre le nom de la variable
function read_session($nom_session)
{
   if (isset($_SESSION[$nom_session])) {
      return $_SESSION[$nom_session];
   } else {
      return false;
   }
}

// Mise à jour d'une variable de session
// En paramètre le nom et la valeur de la variable
function update_session($nom_session, $valeur_session)
{
   if (isset($_SESSION[$nom_session])) {
      $_SESSION[$nom_session] = $valeur_session;
      return true;
   } else {
      return false;
   }
}

// Suppression d'une variable de session
// En paramètre le nom de la variable
function delete_session($nom_session)
{
   if (isset($_SESSION[$nom_session])) {
      unset($_SESSION[$nom_session]);
      return true;
   } else {
      return false;
   }
}

// Destruction compléte de la session
// Source: http://www.php.net/manual/en/function.session-destroy.php
function destroy_session()
{
   // on réinitialise toutes les variables
   unset($_SESSION);
   // il faut détruire aussi les cookies associés aux sessions.
   if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(
         session_name(),
         '',
         time() - 42000,
         $params["path"],
         $params["domain"],
         $params["secure"],
         $params["httponly"]
      );
   }
   // finalement on détruie la session
   return session_destroy();
}

// ========================================
// Section concernant les fonctions uniques
// ========================================

function redirect($url = "/")
{
   header('Location : ' . $url);
   die();
}

