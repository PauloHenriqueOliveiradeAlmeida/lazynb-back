<?php
require_once __DIR__ . "/shared/packages/http-response/http-response.php";

try {
  require_once __DIR__ . "/modules/auth/auth.route.php";
  require_once __DIR__ . "/modules/client/client.route.php";
  require_once __DIR__ . "/modules/collaborator/collaborator.route.php";
  require_once __DIR__ . "/modules/property/property.route.php";

}
catch(Exception $error) {
  HttpResponse::sendBody([
    "message" => $error->getMessage()
  ], HttpResponse::SERVER_ERROR);
}
