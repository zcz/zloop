package net.zloop.mobile.controller.zloopops;

import net.zloop.mobile.controller.database.DataSourceCallback;

public interface ZloopTaskCallback extends DataSourceCallback{
	public void onSuccess(int id, Object result);
	public void onHttpAuthenticationFail(int id);
	public void onHttpNotFound(int id);
	public String getString(int id);
	public boolean isConnected();
}
