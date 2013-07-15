package net.zloop.mobile.controller.zloopops.login;

import java.lang.ref.WeakReference;

import net.zloop.mobile.controller.database.DataSourceCallback;
import net.zloop.mobile.controller.zloopops.ZloopJob;
import net.zloop.mobile.controller.zloopops.ZloopTaskStatus;
import net.zloop.mobile.model.LoginData;
import net.zloop.mobile.model.User;

public class ZloopLoginDummy extends ZloopJob {
	User mUser = new User(0, "demo", "demo", "demo", "", "", "", 0, 0, 0, 0, 0,
			0, 0, "");
	public Object getResult() {
		// TODO Auto-generated method stub
		return mUser;
	}

	public ZloopLoginDummy(LoginData data) {
		mUser.setUsername(data.getUsername());
		mUser.setPassword(data.getPassword());
	}
}
