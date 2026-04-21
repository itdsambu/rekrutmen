<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Image_Moo library - PHP 8.1+ Compatible Patch
 *
 * Original by Matthew Augier (Mat-Moo) v1.1.6
 * Patched for PHP 8.1+ compatibility:
 *  - Replaced is_resource() checks with _is_gd_image() helper that handles both resource and GdImage object
 *  - Converted PHP 4 style constructor to __construct()
 *  - Added null safety for getimagesize()
 *
 * Drop-in replacement for application/libraries/Image_moo.php
 */

class Image_moo
{
    // image vars
    private $main_image = NULL;
    private $watermark_image = NULL;
    private $temp_image = NULL;
    private $jpeg_quality = 75;
    private $background_colour = "#ffffff";
    private $watermark_method;
    private $jpeg_ignore_warnings = FALSE;
    private $can_stretch = FALSE;

    // other
    private $filename = "";

    // watermark stuff, opacity
    private $watermark_transparency = 50;

    // reported errors
    public $errors = FALSE;
    private $error_msg = array();

    // image info
    public $width = 0;
    public $height = 0;
    public $new_width = 0;
    public $new_height = 0;

    public function __construct()
    {
        log_message('debug', "Image Moo Class Initialized (PHP 8.1+ patched)");
        if ($this->jpeg_ignore_warnings) $this->ignore_jpeg_warnings();
        if ($this->can_stretch) $this->allow_scale_up(TRUE);
    }

    /**
     * PHP 8.1+ compatibility helper: check if variable is a valid GD image
     * In PHP < 8.0: GD returns resource
     * In PHP >= 8.1: GD returns GdImage object
     */
    private function _is_gd_image($img)
    {
        if ($img === NULL || $img === FALSE) return FALSE;
        if (is_object($img) && $img instanceof \GdImage) return TRUE;
        if (is_resource($img)) return TRUE;
        return FALSE;
    }

    public function ignore_jpeg_warnings($onoff = TRUE)
    {
        ini_set('gd.jpeg_ignore_warning', $onoff == TRUE);
        return $this;
    }

    public function allow_scale_up($onoff = FALSE)
    {
        $this->can_stretch = $onoff;
        return $this;
    }

    private function _clear_errors()
    {
        $this->error_msg = array();
        $this->errors = FALSE;
    }

    private function set_error($msg)
    {
        $this->errors = TRUE;
        $this->error_msg[] = $msg;
    }

    public function display_errors($open = '<p>', $close = '</p>')
    {
        $str = '';
        foreach ($this->error_msg as $val) {
            $str .= $open . $val . $close;
        }
        return $str;
    }

    public function check_gd()
    {
        if (!extension_loaded('gd')) {
            $this->set_error('GD library does not appear to be loaded');
            return FALSE;
        }

        if (function_exists('gd_info')) {
            $gdarray = @gd_info();
            $versiontxt = preg_replace('/[A-Z,\ ()\[\]]/i', '', $gdarray['GD Version']);
            $versionparts = explode('.', $versiontxt);
            if ($versionparts[0] == "2") {
                return TRUE;
            } else {
                $this->set_error('Requires GD2, this reported as ' . $versiontxt);
                return FALSE;
            }
        } else {
            $this->set_error('Could not verify GD version');
            return FALSE;
        }
    }

    private function _check_image()
    {
        if (!$this->_is_gd_image($this->main_image)) {
            $this->set_error("No main image loaded!");
            return FALSE;
        }
        return TRUE;
    }

    function get_data_stream($filename = "")
    {
        if (!$this->_check_image()) return $this;
        $this->_copy_to_temp_if_needed();

        if ($filename == "") $filename = rand(1000, 999999) . ".jpg";
        $ext = strtoupper(pathinfo($filename, PATHINFO_EXTENSION));

        ob_start();

        switch ($ext) {
            case "GIF":
                imagegif($this->temp_image);
                break;
            case "JPG":
            case "JPEG":
                imagejpeg($this->temp_image);
                break;
            case "PNG":
                imagepng($this->temp_image);
                break;
            default:
                ob_end_clean();
                $this->set_error('Extension not recognised! Must be jpg/png/gif');
                return FALSE;
        }

        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }

