<?php
/**
 * crawl.
 *
 * @author Haow1 <haow1@jumei.com>
 * @version $Id$
 */

use Phalcon\Di;
use Phalcon\Loader;

$di = new Di();

try {
    $loader = new Loader();
    $loader->registerNamespaces([

    ])->register();
} catch (Exception $e) {
    echo $e , '  code: ' . $e->getCode();
}
