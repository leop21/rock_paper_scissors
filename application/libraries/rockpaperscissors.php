<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class RockPaperScissors {

	public function getFinalDelimiter($list, $start)
    {
        $finalDelimiter = $start;
        $leverage = 0;
        $encontro = false;
        
        for($i = $start; i < list.length() && !$encontro; $i++)
        {
            if($list[$i] == '[')
                $leverage --;
            if($list[$i] == ']')
            {
                if($leverage == 0)
                {
                    $finalDelimiter = $i;
                    $encontro = true;
                }
                $leverage ++;
            }
        }
        
        return ++$finalDelimiter;
    }
}

?>
