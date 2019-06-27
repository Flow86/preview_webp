<?php
namespace OCA\PreviewWebp\Preview;

require __DIR__ . '/../../vendor/autoload.php';

class Webp extends \OC\Preview\Image {
	/**
	 * {@inheritDoc}
	 */
	public function getMimeType() {
		return '/image\/webp/';
	}
}
