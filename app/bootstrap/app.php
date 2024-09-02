<?php

namespace App;

require "vendor/autoload.php";

use App\Api\Modules\Client\ClientController;
use Raven\Core\App;
use Raven\Core\AppConfig;
use Raven\Quail\Builders\OpenApiDocumentBuilder;
use Raven\Quail\Documentation;

$appConfig = new AppConfig(
	controllers: [
		ClientController::class
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
