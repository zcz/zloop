package net.zloop.mobile;

import java.util.ArrayList;



public class RenderableCategory{
	private static ArrayList<CategoryIconEntry> list = new ArrayList<CategoryIconEntry>(); 
	
	static{
		list.add(new CategoryIconEntry(0,R.drawable.all_icon));
		list.add(new CategoryIconEntry(1,R.drawable.book_icon));
		list.add(new CategoryIconEntry(2,R.drawable.entertainment_icon));
		list.add(new CategoryIconEntry(3,R.drawable.electronic_icon));
		list.add(new CategoryIconEntry(4,R.drawable.cosmetic_icon));
		list.add(new CategoryIconEntry(5,R.drawable.fashion_icon));
		list.add(new CategoryIconEntry(6,R.drawable.household_icon));
		list.add(new CategoryIconEntry(7,R.drawable.art_and_sport_icon));
		list.add(new CategoryIconEntry(8,R.drawable.other_icon));
		
	}

	public static ArrayList<CategoryIconEntry> getList() {
		return list;
	}
}


class CategoryIconEntry{
	private int categoryId;
	private int iconResourceId;
	public CategoryIconEntry(int categoryId, int iconResourceId) {
		super();
		this.categoryId = categoryId;
		this.iconResourceId = iconResourceId;
	}
	public int getCategoryId() {
		return categoryId;
	}
	public void setCategoryId(int categoryId) {
		this.categoryId = categoryId;
	}
	public int getIconResourceId() {
		return iconResourceId;
	}
	public void setIconResourceId(int iconResourceId) {
		this.iconResourceId = iconResourceId;
	}
	
}