    function save_dynamic($filename = "")
    {
        if (!$this->_check_image()) return $this;
        $this->_copy_to_temp_if_needed();

        if ($filename == "") $filename = rand(1000, 999999) . ".jpg";
        $ext = strtoupper(pathinfo($filename, PATHINFO_EXTENSION));
        header("Content-disposition: filename=$filename;");
        header('Content-transfer-Encoding: binary');
        header('Last-modified: ' . gmdate('D, d M Y H:i:s'));
        switch ($ext) {
            case "GIF":
                header("Content-type: image/gif");
                imagegif($this->temp_image);
                return $this;
            case "JPG":
            case "JPEG":
                header("Content-type: image/jpeg");
                imagejpeg($this->temp_image, NULL, $this->jpeg_quality);
                return $this;
            case "PNG":
                header("Content-type: image/png");
                imagepng($this->temp_image);
                return $this;
        }
        $this->set_error('Unable to save, extension not GIF/JPEG/JPG/PNG');
        return $this;
    }

    function save_pa($prepend = "", $append = "", $overwrite = FALSE)
    {
        if (!$this->_check_image()) return $this;
        $parts = pathinfo($this->filename);
        $this->save($parts["dirname"] . '/' . $prepend . $parts['filename'] . $append . '.' . $parts["extension"], $overwrite);
        return $this;
    }

    function save($filename, $overwrite = FALSE)
    {
        if (!$this->_check_image()) return $this;
        $this->_copy_to_temp_if_needed();

        if (!$overwrite) {
            if (file_exists($filename)) {
                $this->set_error('File exists, overwrite is FALSE, could not save over file ' . $filename);
                return $this;
            }
        }

        $ext = strtoupper(pathinfo($filename, PATHINFO_EXTENSION));
        switch ($ext) {
            case "GIF":
                imagegif($this->temp_image, $filename);
                return $this;
            case "JPG":
            case "JPEG":
                imagejpeg($this->temp_image, $filename, $this->jpeg_quality);
                return $this;
            case "PNG":
                imagepng($this->temp_image, $filename);
                return $this;
        }

        $this->set_error('Do not know what ' . $ext . ' filetype is in filename ' . $filename);
        return $this;
    }

    private function _load_image($filename)
    {
        if (!file_exists($filename)) {
            $this->set_error('Could not locate file ' . $filename);
            return FALSE;
        }

        $image_info = @getimagesize($filename);
        if ($image_info === FALSE) {
            $this->set_error('File is not a valid image: ' . $filename);
            return FALSE;
        }

        try {
            switch ($image_info["mime"]) {
                case "image/gif":
                    $img = @imagecreatefromgif($filename);
                    break;
                case "image/jpeg":
                    $img = @imagecreatefromjpeg($filename);
                    break;
                case "image/png":
                    $img = @imagecreatefrompng($filename);
                    break;
                default:
                    $this->set_error('Unable to load ' . $filename . ' filetype ' . $image_info["mime"] . ' not recognised');
                    return FALSE;
            }

            if (!$this->_is_gd_image($img)) {
                $this->set_error('GD failed to load ' . $filename . ' (corrupt or unsupported)');
                return FALSE;
            }

            return $img;
        } catch (Exception $e) {
            $this->set_error('Exception loading ' . $filename . ' - ' . $e->getMessage());
            return FALSE;
        }
    }

    public function load_temp()
    {
        if (!$this->_check_image()) return $this;

        if (!$this->_is_gd_image($this->temp_image)) {
            $this->set_error("No temp image created!");
            return FALSE;
        }

        $this->main_image = $this->temp_image;
        $this->temp_image = NULL; // jangan destroy, karena di-share ke main_image
        $this->_set_new_size();
        return $this;
    }

