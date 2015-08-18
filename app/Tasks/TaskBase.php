<?php
/**
 * requestDataConverter.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace Tasks;

use Library\Options;
use Library\Parameter;
use Library\Response\Error;
use Library\Response\Info;
use Library\Response\Success;
use Phalcon\CLI\Task;

/**
 *
 *
 * @property Parameter $parameter
 * @package Tasks
 */
class TaskBase extends Task
{
    /**
     * 获取选项对象
     *
     * @return Options
     */
    protected function getOptions()
    {
        return new Options();
    }

    /**
     * 获取错误响应
     *
     * @param string $content
     * @return \Library\Response\Error
     */
    protected function getErrorResponse($content)
    {
        return new Error($content);
    }

    /**
     *
     *
     * @param $content
     * @return Success
     */
    protected function getSuccessResponse($content)
    {
        return new Success($content);
    }

    /**
     * @param string $content
     * @return Info
     */
    protected function getInfoResponse($content)
    {
        return new Info($content);
    }

    /**
     *
     *
     * @param string $fromContentFile
     * @return mixed
     */
    protected function convertPath($fromContentFile)
    {
        if (false !== strpos($fromContentFile, '~')) {
            $fromContentFile = str_replace('~', $_SERVER['HOME'], $fromContentFile);
        }
        return $fromContentFile;
    }
}
