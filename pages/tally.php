<?php require DOCROOT . "/services/SteamAPIService.php"; ?>
<!doctype html>
<html class="no-js" lang="fr">
<?php require DOCROOT . "/includes/head.inc.php"; ?>

<body>
  <?php require DOCROOT . "/includes/header.inc.php"; ?>
  <main class="container">
    <div>
      <?php
      if (isset($_GET['steamid'])) {
        try {
          $userSummary = getUserSummary($_GET['steamid']);

          //User info
          echo '<img src="' . $userSummary['avatarfull'] . '" alt="User avatar" width="184" height="184"/>';
          echo '<h2>Username : ' . $userSummary['personaname'] . '</h2>';
          echo '<h4>Profile visibility : ' . PRIVACYLEVELS[$userSummary['communityvisibilitystate']] . '</h4>';
          $sortedUserApps = getSortedUserApps($_GET['steamid']);
          //Total hours
          $totalPlaytimeInMinutes = array_sum(array_column($sortedUserApps, 'playtime_forever'));
          $playtimesHours = floor($totalPlaytimeInMinutes / 60);
          $playtimesMinutes = $totalPlaytimeInMinutes - $playtimesHours * 60;
          echo '<h4>TOTAL TIME : ' . $playtimesHours . 'h ' . $playtimesMinutes . 'm</h4>';

          //Sorted list of hours
          echo '<div class="list-group list-group-flush">';
          foreach ($sortedUserApps as $appInfo) {
            $playtimeHours = floor($appInfo['playtime_forever'] / 60);
            $playtimeMinutes = $appInfo['playtime_forever'] - $playtimeHours * 60;
      ?>
            <div class="list-group-item p-0">
              <div class="d-flex w-100 justify-content-between">
                <div>
                  <img src="http://media.steampowered.com/steamcommunity/public/images/apps/<?php echo $appInfo['appid']; ?>/<?php echo $appInfo['icon_url']; ?>.jpg" width="24" height="24">
                  <span><?php echo $appInfo['name']; ?></span>
                </div>
                <span><?php echo $playtimeHours; ?>h <?php echo sprintf("%02d", $playtimeMinutes); ?>m</span>
              </div>
            </div>
      <?php
          }
          echo '</div>';
        } catch (Exception $e) {
          print($e);
        }
      }
      ?>
    </div>
  </main>
  <?php
  require DOCROOT . "/includes/footer.inc.php";
  require DOCROOT . "/includes/javascript.inc.php";
  ?>
</body>

</html>