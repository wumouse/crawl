#!/usr/local/bin/php
<?php
/**
 * requestDataConverter.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

use Library\Parameter;
use Library\Response\Error;
use Library\Response\Success;
use Library\ResponseInterface;
use Phalcon\CLI\Console;
use Phalcon\CLI\Dispatcher;
use Phalcon\DI\FactoryDefault\CLI;
use Phalcon\Loader;
use Phalcon\Script\Color;

if (!extension_loaded('phalcon')) {
    exit('Phalcon required' . PHP_EOL);
}

/**
 * 应用目录
 */
const APP_PATH = 'app';

$loader = new Loader();
$loader->registerNamespaces([
    'Tasks' => APP_PATH . '/Tasks',
    'Library' => APP_PATH . '/Library',
    'Logic' => APP_PATH . '/Logic',
    'Phalcon' => APP_PATH . '/Phalcon',
])->register();

$di = new CLI();

$di->set('dispatcher', function () {
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('Tasks');
    return $dispatcher;
}, true);

try {
    $console = new Console($di);
    $di->set('console', $console);
    $di->set('parameter', function () use ($argv) {
        $parameter = new Parameter($argv);
        return $parameter;
    });

    /** @var Parameter $parameter */
    $parameter = $di->get('parameter');
    $task = $console->handle($parameter->getParameters());

    /** @var ResponseInterface $response */
    $response = $task->dispatcher->getReturnedValue();
    if ($response instanceof Success) {
        echo Color::success($response->getContent());
    } elseif ($response instanceof Error) {
        echo Color::error($response->getContent());
    } else {
        echo Color::info($response->getContent());
    }

    exit($response->getCode());
} catch (Exception $e) {
    echo Color::error($e);
    exit($e->getCode());
}
