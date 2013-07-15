package net.zloop.mobile.controller.zloopops.item;

import java.util.ArrayList;
import java.util.List;

import net.zloop.mobile.controller.zloopops.ZloopJob;
import net.zloop.mobile.model.Item;

public class ZloopSearchItemDummy extends ZloopJob{

	private String keyword = "";

	public ZloopSearchItemDummy(String keyword) {
		super();
		this.keyword = keyword;
	}

	public Object getResult() {
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
