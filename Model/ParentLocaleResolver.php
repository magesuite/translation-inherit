<?php
declare(strict_types=1);

namespace MageSuite\TranslationInherit\Model;

class ParentLocaleResolver
{
    protected array $parentLocaleList;

    public function __construct(array $parentLocaleList = [])
    {
        $this->parentLocaleList = $parentLocaleList;
    }

    public function resolve(string $locale): ?string
    {
        return $this->parentLocaleList[$locale] ?? null;
    }
}
