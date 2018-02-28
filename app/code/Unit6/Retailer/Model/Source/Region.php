<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Unit6\Retailer\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\View\Model\PageLayout\Config\BuilderInterface;

class Region implements OptionSourceInterface
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
            ['label' => 'California', 'value' => '12'],
            ['label' => 'Alaska', 'value' => '2'],            
            ['label' => 'New York', 'value' => '43'],            
            ['label' => 'Quebec', 'value' => '76'],
            ['label' => 'Ontario', 'value' => '74']
        ];

        return $this->options;
    }
}
