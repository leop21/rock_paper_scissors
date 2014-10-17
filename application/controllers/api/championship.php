<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Championship extends REST_Controller
{

	function upload_post(){

		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = '*';
		$config['max_size'] = '1024';
		$config['max_width']  = '0';
		$config['max_height']  = '0';

		if($this->load->library('upload', $config)){
		echo 'Loaded !';
		}else{
		echo '';//Unable to load';
		}
		if ( ! $this->upload->do_upload())
		{
		    $error = array('error' => $this->upload->display_errors());

		    echo $this->upload->display_errors();
		    //$this->load->view('upload_form', $error);
		}
		else
		{
		    $data = array('upload_data' => $this->upload->data());
		    $filename = $data['upload_data']['file_name'];
		    //echo $filename;
		    //Read file
		    $myfile = fopen("uploads/".$filename, "r") or die("Unable to open file!");
		    $tournament = fread($myfile,filesize("uploads/".$filename));
		    fclose($myfile);
		    //echo $tournament;
		    $this->registerTournament($tournament);
		    //$this->load->view('upload_success', $data);
		}
		
	}

	function download_post(){
		$this->load->helper('download');
		$data = file_get_contents('downloads/example.txt');
		force_download('example.txt', $data);
	}  

	function main_get()
	{
		//$data = $this->top_get();
		$this->load->model("Ranking_model");
		$ranking = new Ranking_model();
		$top = $ranking->getTop10(10);

		
		foreach ($top->result() as $valor) {
			 $contenido[] = '"'.$valor->player.'"';
		}

		$data = array(
		        'players' => ''
		);

		
		if(!empty($contenido))
		{
			$data = array(
			        'players' => implode(",", $contenido)
			);
		    
		}
		$this->load->view("main", $data);
	}

	function rest_post()
	{
		$this->load->view("rest_api");
	}

	function view1_get()
	{
		$this->load->view("add_championship");
	}

	function view2_get()
	{
		$this->load->view("add_result");
	}

	function reset_post()
	{
		$this->load->model("Ranking_model");
		$ranking = new Ranking_model();		

		if($ranking->reset())
		{
		    $this->response(array('status' => 'success'), 200); // 200 being the HTTP response code
		}
		else
		{
		    $this->response(array('status' => 'fail'), 404);
		}
	}

	function result_post()
	{
		$this->load->model("Ranking_model");
		$primero = new Ranking_model();
		$segundo = new Ranking_model();
		//Get player names and stores their new points
		$primero->setPlayer($_POST["first"]);
		$primero->setPoints(3);
		
		$segundo->setPlayer($_POST["second"]);
		$segundo->setPoints(0);
		
		
		if($primero->commit() && $segundo->commit())
		{
		    $this->response(array('status' => 'success'), 200); // 200 being the HTTP response code
		}

		else
		{
		    $this->response(array('status' => 'fail'), 404);
		}

		
		
	}

	function top_get()
	{
		$this->load->model("Ranking_model");
		$ranking = new Ranking_model();
		$lim = 10;

		if(!empty($_GET))
		{
			$lim = $_GET["count"];
		}
		
		$top = $ranking->getTop10($lim);

		
		foreach ($top->result() as $valor) {
			 $contenido[] = '"'.$valor->player.'"';
		}

		

		if(!empty($contenido))
		{
			$data = array(
				        'players' => implode(",", $contenido)
				);
		    $this->response($data, 200); // 200 being the HTTP response code
		}

		else
		{
		    $this->response(array('error' => 'Players could not be found'), 404);
		}

	}
	
	 function getFinalDelimiter($list, $start)
    {		
        $finalDelimiter = $start;
        $leverage = 0;
        $encontro = false;

        for($i = $start; $i < strlen($list) && !$encontro; $i++)
    	{
            if(strcmp($list[$i], "[")==0)
	    {
                $leverage --;
	    }
	    else
	    {
            if(strcmp($list[$i], "]")==0)
            {
                if($leverage == 0)
                {
                    $finalDelimiter = $i;
                    $encontro = true;
                }
                $leverage ++;
            }
	    }
        }

        return ++$finalDelimiter;
    }

    function getElements($list)
    {
        
        $player1BegDelimiter = strpos($list,"[", strpos($list,"[")+1);    
        $player1FinalDelimiter = $this->getFinalDelimiter($list, $player1BegDelimiter+1);
	$player1Length = $player1FinalDelimiter - $player1BegDelimiter;   
        
	$player2BegDelimiter = strpos($list,"[", $player1FinalDelimiter); 
        $player2FinalDelimiter = $this->getFinalDelimiter($list, $player2BegDelimiter+1);
	$player2Length = $player2FinalDelimiter - $player2BegDelimiter;
	
	$elements = array(substr($list, $player1BegDelimiter, $player1Length),
			substr($list, $player2BegDelimiter, $player2Length)
	);
        return $elements;
    }

function rstrpos ($haystack, $needle, $offset){
    $size = strlen ($haystack);
    $pos = strpos (strrev($haystack), $needle, $size - $offset);   
    return $size - $pos;
}

function getPlayerElements($player)
{
	$playPos = strpos($player,'"',strpos($player,'"',strpos($player,'"')+1)+1)+1;
	$play = $player[$playPos];
	
	$p1 = strpos($player,'"')+1;
	$p2 = strpos($player,'"',$p1);
		
	$name = substr($player, $p1, $p2 - $p1);
	
	return array($player, $name, $play);
}

    function getWinner($game)
    {

	//If the number of players is not equal to 2
	if($this->getOccurrences($game, "[")!=3)
	{
		$this->response(array('error' => 'The number of players is not equal to 2'), 404);
	}

        $players = $this->getElements($game);     
	$player1 = $this->getPlayerElements($players[0]);
	$player2 = $this->getPlayerElements($players[1]);

	//Case-insensitive
	$player1[2] = strtoupper($player1[2]);
	$player2[2] = strtoupper($player2[2]);

	if($player1[2] != 'R' && $player1[2] != 'P' && $player1[2] != 'S')
	{
		$this->response(array('error' => 'The player 1 strategy is not recognized'), 404);
	}

	if($player2[2] != 'R' && $player2[2] != 'P' && $player2[2] != 'S')
	{
		$this->response(array('error' => 'The player 2 strategy is not recognized'), 404);
	}

	$winner = $player1; 
	$loser = $player2; 
	        
        //Game logic
        if($player1[2] == 'R' && $player2[2] == 'P')
	{
            $winner = $player2;
	    $loser = $player1;
        }else
	{
            if($player1[2] == 'R' && $player2[2] == 'S')
	    {
                $winner = $player1;
		$loser = $player2;
            }else
	    {
                if($player1[2] == 'P' && $player2[2] == 'R')
                {
		    $winner = $player1;
		    $loser = $player2;
                }else
		{
                    if($player1[2] == 'P' && $player2[2] == 'S')
                    {
		        $winner = $player2;
			$loser = $player1;
                    }else
                    {
		        if($player1[2] == 'S' && $player2[2] == 'R')
                        {
			    $winner = $player2;
			    $loser = $player1;
			}
                        else
                        {
			    if($player1[2] == 'S' && $player2[2] == 'P')
                            {
			        $winner = $player1;
				$loser = $player2;
			    }
			}
		    }
		}
	    }
	}

	//Stores players in database
	$this->load->model("Ranking_model");
        $ingreso1 = new Ranking_model();
        $ingreso2 = new Ranking_model();
	//Get player names and stores their new points
	$ingreso1->setPlayer($winner[1]);
	$ingreso1->setPoints(0);
        $ingreso1->commit();
	$ingreso2->setPlayer($loser[1]);
	$ingreso2->setPoints(0);
	$ingreso2->commit();
	return $winner[0];
    }


	function getOccurrences($s, $s1)
    {
        $s2 = str_replace($s1, "", $s);
        return strlen($s) - strlen($s2);
    }

	function getTournamentWinner($game)
    {
        if($this->getOccurrences($game, "[")==3)
        {
            return $this->getWinner($game);
        }else
        {
            $legs = $this->getElements($game);
            $newGame = "[".$this->getTournamentWinner($legs[0]).", ".$this->getTournamentWinner($legs[1])."]";
            $winner = $this->getWinner($newGame);
            return $winner;
        }
    }

	function new_post()
	{	
		$this->registerTournament($_POST["data"]);
		/*$winner = $this->getTournamentWinner($_POST["data"]);	

		$winnerElements = $this->getPlayerElements($winner);
		$this->load->model("Ranking_model");
		$ingreso = new Ranking_model();
		
		//Get player names and stores their new points
		$ingreso->setPlayer($winnerElements[1]);
		$ingreso->setPoints(3);
		
		if($ingreso->commit())
        	{
            		$this->response(array('winner' => $winner), 200); // 200 being the HTTP response code
        	}

        	else
        	{
            		$this->response(array('error' => 'Winner points could not be stored'), 404);
        	}*/
	}	

	function registerTournament($tournament)
	{		
		$winner = $this->getTournamentWinner($tournament);	

		$winnerElements = $this->getPlayerElements($winner);
		$this->load->model("Ranking_model");
		$ingreso = new Ranking_model();
		
		//Get player names and stores their new points
		$ingreso->setPlayer($winnerElements[1]);
		$ingreso->setPoints(3);
		
		if($ingreso->commit())
        	{
            		$this->response(array('winner' => $winner), 200); // 200 being the HTTP response code
        	}

        	else
        	{
            		$this->response(array('error' => 'Winner points could not be stored'), 404);
        	}
	}

}
