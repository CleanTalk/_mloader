<?php

namespace Cleantalk\Common\Mloader;

class Mloader
{
	private static $common_namespace = '\Cleantalk\Common\\';
	private static $custom_namespace = '\Cleantalk\Custom\\';

	public static function get($module_name)
	{
        $namespace = $module_name;
        if ( $module_name === 'Request' || $module_name === 'Response' ) {
            $namespace = 'Http';

        }
        $custom_class = self::$custom_namespace . $namespace . '\\' . $module_name;
        $common_class = self::$common_namespace . $namespace . '\\' . $module_name;

		if ( class_exists($custom_class) )
		{
			if( is_subclass_of($custom_class, $common_class) ) {
				return $custom_class;
			}
			throw new \InvalidArgumentException('Called module ' . $custom_class . ' must be inherited from ' . $common_class);
		}

		if( class_exists($common_class) )
		{
			return $common_class;
		}

		throw new \InvalidArgumentException('Called module ' . $module_name . ' not found.');
	}
}
