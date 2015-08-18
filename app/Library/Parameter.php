<?php
/**
 * requestDataConverter.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace Library;

/**
 * 参数解析处理
 *
 * @package Library
 */
class Parameter
{
    /**
     * 获取的参数原始数组
     *
     * @var array
     */
    protected $argv;

    /**
     * 分析过后的选项
     *
     * @var array
     */
    protected $options = [];

    /**
     * 参数
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * @param array $argv
     */
    public function __construct(array $argv)
    {
        $this->argv = $argv;
        $this->parse($argv);
    }

    /**
     * 获取选项
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getOption($name, $default = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $default;
    }

    /**
     * 获取选项
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * 计数
     *
     * @return int
     */
    public function countOptions()
    {
        return count($this->options);
    }

    /**
     * 分析选项和参数,参数第一二个会当成 task action
     *
     * @param array $parameters
     */
    protected function parse(array $parameters)
    {
        /**
         * skip file name
         */
        $current = next($parameters);
        $parametersCount = 0;
        $relation = [
            'task',
            'action',
        ];
        while ($current) {
            if (0 === strpos($current, '-')) {
                $optionName = substr($current, 1);
                $this->options[$optionName] = next($parameters);
            } else {
                $key = isset($relation[$parametersCount]) ? $relation[$parametersCount] : null;
                $this->parameters[$key] = $current;
                $parametersCount++;
            }
            $current = next($parameters);
        }
    }

    /**
     * 获取其他参数
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
