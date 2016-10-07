<?php

namespace Test1\Utils;

class ArrayUtils
{
	// Unify access to a variable which may contain a single value or an array
	public static function Arrayify($valueOrArray)
	{
		if (empty($valueOrArray))
		{
			return array();
		}

		if (!is_array($valueOrArray))
		{
            return array($valueOrArray);
        }

        return $valueOrArray;
	}
}