    public function load($filename)
    {
        $this->_clear_errors();
        $this->clear_temp();
        $this->filename = $filename;
        $this->width = 0;
        $this->height = 0;

        $this->main_image = $this->_load_image($filename);

        if ($this->_is_gd_image($this->main_image)) {
            $this->new_width = $this->width = imagesx($this->main_image);
            $this->new_height = $this->height = imagesy($this->main_image);
            $this->_set_new_size();
        }

        return $this;
    }

    public function load_watermark($filename, $transparent_x = NULL, $transparent_y = NULL)
    {
        if ($this->_is_gd_image($this->watermark_image)) imagedestroy($this->watermark_image);
        $this->watermark_image = $this->_load_image($filename);

        if ($this->_is_gd_image($this->watermark_image)) {
            $this->watermark_method = 1;
            if (($transparent_x !== NULL) && ($transparent_y !== NULL)) {
                $tpcolour = imagecolorat($this->watermark_image, $transparent_x, $transparent_y);
                imagecolortransparent($this->watermark_image, $tpcolour);
                $this->watermark_method = 2;
            }
        }

        return $this;
    }

    public function real_filesize()
    {
        if ($this->filename == "") {
            $this->set_error('Unable to get filesize, no filename!');
            return "-";
        }
        if (!file_exists($this->filename)) {
            $this->set_error('Unable to get filesize, file does not exist!');
            return "-";
        }

        $size = filesize($this->filename);
        $units = array(' B', ' KB', ' MB', ' GB', ' TB');
        for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;

        return round($size, 2) . $units[$i];
    }

    public function set_watermark_transparency($transparency = 50)
    {
        $this->watermark_transparency = $transparency;
        return $this;
    }

    public function set_background_colour($colour = "#ffffff")
    {
        $this->background_colour = $colour;
        return $this;
    }

    public function set_jpeg_quality($quality = 75)
    {
        $this->jpeg_quality = $quality;
        return $this;
    }

    private function _copy_to_temp_if_needed()
    {
        if (!$this->_is_gd_image($this->temp_image)) {
            $this->temp_image = imagecreatetruecolor($this->width, $this->height);

            if (!$this->_is_gd_image($this->temp_image)) {
                $this->set_error('Unable to create temp image sized ' . $this->width . ' x ' . $this->height);
                return FALSE;
            }

            imagecopy($this->temp_image, $this->main_image, 0, 0, 0, 0, $this->width, $this->height);
            $this->_set_new_size();
        }
    }

    public function clear()
    {
        if ($this->_is_gd_image($this->main_image)) imagedestroy($this->main_image);
        if ($this->_is_gd_image($this->watermark_image)) imagedestroy($this->watermark_image);
        if ($this->_is_gd_image($this->temp_image)) imagedestroy($this->temp_image);
        $this->main_image = NULL;
        $this->watermark_image = NULL;
        $this->temp_image = NULL;
        return $this;
    }

    public function clear_temp()
    {
        if ($this->_is_gd_image($this->temp_image)) imagedestroy($this->temp_image);
        $this->temp_image = NULL;
        return $this;
    }

    public function resize_crop($mw, $mh)
    {
        if (!$this->_check_image()) return $this;
        $this->clear_temp();

        $this->temp_image = imagecreatetruecolor($mw, $mh);
        if (!$this->_is_gd_image($this->temp_image)) {
            $this->set_error('Unable to create temp image sized ' . $mw . ' x ' . $mh);
            return $this;
        }

        $wx = $this->width / $mw;
        $wy = $this->height / $mh;

        if ($wx >= $wy) {
            $sy = 0;
            $sy2 = $this->height;
            $calc_width = $mw * $wy;
            $sx = ($this->width - $calc_width) / 2;
            $sx2 = $calc_width;
        } else {
            $sx = 0;
            $sx2 = $this->width;
            $calc_height = $mh * $wx;
            $sy = ($this->height - $calc_height) / 2;
            $sy2 = $calc_height;
        }

        imagealphablending($this->temp_image, false);
        imagesavealpha($this->temp_image, true);

        imagecopyresampled($this->temp_image, $this->main_image, 0, 0, $sx, $sy, $mw, $mh, $sx2, $sy2);

        $this->_set_new_size();
        return $this;
    }

