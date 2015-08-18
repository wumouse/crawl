<?php
/**
 * crawl.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace Library;

use Library\Crawl\Adapter;

/**
 *
 *
 * @package Library
 */
class Crawl
{
    /**
     * 内容
     *
     * @var string
     */
    protected $content;

    /**
     *
     *
     * @var Adapter
     */
    protected $driver;

    /**
     *
     *
     * @var string
     */
    private $uri;

    /**
     * @param Adapter $driver
     * @param string $uri
     */
    public function __construct($driver, $uri)
    {
        $this->uri = $uri;
        $this->driver = $driver;
    }

    public function run()
    {
        $this->content = $this->driver->get($this->uri);
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 抓取是否成功
     *
     * @return bool
     */
    public function isSuccess()
    {
        return $this->driver->getHttpCode() == 200;
    }

    /**
     *
     *
     * @return int
     */
    public function getHttpCode()
    {
        return $this->driver->getHttpCode();
    }

    public function reset()
    {
        $this->content = '';
    }

    /**
     *
     *
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }
}
