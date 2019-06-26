<?php
declare(strict_types=1);

namespace OCA\PreviewWebp\AppInfo;

use OCP\AppFramework\App;

$app              = new App('preview_webp');
$container        = $app->getContainer();

$eventDispatcher = \OC::$server->getEventDispatcher();
$eventDispatcher->addListener('OCA\Files::loadAdditionalScripts', function() {
  script('preview_webp', 'register-viewer');  // adds js/script.js
});

$mimeTypeDetector = \OC::$server->getMimeTypeDetector();

$mimes_to_detect = [
    'webp' => ['image/webp'],
    'webm' => ['video/webm'],
];
$mimeTypeDetector->registerTypeArray($mimes_to_detect);

$previewManager = $container->getServer()->query('PreviewManager');
$previewManager->registerProvider('/image\/webp/', function () {
    return new \OCA\PreviewWebp\Preview\Webp;
});
