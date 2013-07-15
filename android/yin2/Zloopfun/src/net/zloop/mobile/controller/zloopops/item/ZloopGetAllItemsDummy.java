package net.zloop.mobile.controller.zloopops.item;

import java.lang.ref.WeakReference;
import java.util.ArrayList;
import java.util.List;

import net.zloop.mobile.controller.database.DataSourceCallback;
import net.zloop.mobile.controller.zloopops.ZloopJob;
import net.zloop.mobile.controller.zloopops.ZloopTaskStatus;
import net.zloop.mobile.model.Item;

public class ZloopGetAllItemsDummy extends ZloopJob {
	public Object getResult() {
		// TODO Auto-generated method stub
		List<Item> items = new ArrayList<Item>();
		items.add(new Item(0, "DummyTitle", 10, 100, "DummyContent",
				"DummyPresentation", "DummySummary", "DummyTag", 0, 0, 0, 101,
				0, 0, 0, 0, 0, null));
		items.add(new Item(1, "DummyTitle", 10, 100, "DummyContent",
				"DummyPresentation", "DummySummary", "DummyTag", 0, 0, 0, 101,
				0, 0, 0, 0, 0, null));
		return items;
	}
}