    public function resize($mw, $mh = FALSE, $pad = FALSE)
    {
        if (!$this->_check_image()) return $this;

        if ($mh === FALSE) $mh = $mw;

        if ($this->width > $mw || $this->height > $mh || $this->can_stretch) {
            if (($this->width / $this->height) > ($mw / $mh)) {
                $tnw = $mw;
                $tnh = $tnw * $this->height / $this->width;
            } else {
                $tnh = $mh;
                $tnw = $tnh * $this->width / $this->height;
            }
        } else {
            $tnw = $this->width;
            $tnh = $this->height;
        }

        $this->clear_temp();

        if ($pad) {
            $tx = $mw;
            $ty = $mh;
            $px = ($mw - $tnw) / 2;
            $py = ($mh - $tnh) / 2;
        } else {
            $tx = $tnw;
            $ty = $tnh;
            $px = 0;
            $py = 0;
        }

        $this->temp_image = imagecreatetruecolor((int)$tx, (int)$ty);
        if (!$this->_is_gd_image($this->temp_image)) {
            $this->set_error('Unable to create temp image sized ' . $tx . ' x ' . $ty);
            return $this;
        }

        $col = $this->_html2rgb($this->background_colour);
        $bg = imagecolorallocate($this->temp_image, $col[0], $col[1], $col[2]);
        imagefilledrectangle($this->temp_image, 0, 0, (int)$tx, (int)$ty, $bg);

        imagecopyresampled($this->temp_image, $this->main_image, (int)$px, (int)$py, 0, 0, (int)$tnw, (int)$tnh, $this->width, $this->height);

        $this->_set_new_size();
        return $this;
    }

    public function stretch($mw, $mh)
    {
        if (!$this->_check_image()) return $this;
        $this->clear_temp();

        $this->temp_image = imagecreatetruecolor($mw, $mh);
        if (!$this->_is_gd_image($this->temp_image)) {
            $this->set_error('Unable to create temp image sized ' . $mh . ' x ' . $mw);
            return $this;
        }

        imagecopyresampled($this->temp_image, $this->main_image, 0, 0, 0, 0, $mw, $mh, $this->width, $this->height);
        $this->_set_new_size();
        return $this;
    }

    public function crop($x1, $y1, $x2, $y2)
    {
        if (!$this->_check_image()) return $this;
        $this->clear_temp();

        if ($x1 < 0 || $y1 < 0 || $x2 - $x1 > $this->width || $y2 - $y1 > $this->height) {
            $this->set_error('Invalid crop dimensions ' . $x1 . '/' . $y1 . ' x ' . $x2 . '/' . $y2);
            return $this;
        }

        $this->temp_image = imagecreatetruecolor($x2 - $x1, $y2 - $y1);
        if (!$this->_is_gd_image($this->temp_image)) {
            $this->set_error('Unable to create temp image sized ' . ($x2 - $x1) . ' x ' . ($y2 - $y1));
            return $this;
        }

        imagecopy($this->temp_image, $this->main_image, 0, 0, $x1, $y1, $x2 - $x1, $y2 - $y1);
        $this->_set_new_size();
        return $this;
    }

    private function _html2rgb($colour)
    {
        if (is_array($colour)) {
            if (count($colour) == 3) return $colour;
            $this->set_error('Colour error, array sent not 3 elements');
            return array(255, 255, 255);
        }
        if ($colour[0] == '#')
            $colour = substr($colour, 1);

        if (strlen($colour) == 6) {
            list($r, $g, $b) = array($colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);
        } elseif (strlen($colour) == 3) {
            list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
        } else {
            $this->set_error('Colour error, value sent not #RRGGBB or RRGGBB');
            return array(255, 255, 255);
        }

        return array(hexdec($r), hexdec($g), hexdec($b));
    }

