<?php
class Jsoner implements ArrayAccess, IteratorAggregate, countable{

	/**
	 * FileLoader
	 * @var fileloader object
	 */
	protected $fileLoader;

	/**
	 * Content of the json file
	 * @var array
	 */
	protected $items = array();

	/**
	 * load the content in the items array
	 */
	public function __construct( array $data = array() )
	{
		$this->items = $data;
	}

	/**
	 * Load file
	 * @param  string $filename
	 */
	public function load($file)
	{
		$this->fileLoader = new FileLoader( $file );
		$this->setData();
	}

	/**
	 * Put the content(array) of the json in items.
	 */
	private function setData()
	{
		$this->items = $this->fileLoader->getContent();
	}

	/**
	 * Check if content has key
	 * @param  string  $key
	 * @return boolean
	 */
	public function has($key)
	{
		return null !== $this->get($key);
	}

	/**
	 * Get value from key
	 * @param  string $key
	 * @return value
	 */
	public function __get($key)
	{
		return $this->get($key);
	}

	/**
	 * Get value from key
	 * @param  string $key
	 * @return value
	 */
	public function get($key)
	{
		$key = trim($key, '.');
		$keys = explode('.', $key);
		return $this->_get( $keys, $this->items );
	}

	/**
	 * Get helpers if key contains '.' 
	 * @param  string $keys
	 * @param  array $items
	 * @return value
	 */
	private function _get($keys, $items)
	{
		$key = array_shift($keys);
		if ( array_key_exists( $key, $items ) ) $value = $items[$key];
		if ( empty($keys) ) {
			if ( ! isset($value) ) return null;
			if ( is_string($value) || is_numeric($value) ) return $value;
			return new Jsoner( $value );
		}
		return $this->_get($keys, $value);
	}

	/**
	 * Set value of key
	 * @param  string $key
	 * @param  string $value
	 */	
	public function __set($key, $value)
	{
		return $this->set($key, $value);
	}

	/**
	 * Delete one key from the items
	 * @param  string $key
	 */
	public function forget($key)
	{
		$key = trim($key, '.');
		$keys = explode('.', $key);
		return $this->_forget( $keys, $this->items );
	}

	/**
	 * Helper of forget if key has '.'
	 * @param  string $keys
	 * @param  array $items
	 */
	public function _forget($keys, &$items)
	{
		$key = array_shift($keys);
		if ( empty($keys) ) {
			unset( $items[$key] );
		}else{
			return $this->_forget($keys, $value, $items[$key]);
		}
	}

	/**
	 * Set value of key
	 * @param string $key
	 * @param mix $value
	 */
	public function set($key, $value)
	{
		$key = trim($key, '.');
		$keys = explode('.', $key);
		return $this->_set( $keys, $value, $this->items );
	}

	/**
	 * Set method helper if key has '.'
	 * @param string $keys
	 * @param mix $value
	 */
	public function _set($keys, $value, &$items)
	{
		$key = array_shift($keys);
		if ( empty($keys) ) {
			$items[$key] = $value;
		}else{
			return $this->_set($keys, $value, $items[$key]);
		}
	}

	/**
	 * Return raw array items.
	 * @return array
	 */
	public function toArray()
	{
		return $this->items;
	}

	/**
	 * Check if the offset exists 
	 * @param  string $key
	 * @return boolean
	 */
	public function offsetExists($key)
	{
		return null !== $this->get($key);
	}

	/**
	 * Set offset
	 * @param  string $key
	 * @param  mix $value
	 */
	public function offsetSet($key, $value)
	{
		return $this->set($key, $value);
	}

	/**
	 * Get value from key.
	 * @param  string $key
	 * @return value
	 */
	public function offsetGet($key)
	{
		return $this->get($key);
	}

	/**
	 * Forget a key from the items.
	 * @param  string $key
	 */
	public function offsetUnset($key)
	{
		$this->forget($key);	
	}

	/**
	 * Save modifications.
	 * @param  string $file filename
	 */
	public function save($file = null)
	{
		$this->fileLoader->save($file, $this->items);
	}

	/**
	 * Itterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->items);
	}

	/**
	 * Count
	 * @return int
	 */
	public function count()
	{
		return count($this->items);
	}


}