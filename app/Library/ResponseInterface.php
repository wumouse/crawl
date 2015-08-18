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
interface ResponseInterface
{

    /**
     * @return string
     */
    public function getContent();

    /**
     * @return int
     */
    public function getCode();
}
