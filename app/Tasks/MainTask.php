<?php
/**
 * requestDataConverter.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace Tasks;

use Library\Options;
use Library\Response\Info;
use Library\Response\Success;
use Logic\RequestFactory;

/**
 *
 *
 * @package Tasks
 */
class MainTask extends TaskBase
{

    /**
     */
    public function mainAction()
    {
        $options = $this->getOptions();
        if (0 == $this->parameter->countOptions()) {
            return $this->getInfoResponse($options);
        }
        $from = $this->parameter->getOption('f', 'chrome');
        $to = $this->parameter->getOption('t');
        if (!$to) {
            return $this->getErrorResponse('invalid ' . $options->getDescription('t'));
        }

        $fromContentFile = $this->parameter->getOption('i');
        if (!$fromContentFile) {
            return $this->getErrorResponse('invalid ' . $options->getDescription('i'));
        }
        $fromContentFile = $this->convertPath($fromContentFile);
        if (!stream_resolve_include_path($fromContentFile)) {
            return $this->getErrorResponse('-i must be a exists file include request content');
        }

        $fromLogic = RequestFactory::get($from);
        $toLogic = RequestFactory::get($to);

        $request = $fromLogic->getRequest(file_get_contents($fromContentFile));
        $toLogic->setRequest($request);

        $output = $this->parameter->getOption('o');
        $content = $toLogic->getContent();
        if ($output) {
            $output = $this->convertPath($output);
            file_put_contents($output, $content);
            return $this->getSuccessResponse('wrote to ' . realpath($output));
        } else {
            return $this->getSuccessResponse(PHP_EOL . $content);
        }
    }

    /**
     * 获取帮助信息
     *
     * @return Options
     */
    protected function getOptions()
    {
        $options = parent::getOptions();
        $options->add('f', 'file format from');
        $options->add('t', 'file format to be');
        $options->add('i', 'file name of request file from');

        return $options;
    }
}
