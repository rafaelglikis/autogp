<?php
namespace rafaelglikis\autogp\Helpers;
class TextHelper
{
    # Returns the string value from data between start - end
    static function strCut($str, $start='', $end='')
    {
        if ($start == '')
        {
            $intStart = 0;
        }
        if ($end == '')
        {
            $intStart = @strpos($str,$start) + strlen($start);
            $cut = @substr($str,$intStart);
            return $cut;
        }
        $intStart = @strpos($str,$start) + strlen($start);
        $cut = @substr($str,$intStart);

        $intEnd = @strpos($cut,$end);
        $cut = @substr($cut,0,$intEnd);

        return $cut;
    }

}
