<?php

		
class Block{
	
	public  $Seq;
	public  $Hash;
	public  $PrevHash;
	public  $Data;
	public  $TimeStamp ;
	public  $nonce;

	 
	
	 function set_up($prevh ,$data, $sq){
		$this->Data			= $data;
		$date = new DateTime();
		$this->TimeStamp 	= $date->getTimestamp();
		$this->Seq 	= $sq;
		$this->nonce = 0;
		
		if($sq==0){
			$this->PrevHash		= 0;
		}else{
			$this->PrevHash		= $prevh;
		}
	
		 
		 $this->Hash = $this->calculateHash();
		
	 
	 }
	
	 
	 function set_hash($v)			{	$this->Hash 		= $v;}
	 function set_prevHash($v)		{ 	$this->PrevHash 	= $v;}
	 function set_timeStamp($v) 	{ 	$this->TimeStamp 	= $v;}
	 function set_data($v) 			{	$this->Data 		= $v;}
	 function set_seq($v) 			{ 	$this->Seq			= $v;}
	 function set_nonce($v) 		{ 	$this->nonce		= $v;}
	 
	  
  // getters 
	
	 function get_hash()		{	return	$this->Hash ;		}
	 function get_prevHash()	{ 	return	$this->PrevHash ;	}
	 function get_data()		{	return	$this->Data ;		}
	 function get_timeStamp() 	{ 	return	$this->TimeStamp ;	}
	 function get_seq() 		{ 	return	$this->Seq ;		}
	 function get_nonce() 		{ 	return	$this->nonce ;		}
	 
	 function calculateHash(){
		 
		 $string = ($this->PrevHash).($this->TimeStamp).($this->Data).((string)$this->nonce);
		 $hash = hash('tiger192,3', $string );
		 return $hash;
		 
	 }
	 function print_block(){
		echo "SEQ::".$this->get_seq()."<br>";
		echo "HASH::".substr($this->get_hash(),0,5)."<br>";
		echo "PREVH::".substr($this->get_prevHash(),0,5)."<br>";
	
	 }
	 
	static function cmp($a, $b) {
    if ($a->get_seq() == $b->get_seq() ) {
		
        return 0; }
	
    return ($a->get_seq()  < $b->get_seq() ) ? -1 : 1;
}

}



function prepareBlock($Grade ,$IDCode , $con ){
	
	
		$empty_table = true;
		$has_seq = false ;
		
		$curr_hash;
		$curr_prevhash;
		$curr_seq;
		
		$query_inf = "SELECT 	IDCode,
								Sequence,
								Hash,
								Grade,
								Prev_hash,
								timeStamp,
								nonce
								FROM `Report_Table` join `{$GLOBALS['block_table']}` USING (IDCode) ORDER BY Sequence ";
								
		$res = $con->query($query_inf);
		
		$last_block;
		$curr_block;
		$curr_idx;
		
	if ($res->num_rows > 0) {
		// output data of each row
		$blocks = array();
	
		$empty_table = false;
		
		$max_seq=-1;
		$i =0;
		
		while($row_ = $res->fetch_assoc()) {
			
			$block_ = new Block();
			
			$block_->set_seq($row_["Sequence"]); 
			$block_->set_prevHash($row_["Prev_hash"]);
			$block_->set_hash($row_["Hash"]);
			$block_->set_timeStamp($row_["timeStamp"]);
			$block_->set_nonce($row_["nonce"]);
			
			$block_->set_data($row_["Grade"]);
		
			
			//$block_->print_block();
			if($row_["Sequence"]>=$max_seq){
				$last_block = $block_;
				
			}
			
			if(strcmp($IDCode, rtrim($row_["IDCode"])) == 0)
			{
				$curr_idx = $i;
				$curr_block = $block_;
				
				if( $row_["Sequence"] != -1)
				{
					$has_seq = true;
				}
			}
			
			$blocks[$i] = $block_ ;
			$i++;
			
		}
	} else {
		echo "0 results";
	}

	
	// dose the grade I am trying to update  have a sequence number? 
	if($has_seq){
		
		$curr_seq = $curr_block->get_seq();
	
		$blocks[$curr_idx]->set_data($Grade);
	
		
	}else{
		
		$prvh	= $last_block->get_Hash();
		
		
		$block = new Block();
		$block ->set_up($prvh,$Grade, $last_block->get_seq()+1);
		
		mine($block,2);
		
		$size = count($blocks);
		$blocks[$curr_idx] = $block;
	
		
	}
	
		
		$valid = IsChainValid($blocks);
		
		if($valid){
			//UPDATE 
			admin_logger("Valid blockchain..");
			return $block;
			
		}else{
			admin_logger("not valid blockchain..");
			unset($block) ;
			return false;
			// echo erro 
		}
}

function mine($block,$difficulty)
    {
        while (substr($block->Hash, 0, $difficulty) !== str_repeat("0", $difficulty)) {
		
            $block->nonce++;
            $block->Hash = $block->calculateHash();
			
			if($block->nonce%5==0){
					echo "<span> * <span> ";
			}
        }
		echo "<br>";
        admin_logger("Block_".$block->Seq."_ mined");
    }
	
function IsChainValid($blocks){
	
	//uasort($blocks, array("Block", "cmp"));
	
	
	$blocks_new = array();
	
	foreach($blocks as $value ){
		$blocks_new[$value->get_seq()]=$value;
		
	}
	
	unset($blocks_new[-1]);
	

	
	$len = count($blocks_new);
	for($i = 0 ; $i< $len ;$i++)
	{
		
			$currow = $blocks_new[$i];
			
			if($i==0){
				$prvh = 0 ;
				$currprevh = 0;
				$currh = rtrim($currow->get_Hash());
				$calh  = rtrim($currow->calculateHash());
				
			}else{
				$prevrow	= $blocks_new[$i-1];
				$prvh 		= rtrim($prevrow->get_Hash());
				$currprevh	= rtrim($currow->get_prevHash());
				$currh		= rtrim($currow->get_Hash());
				$calh  		= rtrim($currow->calculateHash());
			} 
		
			
			if(strcmp($prvh ,$currprevh)!=0){
				return false ;
			} 
			
		
			if(strcmp($currh,$calh )!=0){
				return false ;
			} 
		
	} 
	return true;
}


function print_($blocks){
	
	/*  foreach($blocks as $value){
		 
			$value->block_print_();
	
	}  */
	 $len = count($blocks);
	
	for($i = 0 ; $i< $len ;$i++){
		
		echo $i."<br>";
		$blocks[$i]->print_block();
	} 
}






?>