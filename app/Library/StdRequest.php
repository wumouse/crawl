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
class StdRequest
{
    /**
     *
     *
     * @var string
     */
    protected $method = 'GET';
    /**
     *
     *
     * @var
     */
    protected $urlBase;
    /**
     *
     *
     * @var
     */
    protected $urlPath;
    /**
     *
     *
     * @var
     */
    protected $headers;
    /**
     *
     *
     * @var
     */
    protected $parameters;

    /**
     * Cookies
     *
     * @var string[][]
     */
    protected $cookies = array();

    /**
     * POST 请求参数
     *
     * @var string[]
     */
    protected $postFields;

    /**
     * 主体
     *
     * @var string
     */
    protected $body;

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getUrlBase()
    {
        return $this->urlBase;
    }

    /**
     * @param mixed $urlBase
     */
    public function setUrlBase($urlBase)
    {
        $this->urlBase = $urlBase;
    }

    /**
     * @return mixed
     */
    public function getUrlPath()
    {
        return $this->urlPath;
    }

    /**
     * @param mixed $urlPath
     */
    public function setUrlPath($urlPath)
    {
        $this->urlPath = $urlPath;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param mixed $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     *
     *
     * @param string $name
     * @param string $value
     * @param string $expires
     * @param string $domain
     * @param string $path
     */
    public function addCookie($name, $value, $expires = '', $domain = '', $path = '')
    {
        $this->cookies[(string)$name] = array(
            'name' => (string)$name,
            'value' => (string)$value,
            'expires' => (string)$expires,
            'domain' => (string)$domain,
            'path' => (string)$path,
        );
    }

    /**
     * 添加 Post 内容
     *
     * @param string $name
     * @param string $value
     */
    public function addPostField($name, $value)
    {
        $this->postFields[(string)$name] = (string)$value;
    }

    /**
     * 设置请求主体
     *
     * @param string $body
     */
    public function setRequestBody($body)
    {
        $this->body = $body;
    }

    /**
     * 添加请求头
     *
     * @param string $name
     * @param string $value
     */
    public function addHeader($name, $value)
    {
        $this->headers[(string)$name] = (string)$value;
    }

    /**
     * @return mixed
     */
    public function getCookies()
    {
        return $this->cookies;
    }
}