    public function rotate($angle)
    {
        if (!$this->_check_image()) return $this;
        $this->_copy_to_temp_if_needed();

        $bg = imagecolorallocatealpha($this->temp_image, 0, 0, 0, 127);
        $this->temp_image = imagerotate($this->temp_image, $angle, $bg);
        imagealphablending($this->temp_image, false);
        imagesavealpha($this->temp_image, true);

        $this->_set_new_size();
        return $this;
    }

    public function make_watermark_text($text, $fontfile, $size = 16, $colour = "#ffffff", $angle = 0)
    {
        if (!file_exists($fontfile)) {
            $this->set_error('Could not locate font file "' . $fontfile . '"');
            return $this;
        }

        if (!$this->_check_image()) {
            $remove = TRUE;
            $this->main_image = imagecreatetruecolor(1000, 1000);
        } else {
            $remove = FALSE;
        }

        $bbox = imageftbbox($size, $angle, $fontfile, $text);
        $bw = abs($bbox[4] - $bbox[0]) + 1;
        $bh = abs($bbox[1] - $bbox[5]) + 1;
        $bl = $bbox[1];

        if ($this->_is_gd_image($this->watermark_image)) imagedestroy($this->watermark_image);
        $this->watermark_image = imagecreatetruecolor($bw, $bh);

        $col = $this->_html2rgb($colour);
        $font_col = imagecolorallocate($this->watermark_image, $col[0], $col[1], $col[2]);
        $bg_col = imagecolorallocate($this->watermark_image, 127, 128, 126);

        $this->watermark_method = 2;

        imagecolortransparent($this->watermark_image, $bg_col);
        imagefilledrectangle($this->watermark_image, 0, 0, $bw, $bh, $bg_col);

        imagefttext($this->watermark_image, $size, $angle, 0, $bh - $bl, $font_col, $fontfile, $text);

        if ($remove) imagedestroy($this->main_image);
        return $this;
    }

    public function watermark($position, $offset = 8, $abs = FALSE)
    {
        if (!$this->_check_image()) return $this;
        if (!$this->_is_gd_image($this->watermark_image)) {
            $this->set_error("Can't watermark image, no watermark loaded/created");
            return $this;
        }

        $this->_copy_to_temp_if_needed();

        $wm_w = imagesx($this->watermark_image);
        $wm_h = imagesy($this->watermark_image);
        $temp_w = imagesx($this->temp_image);
        $temp_h = imagesy($this->temp_image);

        if ($wm_w > $temp_w || $wm_h > $temp_h) {
            $this->set_error("Watermark is larger than image. WM: $wm_w x $wm_h Temp image: $temp_w x $temp_h");
            return $this;
        }

        if ($abs) {
            $dest_x = $position;
            $dest_y = $offset;
        } else {
            switch ($position) {
                case "7":
                case "4":
                case "1":
                    $dest_x = $offset;
                    break;
                case "8":
                case "5":
                case "2":
                    $dest_x = ($temp_w - $wm_w) / 2;
                    break;
                case "9":
                case "6":
                case "3":
                    $dest_x = $temp_w - $offset - $wm_w;
                    break;
                default:
                    $dest_x = $offset;
                    $this->set_error("Watermark position $position not valid");
            }
            switch ($position) {
                case "7":
                case "8":
                case "9":
                    $dest_y = $offset;
                    break;
                case "4":
                case "5":
                case "6":
                    $dest_y = ($temp_h - $wm_h) / 2;
                    break;
                case "1":
                case "2":
                case "3":
                    $dest_y = $temp_h - $offset - $wm_h;
                    break;
                default:
                    $dest_y = $offset;
                    $this->set_error("Watermark position $position not valid");
            }
        }

        if ($this->watermark_method == 1) {
            $opacity = $this->watermark_transparency;
            $cut = imagecreatetruecolor($wm_w, $wm_h);
            imagecopy($cut, $this->temp_image, 0, 0, $dest_x, $dest_y, $wm_w, $wm_h);
            $opacity = 100 - $opacity;
            imagecopy($cut, $this->watermark_image, 0, 0, 0, 0, $wm_w, $wm_h);
            imagecopymerge($this->temp_image, $cut, $dest_x, $dest_y, 0, 0, $wm_w, $wm_h, $opacity);
        } else {
            imagecopymerge($this->temp_image, $this->watermark_image, $dest_x, $dest_y, 0, 0, $wm_w, $wm_h, $this->watermark_transparency);
        }

        return $this;
    }

