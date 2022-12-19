https://creativestyle.atlassian.net/wiki/spaces/MGSDEV/pages/2307948545/TranslationInherit+optional

## Example of usage
Add to di.xml
```
<type name="MageSuite\TranslationInherit\Model\ParentLocaleResolver">
    <arguments>
        <argument name="parentLocaleList" xsi:type="array">
            <item name="de_CH" xsi:type="string">de_DE</item>
            <item name="fr_CH" xsi:type="string">fr_FR</item>
        </argument>
    </arguments>
</type>
```
