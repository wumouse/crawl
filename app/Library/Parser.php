<?php
/**
 * crawl.
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
class Parser
{
    /**
     *
     *
     * @var \DOMXPath
     */
    protected $domXpath;

    /**
     * @param string $htmlContent
     */
    public function __construct($htmlContent)
    {
        $this->init($htmlContent);
    }

    /**
     *
     *
     * @param string $xpathExpression
     * @param null $contextNode
     * @return DOMNodeResultSet
     */
    public function query($xpathExpression, $contextNode = null)
    {
        $result = $this->domXpath->evaluate($xpathExpression, $contextNode);
        return new DOMNodeResultSet($result);
    }

    /**
     * 整理内容
     *
     * @param string $htmlContent
     * @return \tidy
     */
    private function getRepairedTidy($htmlContent)
    {
        /** @var \tidy $tidy */
        $tidy = tidy_parse_string($htmlContent, array(
            'numeric-entities' => true,
            'output-xhtml' => true,
        ), 'utf8');

        $tidy->cleanRepair();
        return $tidy;
    }

    public function reset()
    {
    }

    /**
     * 设置内容
     *
     * @param string $htmlContent
     */
    public function setContent($htmlContent)
    {
        $this->init($htmlContent);
    }

    /**
     *
     *
     * @param string $htmlContent
     */
    protected function init($htmlContent)
    {
        /*
         * 编码其中的类似实体字符。避免DOMDocument 解析时遇到发生错误，比如 &# 这个符号转换为 &amp;#
         */
        $htmlContent = str_replace('&#', '&amp;#', $htmlContent);

        $tidy = $this->getRepairedTidy($htmlContent);
        $document = new \DOMDocument('1.0', 'utf-8');

        $source = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>' . (string)$tidy->body();
        unset($tidy);
        $document
            ->loadHTML($source);
        $this->domXpath = new \DOMXPath($document);
    }
}