    public function border($width = 5, $colour = "#000")
    {
        if (!$this->_check_image()) return $this;
        $this->_copy_to_temp_if_needed();

        $col = $this->_html2rgb($colour);
        $border_col = imagecolorallocate($this->temp_image, $col[0], $col[1], $col[2]);

        $temp_w = imagesx($this->temp_image);
        $temp_h = imagesy($this->temp_image);

        for ($x = 0; $x < $width; $x++) {
            imagerectangle($this->temp_image, $x, $x, $temp_w - $x - 1, $temp_h - $x - 1, $border_col);
        }

        return $this;
    }

    public function border_3d($width = 5, $rot = 0, $opacity = 30)
    {
        if (!$this->_check_image()) return $this;
        $this->_copy_to_temp_if_needed();

        $border_image = imagecreatetruecolor($this->new_width, $this->new_height);

        $black = imagecolorallocate($border_image, 0, 0, 0);
        $white = imagecolorallocate($border_image, 255, 255, 255);
        switch ($rot) {
            case 1:
                $cols = array($white, $black, $white, $black);
                break;
            case 2:
                $cols = array($black, $black, $white, $white);
                break;
            case 3:
                $cols = array($black, $white, $black, $white);
                break;
            default:
                $cols = array($white, $white, $black, $black);
        }
        $bg_col = imagecolorallocate($border_image, 127, 128, 126);

        imagecolortransparent($border_image, $bg_col);
        imagefilledrectangle($border_image, 0, 0, $this->new_width, $this->new_height, $bg_col);

        for ($x = 0; $x < $width; $x++) {
            imageline($border_image, $x, $x, $this->new_width - $x - 1, $x, $cols[0]);
            imageline($border_image, $x, $x, $x, $this->new_width - $x - 1, $cols[1]);
            imageline($border_image, $x, $this->new_height - $x - 1, $this->new_width - 1 - $x, $this->new_height - $x - 1, $cols[3]);
            imageline($border_image, $this->new_width - $x - 1, $x, $this->new_width - $x - 1, $this->new_height - $x - 1, $cols[2]);
        }

        imagecopymerge($this->temp_image, $border_image, 0, 0, 0, 0, $this->new_width, $this->new_height, $opacity);
        imagedestroy($border_image);

        return $this;
    }

    public function shadow($size = 4, $direction = 3, $colour = "#444")
    {
        if (!$this->_check_image()) return $this;
        $this->_copy_to_temp_if_needed();

        $sx = imagesx($this->temp_image);
        $sy = imagesy($this->temp_image);

        $bu_image = imagecreatetruecolor($sx, $sy);
        if (!$this->_is_gd_image($bu_image)) {
            $this->set_error('Unable to create shadow temp image');
            return FALSE;
        }

        imagecopy($bu_image, $this->temp_image, 0, 0, 0, 0, $sx, $sy);
        imagedestroy($this->temp_image);
        $this->temp_image = imagecreatetruecolor($sx + $size, $sy + $size);

        $col = $this->_html2rgb($this->background_colour);
        $bg = imagecolorallocate($this->temp_image, $col[0], $col[1], $col[2]);
        imagefilledrectangle($this->temp_image, 0, 0, $sx + $size, $sy + $size, $bg);

        switch ($direction) {
            case "7":
            case "4":
            case "1":
                $sh_x = 0;
                $pic_x = $size;
                break;
            case "8":
            case "5":
            case "2":
                $sh_x = $size / 2;
                $pic_x = $size / 2;
                break;
            case "9":
            case "6":
            case "3":
                $sh_x = $size;
                $pic_x = 0;
                break;
            default:
                $sh_x = $size;
                $pic_x = 0;
        }
        switch ($direction) {
            case "7":
            case "8":
            case "9":
                $sh_y = 0;
                $pic_y = $size;
                break;
            case "4":
            case "5":
            case "6":
                $sh_y = $size / 2;
                $pic_y = $size / 2;
                break;
            case "1":
            case "2":
            case "3":
                $sh_y = $size;
                $pic_y = 0;
                break;
            default:
                $sh_y = $size;
                $pic_y = 0;
        }

        $shadowcolour = $this->_html2rgb($colour);
        $shadow = imagecolorallocate($this->temp_image, $shadowcolour[0], $shadowcolour[1], $shadowcolour[2]);
        imagefilledrectangle($this->temp_image, $sh_x, $sh_y, $sh_x + $sx - 1, $sh_y + $sy - 1, $shadow);

        imagecopy($this->temp_image, $bu_image, $pic_x, $pic_y, 0, 0, $sx, $sy);
        imagedestroy($bu_image);

        $this->_set_new_size();
        return $this;
    }

