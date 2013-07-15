package net.zloop.mobile.model;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Iterator;
import java.util.Map;

import com.google.common.collect.BiMap;
import com.google.common.collect.HashBiMap;

/**
 * 
 * 	array("id"=>  000, "parentid"=>000, "title"=>"All Conditions"),

	array("id"=>  001, "parentid"=>000, "title"=>"For Sale"),
	array("id"=>  101, "parentid"=>001, "title"=>"New"),
	array("id"=>  102, "parentid"=>001, "title"=>"Used"),
	array("id"=>  103, "parentid"=>001, "title"=>"For parts or not working"),
	
	array("id"=>  002, "parentid"=>000, "title"=>"Not For Sale"),
	array("id"=>  201, "parentid"=>002, "title"=>"Sold"),
	array("id"=>  202, "parentid"=>002, "title"=>"For Share"),
	//array("id"=>  203, "parentid"=>002, "title"=>"Expired"),
 */



public class Condition {
	
	static BiMap<Integer,String> condition = HashBiMap.create();
	static BiMap<String, Integer> condition_rev;
	
	public Condition() {
		condition.put(new Integer(0), "All Conditions");
		
		condition.put(new Integer(1), "For Sale");
		condition.put(new Integer(101), "New");
		condition.put(new Integer(102), "Used");
		condition.put(new Integer(103), "For parts or not working");
		
		condition.put(new Integer(2), "Not For Sale");
		condition.put(new Integer(201), "Sold");
		condition.put(new Integer(202), "For Share");
		condition.put(new Integer(203), "Expired");
		
		this.condition_rev = this.condition.inverse();
    }
	
	public String idToString(int k) {
		return this.condition.get(new Integer(k));
	}
	
	public Integer stringToId(String s) {
		return this.condition_rev.get(s);
	}
	
	public ArrayList<Integer> getSelectable() {
		ArrayList<Integer> a = new ArrayList<Integer>();
		Integer i;
		Iterator it = this.condition.entrySet().iterator();
	    while (it.hasNext()) {
	        Map.Entry pairs = (Map.Entry)it.next();
	        i = (Integer)pairs.getKey();
	        if ((i/100 == 1)) {
	        	a.add(i);
	        }
	    }
	    
	    Collections.sort(a);
	    
		return a;
	}

}