<?php
if (!function_exists('localStorage')) {
    function localStorage($key, $default = null)
    {
        // This is a helper - actual localStorage is handled in JS
        return session()->get($key, $default);
    }
}
function currency($amount) {
    return 'Rs ' . number_format($amount, 0);
}


