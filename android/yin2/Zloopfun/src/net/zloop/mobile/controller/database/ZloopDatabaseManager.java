package net.zloop.mobile.controller.database;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Iterator;
import java.util.List;

import net.zloop.mobile.model.Category;
import net.zloop.mobile.model.Item;
import net.zloop.mobile.model.ItemImg;
import net.zloop.mobile.model.User;

public class ZloopDatabaseManager {
	public static User getMe(DataSourceCallback helper) {
		List<User> me = null;
		try {
			me = helper.getUserDao().queryForAll();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		if (me.size() > 0) {
			return me.get(0);
		}
		return null;
	}

	public static String getCurrentSessionId(DataSourceCallback helper) {
		User me = getMe(helper);
		if (me != null) {
			return me.getSession();
		}
		return "";
	}
	
	public static List<Item> getItemsByCategoryId (DataSourceCallback helper, int categoryid) {
		List<Item> rv = new ArrayList<Item>();
		try {
			List<Item> rv1 = helper.getItemDao().queryForAll();
			for (Iterator iterator = rv1.iterator(); iterator.hasNext();) {
				Item item = (Item) iterator.next();
				
				int parentId = Category.getParentCategoryId(item.getCategoryid());
				if(parentId == categoryid) {
					rv.add(item);
				}
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return rv;
	}
	public static List<Item> getAllItem(DataSourceCallback helper) {
		List<Item> rv = null;
		try {
			rv = helper.getItemDao().queryForAll();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return rv;
	}
	public static void updateUser(DataSourceCallback helper, User user) {
		try {
			List<User> list = helper.getUserDao().queryForEq("username", user.getUsername());
			if (list.size() > 0) {
				User mUser = list.get(0);
				user.setId(mUser.getId());
				helper.getUserDao().update(user);
			}
			else {
				createNewUser(helper, user);
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	public static void updateItem(DataSourceCallback helper, Item item) {
		try {
			List<Item> list = helper.getItemDao().queryForEq("uri", item.getUri());
			if (list.size() > 0) {
				item.setId(list.get(0).getId());
				helper.getItemDao().update(item);
			}
			else {
				createNewItem(helper, item);
			}
			list = helper.getItemDao().queryForEq("uri", item.getUri());
			Collection<ItemImg> pics = item.getPics();
			for (Iterator iterator = pics.iterator(); iterator.hasNext();) {
				ItemImg itemImg = (ItemImg) iterator.next();
				itemImg.setItem(item);
				updateItemImg(helper, itemImg);
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	private static void createNewUser(DataSourceCallback helper, User user) {
		User mUser = newUser(helper);
		user.setId(mUser.getId());
		try {
			helper.getUserDao().update(user);
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}

	public static void createNewItem(DataSourceCallback helper, Item item) {
		Item mItem = newItem(helper);
		item.setId(mItem.getId());
		try {
			helper.getItemDao().update(item);
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}

	public static void updateItemImg(DataSourceCallback helper, ItemImg itemImg) {
		try {
			List<ItemImg> list = helper.getItemImgDao().queryForEq("uri", itemImg.getUri());
			if (list.size() > 0) {
				itemImg.setId(list.get(0).getId());
				helper.getItemImgDao().update(itemImg);
			}
			else {
				createNewItemImg(helper, itemImg);
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	public static void createNewItemImg(DataSourceCallback helper, ItemImg itemImg) {
		ItemImg mItemImg = newItemImg(helper);
		itemImg.setId(mItemImg.getId());
		try {
			helper.getItemImgDao().update(itemImg);
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	public static ItemImg newItemImg(DataSourceCallback helper) {
		ItemImg itemImg = new ItemImg();
		try {
			helper.getItemImgDao().create(itemImg);
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return itemImg;
	}
	public static Item newItem(DataSourceCallback helper) {
		Item item = new Item();
		try {
			helper.getItemDao().create(item);
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return item;
	}
	private static User newUser(DataSourceCallback helper) {
		User user = new User();
		try {
			helper.getUserDao().create(user);
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return user;
	}
}
