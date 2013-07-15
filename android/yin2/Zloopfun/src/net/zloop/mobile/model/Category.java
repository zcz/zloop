package net.zloop.mobile.model;

import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.Iterator;
import java.util.Map;

import com.google.common.collect.BiMap;
import com.google.common.collect.HashBiMap;

/*
 * 		array("id"=>000, "parentid"=>000,"title"=>"All Categories"),

		//Textbook category
		array("id"=>001,	"parentid"=>000,	"title"=>"Books"),
		array("id"=>101,	"parentid"=>001,	"title"=>"Arts & Design"),
		array("id"=>102,	"parentid"=>001,	"title"=>"Business"),
		array("id"=>103,	"parentid"=>001,	"title"=>"Engineering"),
		array("id"=>104,	"parentid"=>001,	"title"=>"Humanities"),
		array("id"=>105,	"parentid"=>001,	"title"=>"Science"),
		array("id"=>106,	"parentid"=>001,	"title"=>"Fiction & Literature"),
		array("id"=>107,	"parentid"=>001,	"title"=>"Magazines"),
		array("id"=>108,	"parentid"=>001,	"title"=>"Notes & Papers"),		
		array("id"=>109,	"parentid"=>001,	"title"=>"Others"),
		
		//entertainment category
		array("id"=>002,	"parentid"=>000,	"title"=>"Entertainment"),
		array("id"=>201,	"parentid"=>002,	"title"=>"CDs & DVDs"),
		array("id"=>202,	"parentid"=>002,	"title"=>"Video Games"),
		array("id"=>203,	"parentid"=>002,	"title"=>"Animation & Comics"),
		array("id"=>204,	"parentid"=>002,	"title"=>"Others"),
		
		//electronics category
		array("id"=>003,	"parentid"=>000,	"title"=>"Electronics"),
		array("id"=>301,	"parentid"=>003,	"title"=>"Computers"),
		array("id"=>302,	"parentid"=>003,	"title"=>"Cell phones"),
		array("id"=>303,	"parentid"=>003,	"title"=>"TV, Video & Audio"),
		array("id"=>304,	"parentid"=>003,	"title"=>"Cameras & Photo"),
		array("id"=>305,	"parentid"=>003,	"title"=>"Accessories"),
		array("id"=>306,	"parentid"=>003,	"title"=>"Others"),

		//Cosmetics
		array("id"=>004,	"parentid"=>000,	"title"=>"Cosmetics"),
		array("id"=>401,	"parentid"=>004,	"title"=>"Makeup"),
		array("id"=>402,	"parentid"=>004,	"title"=>"Perfume"),
		array("id"=>403,	"parentid"=>004,	"title"=>"Skin care"),
		array("id"=>404,	"parentid"=>004,	"title"=>"Hair care"),
		array("id"=>405,	"parentid"=>004,	"title"=>"Nail care"),
		array("id"=>406,	"parentid"=>004,	"title"=>"Others"),
		
		//fashion and clothes
		array("id"=>005,	"parentid"=>000,	"title"=>"Fashion & Clothes"),
		array("id"=>501,	"parentid"=>005,	"title"=>"Formal suits"),
		array("id"=>502,	"parentid"=>005,	"title"=>"Formal dresses"),
		array("id"=>503,	"parentid"=>005,	"title"=>"Accessories"),
		array("id"=>504,	"parentid"=>005,	"title"=>"Casual"),
		array("id"=>505,	"parentid"=>005,	"title"=>"Shoes"),
		array("id"=>506,	"parentid"=>005,	"title"=>"Others"),
			
		array("id"=>006,	"parentid"=>000,	"title"=>"Household Goods"),
		array("id"=>601,	"parentid"=>006,	"title"=>"Furnitures"),
		array("id"=>602,	"parentid"=>006,	"title"=>"Household Appliances"),
		array("id"=>603,	"parentid"=>006,	"title"=>"Others"),
			
		array("id"=>007,	"parentid"=>000,	"title"=>"Arts & Sports"),
		array("id"=>701,	"parentid"=>007,	"title"=>"Musical Instruments"),
		array("id"=>702,	"parentid"=>007,	"title"=>"Sports equipment"),
		array("id"=>703,	"parentid"=>007,	"title"=>"Handcrafts & Models"),
		array("id"=>704,	"parentid"=>007,	"title"=>"Toys & Hobbies"),
		array("id"=>705,	"parentid"=>007,	"title"=>"Others"),
		
		array("id"=>008,	"parentid"=>000,	"title"=>"Others"),
		array("id"=>801,	"parentid"=>008,	"title"=>"Stationery"),
		array("id"=>802,	"parentid"=>008,	"title"=>"Collectible"),
		array("id"=>803,	"parentid"=>008,	"title"=>"Others"),
		);
 */

