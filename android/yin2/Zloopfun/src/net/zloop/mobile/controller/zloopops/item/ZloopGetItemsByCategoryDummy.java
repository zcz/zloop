package net.zloop.mobile.controller.zloopops.item;

import java.lang.ref.WeakReference;
import java.util.ArrayList;
import java.util.List;

import net.zloop.mobile.controller.database.DataSourceCallback;
import net.zloop.mobile.controller.zloopops.ZloopJob;
import net.zloop.mobile.controller.zloopops.ZloopTaskStatus;
import net.zloop.mobile.model.Item;

public class ZloopGetItemsByCategoryDummy extends ZloopJob{
	
	private int categoryId;
	public ZloopGetItemsByCategoryDummy(int categoryId) {
		super();
		this.categoryId = categoryId;
	}
	public Object getResult() {
		List<Item> items = new ArrayList<Item>();
		items.add(new Item(0, "DummyTitle1", 10, 100, "DummyContent", "DummyPresentation", "DummySummary", "DummyTag", 0, 0, 0, categoryId, 0, 0, 0, 0, 0, null));
		items.add(new Item(0, "DummyTitle2", 10, 100, "DummyContent", "DummyPresentation", "DummySummary", "DummyTag", 0, 0, 0, categoryId, 0, 0, 0, 0, 0, null));
		return items;
	}

}
