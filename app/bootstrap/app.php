<?php

namespace App;

require "vendor/autoload.php";

use App\Api\Modules\Amenity\AmenityController;
use App\Api\Modules\Auth\AuthController;
use App\Api\Modules\Client\ClientController;
use App\Api\Modules\Collaborator\CollaboratorController;
use App\Api\Modules\Property\PropertyController;
use Raven\Core\App;
use Raven\Core\AppConfig;
use Raven\Quail\Builders\OpenApiDocumentBuilder;
use Raven\Quail\Documentation;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header(
	"Access-Control-Allow-Headers: Content-Type, Authorization, Content-Length"
);

$appConfig = new AppConfig(
	controllers: [
		ClientController::class,
		CollaboratorController::class,
		PropertyController::class,
		AmenityController::class,
		AuthController::class,
	],
	basePath: "/api"
);

$document = new Documentation($appConfig);
$OADocumentBuilder = new OpenApiDocumentBuilder(
	"Raven documentação",
	"teste de geração do swagger automaticamente",
	"1.0"
);

$document->setup("/docs", $OADocumentBuilder);
App::bootstrap($appConfig);