/*
 * all the "others" categories are removed to maintain the bimap
 */

public class Category {

	static BiMap<Integer,String> category = HashBiMap.create();
	static BiMap<String, Integer> category_rev;
		
	public Category() {
		category.put(new Integer(0), "All Categories");
		
		category.put(new Integer(1), "Books");
		category.put(new Integer(101), "Arts & Design");
		category.put(new Integer(102), "Business");
		category.put(new Integer(103), "Engineering");
		category.put(new Integer(104), "Humanities");
		category.put(new Integer(105), "Science");
		category.put(new Integer(106), "Fiction & Literature");
		category.put(new Integer(107), "Magazines");
		category.put(new Integer(108), "Notes & Papers");
//		category.put(new Integer(109), "Others");

		category.put(new Integer(2), "Entertainment");
		category.put(new Integer(201), "CDs & DVDs");
		category.put(new Integer(202), "Video Games");
		category.put(new Integer(203), "Animation & Comics");
//		category.put(new Integer(204), "Others");
		
		category.put(new Integer(3), "Electronics");
		category.put(new Integer(301), "Computers");
		category.put(new Integer(302), "Cell phones");
		category.put(new Integer(303), "TV, Video & Audio");
		category.put(new Integer(304), "Cameras & Photo");
		category.put(new Integer(305), "Accessories");
//		category.put(new Integer(306), "Others");
	
		category.put(new Integer(4), "Cosmetics");
		category.put(new Integer(401), "Makeup");
		category.put(new Integer(402), "Perfume");
		category.put(new Integer(403), "Skin care");
		category.put(new Integer(404), "Hair care");
		category.put(new Integer(405), "Nail care");
//		category.put(new Integer(406), "Others");

		category.put(new Integer(5), "Fashion & Clothes");
		category.put(new Integer(501), "Formal suits");
		category.put(new Integer(502), "Formal dresses");
		category.put(new Integer(503), "Accessory");
		category.put(new Integer(504), "Casual");
		category.put(new Integer(505), "Shoes");
//		category.put(new Integer(506), "Others");
		
		category.put(new Integer(6), "Household Goods");
		category.put(new Integer(601), "Furnitures");
		category.put(new Integer(602), "Household Appliances");
//		category.put(new Integer(603), "Others");
		
		category.put(new Integer(7), "Arts & Sports");
		category.put(new Integer(701), "Musical Instruments");
		category.put(new Integer(702), "Sports equipment");
		category.put(new Integer(703), "Handcrafts & Models");
		category.put(new Integer(704), "Toys & Hobbies");
//		category.put(new Integer(705), "Others");
		
		category.put(new Integer(8), "Others");
		category.put(new Integer(801), "Stationery");
		category.put(new Integer(802), "Collectible");
//		category.put(new Integer(803), "Others");
		
		this.category_rev = this.category.inverse();
	}
	
	public String idToString(int k) {
		String s = this.category.get(new Integer(k));
		if (s != null) return s;
		else return "Others";
	}
	
	public Integer stringToId(String s) {
		return this.category_rev.get(s);
	}
	
	public ArrayList<Integer> getSelectable() {
		ArrayList<Integer> a = new ArrayList<Integer>();
		Integer i;
		Iterator it = this.category.entrySet().iterator();
	    while (it.hasNext()) {
	        Map.Entry pairs = (Map.Entry)it.next();
	        i = (Integer)pairs.getKey();
	        if ((i > 0) && (i < 10)) {
	        	a.add(i);
	        }
	    }
	    
	    Collections.sort(a);
	    
		return a;
	}

	 public static Integer getParentCategoryId(Integer i) {
		if (i>10) return i/100;
		else return i;
	}
}