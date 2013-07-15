package net.zloop.mobile.controller.database;

import com.j256.ormlite.dao.Dao;
import com.j256.ormlite.dao.RuntimeExceptionDao;

import net.zloop.mobile.R;
import net.zloop.mobile.controller.zloopops.ZloopTaskCallback;
import net.zloop.mobile.model.Item;
import net.zloop.mobile.model.ItemImg;
import net.zloop.mobile.model.User;

public class ZloopFragmentActivity extends OrmLiteFragmentActivity<DatabaseHelper> implements ZloopTaskCallback{

	public void onSuccess(int id, Object result) {
		
	}

	public boolean isConnected() {
		return  ConnectionUtil.isConnected(this);
//		return false;
	}

	public Dao<User, Integer> getUserDao() {
		return getHelper().getUserDao();
	}

	public Dao<Item, Integer> getItemDao() {
		return getHelper().getItemDao();
	}

	public Dao<ItemImg, Integer> getItemImgDao() {
		return getHelper().getItemImgDao();
	}

	public void onHttpAuthenticationFail(int id) {
		
	}

	public void onHttpNotFound(int id) {
		
	}

}
