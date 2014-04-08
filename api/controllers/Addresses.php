<?php

/**
 *	phpIPAM API class to work with addresses
 *
 * Reading addresses:
 *	get by id: 	?controller=addresses&action=read&id=1
 *	get by name: 	?controller=addresses&action=read&name=address name
 *	get all:	?controller=addresses&action=read&all=true
 */

class Addresses
{
	/* variables */
	private $_params;
	
	/* set parameters, provided via post */
	public function __construct($params)
	{
		$this->_params = $params;
		
		//ip address format, can be decimal or ip
		if(!$this->_params['format']){ $this->_params['format'] = "decimal"; }
		//verify IP address format
		if(!($this->_params['format']=="decimal" || $this->_params['format']== "ip")) {
			throw new Exception('Invalid format');
		}
	}

	/** 
	* create new address 
	*/
	public function createAddresses()
	{
		//init section class
                // id
                // subnetId
                // ip_addr
                // description
                // dns_name
                // mac
                // owner
                // state
                // switch
                // port
                // note
                // lastSeen
                // excludePing
                // editDate
		$address = new Address();
		//required parameters
		$address->action      		= $this->_params['action'];
		$address->subnetId        	= $this->_params['subnetId'];
		$address->ip_addr 		= $this->_params['ip_addr'];
		$address->description	  	= $this->_params['description'];
		$address->dns_name		= $this->_params['dns_name'];
		$address->mac	  		= $this->_params['mac'];
		$address->owner			= $this->_params['owner'];
		$address->state			= $this->_params['state'];
		$address->switch		= $this->_params['switch'];
		$address->port			= $this->_params['port'];
		$address->note			= $this->_params['note'];
		$address->lastSeen		= $this->_params['lastSeen'];
		$address->excludePing		= $this->_params['excludePing'];
		$address->editDate		= $this->_params['editDate'];

		//create section
		$res = $address->createAddress(); 	
		//return result
		return $res;
	}


	/** 
	* read addresses 
	*/
	public function readAddresses()
	{
		//init address class
		$address = new Address();
		
		//set IP address format
		$address->format = $this->_params['format'];
		
		//get all addresses
		if($this->_params['all']){ $address->all = true; }
		//get all addresses in address
		elseif($this->_params['subnetId']) { $address->subnetId = $this->_params['subnetId']; }
		//get address by ID
		else { $address->id = $this->_params['id']; }
		
		//fetch results
		$res = $address->getAddress(); 
		
		//return address(s) in array format
		return $res;
	}	
	
	
	/** 
	* update existing address 
	*/
	public function updateAddresses()
	{
		/* not yet implementes */
		throw new Exception('Action not yet implemented');
	}	
	
	
	/** 
	* delete address 
	*/
	public function deleteAddresses()
	{
		/* not yet implementes */
		throw new Exception('Action not yet implemented');
	}
}

?>
