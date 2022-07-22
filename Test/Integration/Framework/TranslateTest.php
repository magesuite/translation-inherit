<?php
declare(strict_types=1);

namespace MageSuite\TranslationInherit\Test\Integration\Framework;

class TranslateTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Framework\Translate
     */
    protected $translate;

    protected function setUp(): void
    {
        $objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
        $this->translate = $objectManager->create(\Magento\Framework\Translate::class);

        $parentLocaleResolver = $this->createMock(\MageSuite\TranslationInherit\Model\ParentLocaleResolver::class);
        $parentLocaleResolver->expects($this->any())
            ->method('resolve')
            ->with('en_US')
            ->willReturn('en_GB');
        $objectManager->addSharedInstance($parentLocaleResolver, \MageSuite\TranslationInherit\Model\ParentLocaleResolver::class);

        $moduleReader = $objectManager->get(\Magento\Framework\Module\Dir\Reader::class);
        $moduleReader->setModuleDir(
            'MageSuite_TranslationInherit',
            'i18n',
            dirname(__DIR__) . '/_files/i18n'
        );
    }

    public function testIfParentLocaleWasInherit(): void
    {
        $locale = $this->translate->getLocale();
        $this->assertEquals('en_US', $locale);
        $data = $this->translate->loadData(null, true)->getData();
        $this->assertEquals('Fixture File Translation en_GB', $data['Fixture String']);
    }
}
