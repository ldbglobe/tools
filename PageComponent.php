<?php
namespace ldbglobe\tools;

use ldbglobe\tools\PageComponentCapture;

class PageComponent {
	static $componentRoot = null;

	function __construct($name=null)
	{
		if(!file_exists(self::$componentRoot) || !is_dir(self::$componentRoot))
			throw new \Exception(
"Invalid component directory
Settings samples :
\\ldbglobe\\tools\\PageComponent::\$componentRoot = '/var/myfolder';"
				, 1);

		$this->name = $name;
		$this->vars = array();
	}

	function getPath()
	{
		return self::$componentRoot.'/'.$this->name.'.php';
	}

	function read()
	{
		if(file_exists($this->getPath()))
		{
			ob_start();
			require($this->getPath());
			return ob_get_clean();
		}
		return false;
	}
	function flush()
	{
		echo $this->read();
	}

	function set($name,$value)
	{
		$this->vars[$name] = $value;
		return $this;
	}
	function remove($name)
	{
		unset($this->vars[$name]);
		return $this;
	}
	function get($name,$default=null)
	{
		return isset($this->vars[$name]) ? $this->vars[$name] : $default;
	}

	function hash()
	{
		return sha1($this->name.serialize($this->vars));
	}
}