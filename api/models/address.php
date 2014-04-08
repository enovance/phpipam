<?php

/**
 *    phpIPAM Address class
 */

class Address
{    
    
    /**
    * get address details
    */
    public function getAddress() {
    
        /**
        * all addresses 
        */
        if($this->all) {
            //get address by id
            $res = fetchAllIPAddresses ();
        }

        /** 
        * all addresses in subnet
        */
        elseif($this->subnetId) {
            //id must be set and numberic
            if ( is_null($this->subnetId) || !is_numeric($this->subnetId) ){ throw new Exception('Invalid subnet Id - '.$this->subnetId); }
            //get all addresses in subnet
            $res = fetchAddresses ($this->subnetId);
            //throw new exception if not existing
            if(sizeof($res)==0) {
                //check if subnet exists
                if(sizeof(getSubnetDetailsById ($this->subnetId))==0){ throw new Exception('Subnet not existing');    }
            }
        }
        
        /** 
        * address by id 
        */
        elseif($this->id) {
            //id must be set and numberic
            if ( is_null($this->id) || !is_numeric($this->id) )                 { throw new Exception('Address id not existing - '.$this->id); }
            //get address by id
            $res = getAddressDetailsById ($this->id);
            //throw new exception if not existing
            if(sizeof($res)==0)                                                 { throw new Exception('Address not existing'); }
        }
        
        /**
        * address by name 
        */
        elseif($this->name) {
            //id must be set and numberic
            if ( is_null($this->name) || strlen($this->name)==0 )               { throw new Exception('Invalid address name - '.$this->name); }
            //get address by id
            $res = getAddressDetailsByName ($this->name);
            //throw new exception if not existing
            if(sizeof($res)==0)                                                 { throw new Exception('Address not existing'); }
        }
        
        /** 
        * method missing 
        */
        else                                                                    { throw new Exception('Selector missing'); }

        //create object from results
        foreach($res as $key=>$line) {
            $this->$key = $line;
        }
        //output format
        $format = $this->format;
        //remove input parameters from output
        unset($this->all);                                                            //remove from result array
        unset($this->format);
        unset($this->name);    
        unset($this->id);
        unset($this->subnetId);    
        //convert object to array
        $result = $this->toArray($this, $format);    
        //return result
        return $result;
    }


    /**
    * create new address
    */

    public function createAddress() {
        # verications
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
        if(!isset($this->subnetId) || !is_numeric($this->subnetId))               { throw new Exception('Invalid subnet Id'); }                //mandatory parameters
        if(!isset($this->ip_addr))                                                { throw new Exception('Invalid address'); }                  //mandatory parameters
        // if($this->allowRequests != 0 || $this->allowRequests !=1)                 { throw new Exception('Invalid allow requests value'); }
        // if($this->showName != 0 || $this->showName !=1)                           { throw new Exception('Invalid show Name value'); }
        // if($this->pingAddress != 0 || $this->pingAddress !=1)                     { throw new Exception('Invalid ping address value'); }


        //output format
        $format = $this->format;
        
        //create array to write new subnet
        $newAddress = $this->toArray($this, $format);
        //create new address
        #$res = UpdateSubnet2 ($newSubnet, true);                                //true means from API    
        $res = UpdateAddress ($newAddress, true);                                //true means from API    
        //return result (true/false)
        if(!$res)                                                                 { throw new Exception('Invalid query'); } 
        else {
            //format response
            return "Address created";        
        }
    }
    

    /**
    * function to return multidimensional array
    */
    public function toArray($obj, $format)
    {
        //if object create array
        if(is_object($obj)) $obj = (array) $obj;
        if(is_array($obj)) {
            $arr = array();
            foreach($obj as $key => $val) {
                // proper format
                if($key=="ip_addr" && $format=="ip") {
                    $val = transform2long($val);
                }
                // output format
                $arr[$key] = $this->toArray($val, $format);
            }
        }
        else { 
            $arr = $obj;
        }
        //return an array of items
        return $arr;
    }
}
