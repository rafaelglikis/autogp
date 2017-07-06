<?php
namespace rafaelglikis\autogp\Helpers;
class TextHelper
{
    # Returns the string value from data between start - end
    static function strCut(string $str,string $start=null, string $end=null): string
    {
        if ($start == null)
        {
            $intStart = 0;
        }
        if ($end == null)
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
