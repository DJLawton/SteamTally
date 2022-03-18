<?php
require DOCROOT . "/exceptions/CurlRequestFailedException.php";
require DOCROOT . "/exceptions/CustomURLNotFoundException.php";
require DOCROOT . "/exceptions/UserNotFoundException.php";
require DOCROOT . "/exceptions/UserAppListNotFoundException.php";


function getIdFromCustomURL($vanityurl)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key=". APIKEY ."&vanityurl=" . $vanityurl);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = json_decode(curl_exec($ch), true)['response'];
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  if ($httpCode != 200) throw new CurlRequestFailedException($httpCode);
  if ($response['success'] != 1) throw new CustomURLNotFoundException($response['success']);
  return $response['steamid'];
}

function getUserSummary($steamid)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0001/?key=". APIKEY ."&steamids=" . $steamid);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = json_decode(curl_exec($ch), true)['response'];
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  if ($httpCode != 200) throw new CurlRequestFailedException($httpCode);
  if (!isset($response['players']['player']['0'])) throw new UserNotFoundException();
  return $response['players']['player']['0'];
}

function getUserApps($steamid)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=". APIKEY ."&steamid=" . $steamid . "&include_appinfo=true");
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = json_decode(curl_exec($ch), true)['response'];
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  if ($httpCode != 200) throw new CurlRequestFailedException($httpCode);
  if (!isset($response['games'])) throw new UserAppListNotFoundException();
  return $response['games'];
}

function getSortedUserApps($steamid)
{
  $userApps = getUserApps($steamid);
  $slimedUserApps = array();
  //Push to custom array
  foreach($userApps as $appInfo){
    array_push($slimedUserApps, array(
      'appid' => $appInfo['appid'],
      'name' => $appInfo['name'], 
      'playtime_2weeks' => isset($appInfo['playtime_2weeks']) ? $appInfo['playtime_2weeks'] : 0,
      'playtime_forever' => $appInfo['playtime_forever'],
      'icon_url' => $appInfo['img_icon_url']
    ));
  }
  //Sort according to playtime, descending
  array_multisort(array_column($slimedUserApps, 'playtime_forever'), SORT_DESC, $slimedUserApps);
  return $slimedUserApps;
}
