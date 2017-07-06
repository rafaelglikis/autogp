<?php
namespace rafaelglikis\autogp\Helpers;
class TextHelper
{
    /**
     * Returns the string value from data between start - end
     * @param string $str
     * @param string|null $start
     * @param string|null $end
     * @return string
     */
    public static function strCut(string $str,string $start=null, string $end=null): string
    {
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
