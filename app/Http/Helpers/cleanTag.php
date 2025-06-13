<?php

use Mews\Purifier\Facades\Purifier;

if (!function_exists('sanitize_typography')) {
    function sanitize_typography($html)
    {
        return Purifier::clean($html, [
            'HTML.Allowed' => 'p,h1,h2,h3,h4,h5,h6,b,strong,i,em,ul,ol,li,a[href],span,img',
            'CSS.AllowedProperties' => 'color,background-color',
            'HTML.AllowedAttributes' => 'style,href,src,alt,width,height',
            'AutoFormat.AutoParagraph' => false,
        ]);
    }
}
if (!function_exists('sanitize_and_validate_typography')) {
    function sanitize_and_validate_typography($html, $fieldName = 'field')
    {
        $clean = sanitize_typography($html);
        if (trim(strip_tags($clean)) === '') {
            throw new \Exception(ucfirst($fieldName) . ' tidak boleh kosong.');
        }
        return $clean;
    }
}
