<?php
/**
 * crawl.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace Library\Crawl;

/**
 *
 *
 * @package Library\Crawl
 */
abstract class Adapter
{
    /**
     *
     *
     * @var resource
     */
    protected $handler;

    /**
     *
     *
     * @var string
     */
    protected $uri;

    /**
     *
     *
     * @var string
     */
    protected $info;

    /**
     *
     *
     * @var array
     */
    protected $options;

    /**
     * @param string $uri
     */
    public function __construct($uri = null)
    {
        if (is_string($uri)) {
            $this->setUri($uri);
        }
    }

    /**
     * 设置URI
     *
     * @param string $uri
     * @return Adapter
     */
    abstract public function setUri($uri);

    abstract public function getHttpCode();

    /**
     *
     *
     * @param string $uri
     * @return string
     */
    abstract public function get($uri = null);
}
