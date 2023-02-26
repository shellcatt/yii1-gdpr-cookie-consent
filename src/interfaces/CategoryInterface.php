<?php

interface CategoryInterface
{
    const CATEGORY_SESSION      = 'session';
    const CATEGORY_USAGE_HELPER = 'usage_helper';
    const CATEGORY_SOCIAL       = 'social';
    const CATEGORY_STATISTICS   = 'statistics';
    const CATEGORY_ADS          = 'ads';
    const CATEGORY_BEHAVIOR     = 'behavior';

    const CATEGORIES = [
        self::CATEGORY_SESSION,
        self::CATEGORY_STATISTICS,
        self::CATEGORY_SOCIAL,
//        self::CATEGORY_ADS,
//        self::CATEGORY_BEHAVIOR,
//        self::CATEGORY_USAGE_HELPER,
    ];

    const CATEGORIES_REQUIRED = [
        self::CATEGORY_SESSION,
//        self::CATEGORY_STATISTICS,
//        self::CATEGORY_SOCIAL,
//        self::CATEGORY_USAGE_HELPER,
    ];
}
