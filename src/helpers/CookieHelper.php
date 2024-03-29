<?php

Yii::import('GDPR.interfaces.*');

class CookieHelper implements CategoryInterface, TypeInterface
{
    const MAPPING = [
        self::CATEGORY_USAGE_HELPER => [
            self::TYPE_FACEBOOK_APP, // facebook app cookies are required if it is in use
        ],
        self::CATEGORY_ADS => [
            self::TYPE_FACEBOOK_PIXEL,
        ],
        self::CATEGORY_SOCIAL => [
            self::TYPE_FACEBOOK,
            self::TYPE_GOOGLE_MAPS,
        ],
        self::CATEGORY_STATISTICS => [
            self::TYPE_GOOGLE_ANALYTICS,
            self::TYPE_GOOGLE_TAG_MANAGER,
        ],
        self::CATEGORY_BEHAVIOR => [
            self::TYPE_HOTJAR,
        ],
    ];

    /**
     * @param $type
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function isAllowedType($type)
    {
        return static::getComponent()->isAllowedCategory(static::getCategoryByType($type));
    }

    /**
     * @param $category
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function isAllowedCategory($category)
    {
        return static::getComponent()->isAllowedCategory($category);
    }

    /**
     * @param $type
     * @return int|null|string
     */
    protected static function getCategoryByType($type)
    {
        foreach (self::MAPPING as $category => $types) {
            if (in_array($type, $types)) {
                return $category;
            }
        }

        return null;
    }

    /**
     * @return CookieComponentInterface
     * @throws \yii\base\InvalidConfigException
     */
    public static function getComponent()
    {
        return Yii::app()->cookieConsent;
        
        /** @var CookieComponentInterface $component */
//        $component = Instance::ensure('cookieConsent', CookieComponentInterface::class);

//        return $component->getComponent();
    }
}