    public function filter($function, $arg1 = NULL, $arg2 = NULL, $arg3 = NULL, $arg4 = NULL)
    {
        if (!$this->_check_image()) return $this;
        $this->_copy_to_temp_if_needed();

        if (!imagefilter($this->temp_image, $function, $arg1, $arg2, $arg3, $arg4)) {
            $this->set_error("Filter $function failed");
        }

        $this->_set_new_size();
        return $this;
    }

    public function round($radius = 5, $invert = FALSE, $corners = "")
    {
        if (!$this->_check_image()) return $this;
        $this->_copy_to_temp_if_needed();

        if ($corners == "") $corners = array(TRUE, TRUE, TRUE, TRUE);
        if (!is_array($corners) || count($corners) != 4) {
            $this->set_error("Round failed, expected an array of 4 items");
            return $this;
        }

        $corner = imagecreatetruecolor($radius, $radius);
        $col = $this->_html2rgb($this->background_colour);
        $bg = imagecolorallocate($corner, $col[0], $col[1], $col[2]);
        $xparent = imagecolorallocate($corner, 127, 128, 126);
        imagecolortransparent($corner, $xparent);

        if ($invert) {
            imagefilledrectangle($corner, 0, 0, $radius, $radius, $xparent);
            imagefilledellipse($corner, 0, 0, ($radius * 2) - 1, ($radius * 2) - 1, $bg);
        } else {
            imagefilledrectangle($corner, 0, 0, $radius, $radius, $bg);
            imagefilledellipse($corner, $radius, $radius, ($radius * 2), ($radius * 2), $xparent);
        }

        $temp_w = imagesx($this->temp_image);
        $temp_h = imagesy($this->temp_image);

        if ($corners[0]) imagecopymerge($this->temp_image, $corner, 0, 0, 0, 0, $radius, $radius, 100);
        $corner = imagerotate($corner, 270, 0);
        if ($corners[1]) imagecopymerge($this->temp_image, $corner, $temp_w - $radius, 0, 0, 0, $radius, $radius, 100);
        $corner = imagerotate($corner, 270, 0);
        if ($corners[2]) imagecopymerge($this->temp_image, $corner, $temp_w - $radius, $temp_h - $radius, 0, 0, $radius, $radius, 100);
        $corner = imagerotate($corner, 270, 0);
        if ($corners[3]) imagecopymerge($this->temp_image, $corner, 0, $temp_h - $radius, 0, 0, $radius, $radius, 100);

        $this->_set_new_size();
        return $this;
    }

    private function _set_new_size()
    {
        if (!$this->_check_image()) {
            $this->new_height = 0;
            $this->new_width = 0;
            return;
        }

        if (!$this->_is_gd_image($this->temp_image)) {
            $this->new_height = $this->height;
            $this->new_width = $this->width;
            return;
        }

        $this->new_height = imagesy($this->temp_image);
        $this->new_width = imagesx($this->temp_image);
    }
}
/* End of file Image_moo.php */
/* Location: /application/libraries/Image_moo.php */