<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/26/18
 * Time: 13:50
 */

namespace Unit1\FreeGeoIp\Model\Welcome\Config;


class Converter implements \Magento\Framework\Config\ConverterInterface
{

    /**
     * Convert config
     *
     * @param \DOMDocument $source
     * @return array
     */
    public function convert($source)
    {
        $output = [];

        foreach ($source->getElementsByTagName('welcome_message') as $node) {
            foreach ($node->childNodes as $country) {
                if ($country->nodeType != XML_ELEMENT_NODE) continue;
                $output[$country->nodeName] = $this->getCountryRegions($country);
            }
        }
        return $output;
        /*
         <welcome_message>
        <default>Default HELLO</default>
        <us>
          <default>Default US HELLO</default>
          <ca>California HELLO</ca>
        </us>
        <mx>
            <default>Default HELLO from MX</default>
            <zac>Hello from ZAC.</zac>
            <a>
                <aa>
                </aa>
            </a>

        </mx>
    </welcome_message>
         */
        /*
         $output['default'] = 'Default HELLO';
         $output['mx'] = [
        'default' => 'Default HELLO from MX',
        'zac' => 'Hello from ZAC.'
        ];
         */
    }

    protected function getCountryRegions($country)
    {
        $regionNodes = $country->childNodes;
        $regionLength = $regionNodes->length;

        if ($regionLength == 1) return $country->nodeValue;
        $regions = [];
        foreach ($regionNodes as $regionNode) {
            if ($regionNode->nodeType != XML_ELEMENT_NODE
                || ($regionNode->childNodes->length != 1)
            ) continue;
            $regions[$regionNode->nodeName] = $regionNode->nodeValue;
        }
        return $regions;
    }
}
