package net.zloop.mobile.controller.zloopops.item;

import net.zloop.mobile.controller.zloopops.ZloopJob;
import net.zloop.mobile.model.Item;

public class ZloopPostItemDummy extends ZloopJob {
	private Item mItem;
	public ZloopPostItemDummy(Item mItem) {
		super();
		this.mItem = mItem;
	}

	public Object getResult() {
		// TODO Auto-generated method stub
		return mItem;
	}
}
