<?php
/**
 * crawl.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */
use Phalcon\Loader;

/**
 * APP 路径
 */
define('APP_PATH', __DIR__ . '/..');

$loader = new Loader();
$loader->registerNamespaces(array(
    'Tasks' => APP_PATH . '/Tasks',
    'Library' => APP_PATH . '/Library',
    'Logic' => APP_PATH . '/Logic',
    'Phalcon' => APP_PATH . '/Phalcon',
    'Test' => APP_PATH . '/Test',
))->register();
