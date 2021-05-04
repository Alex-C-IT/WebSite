<?php
namespace App\Attachment;

use App\Model\Partner;
use Intervention\Image\ImageManager;

class PartnerAttachment {

    const DIRECTORY = UPLOAD_PATH . DIRECTORY_SEPARATOR . 'partners';

    public static function upload(Partner $partner) {
        $image = $partner->getImage();
        if (empty($image) || $partner->shouldUpload() === false) {
            return;
        }
        $directory = self::DIRECTORY;
        if (file_exists($directory) === false) {
            mkdir($directory, 0777, true);
        }
        if (!empty($partner->getOldImage())) {
            $formats = ['small', 'large'];
            foreach($formats as $format) {
                $oldFile = $directory . DIRECTORY_SEPARATOR . $partner->getOldImage() . '_' . $format . '.jpg';
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }
        }
        $filename = uniqid("", true);
        $manager = new ImageManager(['driver' => 'gd']);
        $manager
            ->make($image)
            ->fit(160, 55)
            ->save($directory . DIRECTORY_SEPARATOR . $filename . '_small.jpg');
        $manager
            ->make($image)
            ->resize(1024, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($directory . DIRECTORY_SEPARATOR . $filename . '_large.jpg');
        $partner->setImage($filename);
    }

    public static function detach (Partner $partner) {
        if (!empty($partner->getImage())) {
            $formats = ['small', 'large'];
            foreach($formats as $format) {
                $file = self::DIRECTORY . DIRECTORY_SEPARATOR . $partner->getImage() . '_' . $format . '.jpg';
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
    }
    
}