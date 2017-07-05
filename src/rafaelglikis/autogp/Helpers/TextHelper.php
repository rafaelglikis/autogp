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

    function input()
    {
        $fr=fopen("php://stdin","r");   // open our file pointer to read from stdin
        $input = fgets($fr,128);        // read a maximum of 128 characters
        $input = rtrim($input);         // trim any trailing spaces.
        fclose ($fr);                   // close the file handle
        return $input;                  // return the text entered
    }
}
