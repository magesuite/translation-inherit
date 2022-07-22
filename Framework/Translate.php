<?php
declare(strict_types=1);

namespace MageSuite\TranslationInherit\Framework;

class Translate extends \Magento\Framework\Translate
{
    /**
     * @var \MageSuite\TranslationInherit\Model\ParentLocaleResolver
     */
    protected $parentLocaleResolver;

    public function loadData($area = null, $forceReload = false)
    {
        $this->_data = [];
        if ($area === null) {
            $area = $this->_appState->getAreaCode();
        }
        $this->setConfig(
            [
                self::CONFIG_AREA_KEY => $area,
            ]
        );

        if (!$forceReload) {
            $data = $this->_loadCache();
            if (false !== $data) {
                $this->_data = $data;
                return $this;
            }
        }

        // Begin override
        $parentLocale = $this->getParentLocale();
        $currentLocale = $this->getLocale();

        if ($parentLocale !== null && $parentLocale != $currentLocale) {
            $this->setLocale($parentLocale);

            $this->_loadModuleTranslation();
            $this->_loadPackTranslation();
            $this->_loadThemeTranslation();
            $this->_loadDbTranslation();

            $this->setLocale($currentLocale);
        }
        // End override

        $this->_loadModuleTranslation();
        $this->_loadPackTranslation();
        $this->_loadThemeTranslation();
        $this->_loadDbTranslation();

        if (!$forceReload) {
            $this->_saveCache();
        }

        return $this;
    }

    protected function getParentLocale(): ?string
    {
        return $this->getParentLocaleResolver()->resolve($this->getLocale());
    }

    protected function getParentLocaleResolver(): \MageSuite\TranslationInherit\Model\ParentLocaleResolver
    {
        if (null === $this->parentLocaleResolver) {
            $this->parentLocaleResolver = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\MageSuite\TranslationInherit\Model\ParentLocaleResolver::class);
        }

        return $this->parentLocaleResolver;
    }
}
