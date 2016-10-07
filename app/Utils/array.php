<?php

namespace Test1\Utils;

class ArrayUtils
{
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