<?php
namespace OCA\PreviewWebp\Preview;

require __DIR__ . '/../../vendor/autoload.php';

use OCP\Files\FileInfo;
use OCP\Preview\IProvider;

class Webp implements IProvider
{
    public function getMimeType()
    {
        return '/image\/webp/';
    }

	public function getThumbnail($path, $maxX, $maxY, $scalingup, $fileview) {
		//get fileinfo
		$fileInfo = $fileview->getFileInfo($path);
		if (!$fileInfo) {
			return false;
		}

		$maxSizeForImages = \OC::$server->getConfig()->getSystemValue('preview_max_filesize_image', 50);
		$size = $fileInfo->getSize();

		if ($maxSizeForImages !== -1 && $size > ($maxSizeForImages * 1024 * 1024)) {
			return false;
		}

		$image = new \OC_Image();

		$useTempFile = $fileInfo->isEncrypted() || !$fileInfo->getStorage()->isLocal();
		if ($useTempFile) {
			$fileName = $fileview->toTmpFile($path);
		} else {
			$fileName = $fileview->getLocalFile($path);
		}
		$image->loadFromFile($fileName);
		$image->fixOrientation();
		if ($useTempFile) {
			unlink($fileName);
		}
		if ($image->valid()) {
			$image->scaleDownToFit($maxX, $maxY);

			return $image;
		}
		return false;
	}

	public function isAvailable(FileInfo $file) {
		return true;
	}
}
