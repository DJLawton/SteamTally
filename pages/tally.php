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
          $userSummary = getUserSummary($_GET['steamid']); ?>
          <div class="text-center">
            <img src="<?php echo $userSummary['avatarfull']; ?>" alt="User avatar" width="184" height="184" />
            <h2>Username : <?php echo $userSummary['personaname']; ?></h2>
            <h4>Profile visibility : <?php echo PRIVACYLEVELS[$userSummary['communityvisibilitystate']]; ?></h4>
            <?php
            //Total hours
            $sortedUserApps = getSortedUserApps($_GET['steamid']);
            $totalPlaytimeInMinutes = array_sum(array_column($sortedUserApps, 'playtime_forever'));
            $playtimesHours = floor($totalPlaytimeInMinutes / 60);
            $playtimesMinutes = $totalPlaytimeInMinutes - $playtimesHours * 60;
            ?>
            <h4>TOTAL TIME : <?php echo $playtimesHours; ?>h <?php echo $playtimesMinutes; ?>m</h4>
          </div>
          <div>
            <?php
            //Sorted list of hours
            foreach ($sortedUserApps as $appInfo) {
              //Forever
              $playtimeForeverHours = floor($appInfo['playtime_forever'] / 60);
              $playtimeForeverMinutes = $appInfo['playtime_forever'] - $playtimeForeverHours * 60;
              //Recent
              $playtimeRecentHours = floor($appInfo['playtime_2weeks'] / 60);
              $playtimeRecentMinutes = $appInfo['playtime_2weeks'] - $playtimeRecentHours * 60;
            ?>
              <div class="row border-bottom <?php if ($appInfo['playtime_2weeks'] > 0) echo 'border-success'; ?>">
                <div class="col-lg-10 col-md-8 col-12 p-0">
                  <?php if ($appInfo['icon_url'] != "")
                    echo '<img src="http://media.steampowered.com/steamcommunity/public/images/apps/' . $appInfo['appid'] . '/' . $appInfo['icon_url'] . '.jpg" width="24" height="24">';
                  ?>
                  <span><?php echo $appInfo['name']; ?></span>
                </div>
                <div class="col-lg-1 col-md-2 col-sm-10 col-8 p-0 text-end">
                  <?php echo $playtimeForeverHours; ?>h <?php echo sprintf("%02d", $playtimeForeverMinutes); ?>m
                </div>
                <div class="col-lg-1 col-md-2 col-sm-2 col-4 p-0 text-end">

                  <div class="text-success">
                    <?php if ($appInfo['playtime_2weeks'] > 0) {
                      echo $playtimeRecentHours . 'h ' . sprintf("%02d", $playtimeRecentMinutes) . 'm';
                    } ?>
                  </div>
                </div>
              </div>
          </div>
    <?php
            }
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