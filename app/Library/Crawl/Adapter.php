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
        $this->handler = curl_init();
    }

    /**
     *
     *
     * @param string $uri
     * @return string
     */
    public function get($uri = null)
    {
        if ($uri) {
            $this->setUri($uri);
        }
        $content = $this->exec();
        $this->info = curl_getinfo($this->handler);
        return $content;
    }

    /**
     * 设置URI
     *
     * @param string $uri
     */
    private function setUri($uri)
    {
        $this->uri = $uri;
        $this->options[CURLOPT_URL] = $uri;
    }

    /**
     * 获取HTTP 响应码
     *
     * @return int
     */
    public function getHttpCode()
    {
        return $this->info['http_code'];
    }

    /**
     * 执行
     *
     * @return string
     */
    private function exec()
    {
        $options = $this->options;
        $options[CURLINFO_HEADER_OUT] = true;
        $options[CURLOPT_HEADER] = false;
        $options[CURLOPT_RETURNTRANSFER] = true;
        curl_setopt_array($this->handler, $options);
        return curl_exec($this->handler);
    }
}
