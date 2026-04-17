<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SecurityHeaders
{

    public function set_headers()
    {
        $CI = &get_instance();

        $nonce = base64_encode(random_bytes(16));

        $CI->load->vars(['csp_nonce' => $nonce]);

        $csp = "default-src 'self'; "
            . "script-src 'self' 'nonce-{$nonce}'; "
            . "style-src 'self'; "
            . "img-src 'self' data:; "
            . "font-src 'self'; "
            . "connect-src 'self'; "
            . "object-src 'none'; "
            . "frame-ancestors 'none'; "
            . "base-uri 'self'; "
            . "form-action 'self'; "
            . "upgrade-insecure-requests;";

        header("Content-Security-Policy: $csp");
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: DENY");
        header("Referrer-Policy: strict-origin-when-cross-origin");
    }
}
