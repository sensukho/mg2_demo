<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Unit6\Retailer\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\View\Model\PageLayout\Config\BuilderInterface;

class Country implements OptionSourceInterface
{

    /**
     * @var array
     */
    protected $options;


    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $this->options = [
            ['label' => 'United States', 'value' => 'US'],
            ['label' => 'Canada', 'value' => 'CA'],            
            ['label' => 'United Kingdom', 'value' => 'GB']
        ];

        return $this->options;
    }
}
