<?php
/**
 * crawl.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace Tasks;

use Library\Crawl;
use Library\Options;
use Library\Parser;
use Phalcon\Script\Color;

/**
 * 顶点小说抓取
 *
 * @package Tasks
 */
class DingDianTask extends TaskBase
{
    /**
     * 顶点小说书目录的页面前缀
     */
    const NOVEL_SECTION_URI_PREFIX = 'http://www.23wx.com/html/0/';

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

        $output = $this->convertPath($this->parameter->getOption('o'));
        if (!$output) {
            return $this->getErrorResponse('无效的' . $options->getDescription('o'));
        }

        $code = $this->parameter->getOption('c');
        $tableOfContentsUri = self::NOVEL_SECTION_URI_PREFIX . $code;
        if (!filter_var($tableOfContentsUri, FILTER_VALIDATE_URL)) {
            return $this->getErrorResponse('无效的' . $options->getDescription('c'));
        }

        $dir = dirname($output) . "/{$code}_temp";
        $sectionHtmlTmpFileName = $dir . '/section.html';
        $crawl = new Crawl(new Crawl\Adapter\Curl(), $tableOfContentsUri . '/');

        if (!stream_resolve_include_path($sectionHtmlTmpFileName)) {
            $crawl->run();
            if (!$crawl->isSuccess()) {
                return $this->getErrorResponse('获取小说目录内容失败:HTTP 响应码:' . $crawl->getHttpCode());
            }

            $sectionHtmlContent = $crawl->getContent();
        } else {
            $sectionHtmlContent = file_get_contents($sectionHtmlTmpFileName);
        }
        if (!$sectionHtmlContent) {
            return $this->getErrorResponse('内容无响应');
        }

        $sectionHtmlContent = mb_convert_encoding($sectionHtmlContent, 'UTF-8', 'GB18030');
        $parser = new Parser($sectionHtmlContent);
        $sections = $parser->query('//td[@class="L"]/a');
        try {
            $splFileObject = new \SplFileObject($output, 'w+');
        } catch (\RuntimeException $e) {
            return $this->getErrorResponse("文件{$output}无法打开");
        }

        !stream_resolve_include_path($dir) && mkdir($dir);

        $counter = 0;
        while ($sections->valid()) {
            $item = $sections->current();
            $link = $item->getAttribute('href');
            $sectionName = str_replace("\n", '', $item->nodeValue);
            $tmpFileName = $dir . '/' . $sectionName . '.html';
            if (!stream_resolve_include_path($tmpFileName)) {
                $crawl->reset();
                $crawl->setUri($tableOfContentsUri . '/' . $link);
                $crawl->run();
                if (!$crawl->isSuccess()) {
                    if (3 === $counter) {
                        return $this->getErrorResponse("抓取{$sectionName}章节响应失败({$crawl->getHttpCode()}) 3次。中断");
                    }
                    $counter++;
                    echo Color::info("抓取{$sectionName}重试第{$counter}次");
                    continue;
                }

                $htmlContent = $crawl->getContent();
                if (!$htmlContent) {
                    if (3 === $counter) {
                        return $this->getErrorResponse("抓取{$sectionName}章节内容为空3次。中断");
                    }
                    $counter++;
                    echo Color::info("抓取{$sectionName}重试第{$counter}次");
                    continue;
                }
                file_put_contents($tmpFileName, $htmlContent);
            } else {
                $htmlContent = file_get_contents($tmpFileName);
            }

            $parser->reset();
            $parser->setContent(mb_convert_encoding($htmlContent, 'UTF-8', 'GB18030'));
            $htmlContent = $parser->query('//*[@id="contents"]');
            if (!$htmlContent->valid()) {
                continue;
            }
            echo Color::info('完成: 100% : ' . $sectionName);
            $sectionContent = $htmlContent->current()->nodeValue;
            $titleWithMarkdownStyle = '###' . $sectionName;
            $splFileObject->fwrite($titleWithMarkdownStyle . PHP_EOL . $sectionContent . PHP_EOL . PHP_EOL);
            $sections->next();
        }

        $splFileObject->fflush();
        return $this->getSuccessResponse('成功');
    }

    /**
     * 获取选项对象
     *
     * @return Options
     */
    protected function getOptions()
    {
        $options = parent::getOptions();
        $options->add('o', '要输出小说内容的文件路径');
        $options->add('c', '小说目录页面的代号，比如URI是：http://www.23wx.com/book/298, 那么ID 就是298');
        return $options;
    }
}
