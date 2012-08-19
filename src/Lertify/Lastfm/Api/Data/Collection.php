<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data;

use Countable,
	IteratorAggregate,
	ArrayAccess;

interface Collection extends Countable, IteratorAggregate, ArrayAccess
{
	public function get( $key );
    public function add( $item );
    public function set( $key, $value );
    public function remove( $key );
    public function clear();
    public function key();
    public function current();
    public function first();
    public function next();
    public function last();
    public function isEmpty();
    public function hasKey( $key );
    public function toArray();
}
