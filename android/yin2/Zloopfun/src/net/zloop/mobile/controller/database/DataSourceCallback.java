package net.zloop.mobile.controller.database;

import net.zloop.mobile.model.Item;
import net.zloop.mobile.model.ItemImg;
import net.zloop.mobile.model.User;

import com.j256.ormlite.dao.Dao;

public interface DataSourceCallback {
	public Dao<User, Integer> getUserDao();
	public Dao<Item, Integer> getItemDao();
	public Dao<ItemImg, Integer> getItemImgDao();
}
