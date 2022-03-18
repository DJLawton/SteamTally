<?php
//Au cas ou config.php n'est pas bien configuré.
if(SITESTATE === null){
    define("SITESTATE", "prod");
}

//test pour effacer tous les messages php
if(SITESTATE === "prod"){
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}else{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

//fonction personnalisées de débug
function debug($variable, $isDie = false){
    if(SITESTATE !== "prod"){
        echo "<pre>";
        var_dump($variable);
        echo "</pre>";
        if($isDie){
            die();
        }
    }
}

//déboguage avec la console javascript
function debug_console($variable){
    if(SITESTATE !== "prod"){
        $output = $variable;
        if ( is_array( $output ) ){
            $output = implode( ',', $output);
        }

        echo "<script>console.log( 'PHP debug: " . $output . "' );</script>";
    }
}
