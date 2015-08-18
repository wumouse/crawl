<?php
/**
 * crawl.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace Tasks;

/**
 * 顶点小说抓取
 *
 * @package Tasks
 */
class DingDianTask extends TaskBase
{
    /**
     * 抓小说
     *
     * @return \Library\Response\Error|\Library\Response\Info
     */
    public function mainAction()
    {
        $options = $this->getOptions();
        if (0 === $this->parameter->countOptions()) {
            return $this->getInfoResponse($options);
        }

        $output = $this->parameter->getOption('o');

        if (!$output) {
            return $this->getErrorResponse('Invalid output file specified');
        }

        $tableOfContentsUri = 'http://www.23wx.com/html/0/298/';
        $crawl = new Crawl($tableOfContentsUri);
        $crawl->run();
        if (!$crawl->isSuccess()) {
            return $this->getErrorResponse('获取目录失败:httpCode:' . $crawl->getHttpCode());
        }

        $sectionHtmlContent = $crawl->getContent();
        if (!$sectionHtmlContent) {
            return $this->getErrorResponse('内容无响应');
        }

        $parser = new Parser($sectionHtmlContent);
        $sections = $parser->query('td.L>a');
        try {
            $splFileObject = new \SplFileObject($output, 'w+');
        } catch (\RuntimeException $e) {
            return $this->getErrorResponse("The output file {$output} can not be opened");
        }
        while ($sections->valid()) {
            $item = $sections->current();
            $link = $item->href;
            $crawl->reset();
            $crawl->setUri($link);
            $crawl->run();
            if (!$crawl->isSuccess()) {
                continue;
            }

            $htmlContent = $crawl->getContent();
            if (!$htmlContent) {
                continue;
            }

            $parser->reset();
            $parser->setContent($htmlContent);
            $htmlContent = $parser->query('dd#contents');
            $splFileObject->fwrite($htmlContent);
        }

        $splFileObject->fflush();
    }

    protected function getOptions()
    {
        $options = parent::getOptions();
        $options->add('o', 'the text file path to be output');
        return $options;
    }
}
