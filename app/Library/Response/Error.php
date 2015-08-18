<?php
/**
 * requestDataConverter.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace Library\Response;

use Library\Response;

/**
 *
 *
 * @package Library
 */
class Error extends Response
{
    /**
     * @return int
     */
    public function getCode()
    {
        return 1;
    }
}
