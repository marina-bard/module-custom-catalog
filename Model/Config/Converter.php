<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 8/23/18
 * Time: 12:02 PM
 */

namespace Magento\CustomCatalog\Model\Config;

use  Magento\Framework\Config\ConverterInterface;

class Converter implements ConverterInterface
{
    public function convert($source)
    {
        $config = [];
        $configList = $source->getElementsByTagName(Data::CUSTOM_CONFIG_TAG_NAME);

        foreach ($configList as $item) {
            foreach ($item->childNodes as $childNode) {
                if ($childNode->localName) {
                    $config[$childNode->localName] = $this->getTagArray($childNode);
                }
            }
        }

        return [Data::CUSTOM_CONFIG_TAG_NAME => $config];
    }

    private function getTagArray($tag)
    {
        $config = [];

        foreach ($tag->childNodes as $childNode) {
            if ($childNode->localName) {
                $config[$childNode->localName] = $childNode->textContent;
            }
        }

        return $config;
    }

}