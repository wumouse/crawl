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
class DOMNodeResultSet implements \Iterator
{
    /**
     *
     *
     * @var int
     */
    protected $pointer;

    /**
     *
     *
     * @var \DOMNodeList
     */
    private $result;

    /**
     * @param \DOMNodeList $result
     */
    public function __construct($result)
    {
        $this->result = $result;
        $this->pointer = 0;
    }

    /**
     * @return \DOMElement
     */
    public function current()
    {
        return $this->result->item($this->pointer);
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->pointer;
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        $this->pointer++;
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->pointer = 0;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return $this->result->length !== $this->pointer;
    }
}
