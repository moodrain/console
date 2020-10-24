<?php

namespace App\Helpers;

class LocaleHelper
{
    public static function setLocaleFromRequest()
    {
        $languages = request()->getLanguages();
        foreach ($languages as $language) {
            if (str_contains($language, 'zh')) {
                break;
            }
            if (str_contains($language, 'en')) {
                app()->setLocale('en');
                break;
            }
        }
    }
}