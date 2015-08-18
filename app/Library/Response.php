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
class Response implements ResponseInterface
{
    /**
     * 错误响应的内容
     *
     * @var string
     */
    protected $content;

    /**
     * 错误代码
     *
     * @var int
     */
    protected $code = 0;

    /**
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }
}
