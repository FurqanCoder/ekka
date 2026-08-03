<?php

namespace App\Helpers;

use App\Models\WebsiteSetting;

class WebsiteHelper
{
    public static function getSettings()
    {
        return WebsiteSetting::getSettings();
    }

    public static function getLogo($type = 'light')
    {
        $settings = self::getSettings();
        return $type === 'light' ? $settings->logo_light_url : $settings->logo_dark_url;
    }

    public static function getSocialLinks()
    {
        return self::getSettings()->active_social_links;
    }

    public static function getContactInfo()
    {
        return self::getSettings()->contact_info;
    }

    public static function getMetaTags()
    {
        return self::getSettings()->meta_tags;
    }

    public static function isMaintenanceMode()
    {
        return self::getSettings()->is_maintenance;
    }
}