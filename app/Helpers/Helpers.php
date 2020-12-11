<?php

if (!function_exists('gravatar')) {
    /**
     * Generate Gravatar URL
     *
     * @param {string} email
     */
    function gravatar($email)
    {
        return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email)));
    }
}
