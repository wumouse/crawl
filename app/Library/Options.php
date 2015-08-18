<?php
/**
 * requestDataConverter.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace Library;

/**
 *
 *
 * @package Library
 */
class Options
{
    /**
     * 选项
     *
     * @var array
     */
    protected $options = [];

    /**
     * 添加选项
     *
     * @param string $option
     * @param string $description
     */
    public function add($option, $description)
    {
        $this->options[$option] = $description;
    }

    /**
     * 输出选项字符串描述
     *
     * @return string
     */
    public function __toString()
    {
        $optionsDescription = PHP_EOL;
        foreach ($this->options as $option => $description) {
            $optionsDescription .= '-' . $option . "\t\t" . $description . PHP_EOL;
        }

        return $optionsDescription;
    }

    /**
     *
     *
     * @param string $option
     * @return string
     */
    public function getDescription($option)
    {
        return $this->options[$option];
    }
}
