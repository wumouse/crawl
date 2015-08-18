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
     *
     *
     * @var \DOMDocument
     */
    protected $document;

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
        $tidy = $this->getRepairedTidy($htmlContent);
        $this->document = new \DOMDocument('1.0', 'utf-8');
        $this->document
            ->loadHTML('<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>' . (string)$tidy->body());
        $this->domXpath = new \DOMXPath($this->document);
    }
}
