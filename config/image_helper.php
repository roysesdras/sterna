<?php
/**
 * Helper de compression et redimensionnement automatique des images uploadées - Sterna Africa.
 * Prise en charge automatique de la rotation EXIF (iPhone, Android).
 */
function compress_uploaded_image($filepath, $max_dim = 1200, $quality = 82) {
    if (!file_exists($filepath)) return false;
    $info = @getimagesize($filepath);
    if (!$info) return false;

    $mime = $info['mime'];
    switch ($mime) {
        case 'image/jpeg':
            $image = @imagecreatefromjpeg($filepath);
            // Corriger la rotation EXIF pour éviter qu'elle soit à l'envers ou tournée
            if ($image && function_exists('exif_read_data')) {
                $exif = @exif_read_data($filepath);
                if (!empty($exif['Orientation'])) {
                    switch ($exif['Orientation']) {
                        case 3:
                            $image = imagerotate($image, 180, 0);
                            break;
                        case 6:
                            $image = imagerotate($image, -90, 0);
                            break;
                        case 8:
                            $image = imagerotate($image, 90, 0);
                            break;
                    }
                }
            }
            break;
        case 'image/png':
            $image = @imagecreatefrompng($filepath);
            break;
        case 'image/webp':
            $image = @imagecreatefromwebp($filepath);
            break;
        default:
            return false;
    }

    if (!$image) return false;

    $orig_w = imagesx($image);
    $orig_h = imagesy($image);

    if ($orig_w > $max_dim || $orig_h > $max_dim) {
        $ratio = min($max_dim / $orig_w, $max_dim / $orig_h);
        $new_w = (int)($orig_w * $ratio);
        $new_h = (int)($orig_h * $ratio);

        $resized = imagecreatetruecolor($new_w, $new_h);
        if ($mime === 'image/png' || $mime === 'image/webp') {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
        }
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $new_w, $new_h, $orig_w, $orig_h);
        imagedestroy($image);
        $image = $resized;
    }

    if ($mime === 'image/jpeg') {
        imagejpeg($image, $filepath, $quality);
    } elseif ($mime === 'image/png') {
        imagepng($image, $filepath, 8);
    } elseif ($mime === 'image/webp') {
        imagewebp($image, $filepath, $quality);
    }

    imagedestroy($image);
    @chmod($filepath, 0644);
    return true;
}
