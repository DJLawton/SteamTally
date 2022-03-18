<?php
session_start();
define('DOCROOT', $_SERVER['DOCUMENT_ROOT']);

require_once DOCROOT . "/includes/config.inc.php";
require_once DOCROOT . "/includes/debug.inc.php";
require_once DOCROOT . "/includes/functions.inc.php";

require DOCROOT . "/services/SteamAPIService.php";

if (isset($_POST['vanityurl'])) {
  try {
    getUserSummary($_POST['vanityurl']);
    header('Location:../tally?steamid=' . $_POST['vanityurl']);
  } catch (Exception $e) {
    debug_console($e);
    try {
      $_GET['steamid'] = getIdFromCustomURL($_POST['vanityurl']);
      header('Location:../tally?steamid=' . $_GET['steamid']);
    } catch (Exception $e) {
      debug_console($e);
      header('Location:../tally');
    }
  }
}
