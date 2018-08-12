<?php
declare(strict_types = 1);

namespace Application\Autoload;

class Loader
{
	private static $dirs  = [];
	private static $registerrd = 0;
    const UNABLE_TO_LOAD = "unable to load.";

	public function __construct($dirs = [])
	{
		if($dirs)
		{
            self::init($dirs);
		}
	}

	public static function init($dirs = [])
	{
		if($dirs)
		{
            self::addDirs($dirs);
		}
		if(self::$registerrd == 0)
        {
            spl_autoload_register(__CLASS__.'::autoLoad'); // 将自动加载函数方法 注册到sql_autoload 数组中
            self::$registerrd++;
        }
	}

	public static function addDirs($dirs)
	{
		if(is_array($dirs))
		{
			self::$dirs = array_merge(self::$dirs, $dirs);
		}
		else
        {
            self::$dirs[] = $dirs;
        }
	}

	protected static function loadFile($file)
    {
        if(file_exists($file))
        {
            require_once $file;
            return TRUE;
        }
        return FALSE;
    }

    public static function autoLoad($class)
    {
        $success = FALSE;
        $fn = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
        foreach (self::$dirs as $start)
        {
            $file = $start.DIRECTORY_SEPARATOR.$fn;
            if(self::loadFile($file))
            {
                $success = TRUE;
                break;
            }
        }
        if(false == $success)
        {
            if(false == self::loadFile(__DIR__.DIRECTORY_SEPARATOR.$fn))
            {
                throw  new \Exception(self::UNABLE_TO_LOAD.''.$class);
            }
        }

        return $success;
    }
}
