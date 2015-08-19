<?php
/**
 * crawl.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace Library\Crawl\Adapter;

use Library\Crawl\Adapter;

/**
 *
 *
 * @package Library\Crawl\Adapter
 */
class Curl extends Adapter
{

    /**
     * @inheritDoc
     */
    public function __construct($uri = null)
    {
        parent::__construct($uri);
        $this->handler = curl_init();
    }

    /**
     * @inheritDoc
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
     * @inheritDoc
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        $this->options[CURLOPT_URL] = $uri;
        return $this;
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
