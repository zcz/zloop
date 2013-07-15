package net.zloop.mobile.controller;

import java.util.List;

import net.zloop.mobile.R;
import net.zloop.mobile.controller.database.ZloopFragmentActivity;
import net.zloop.mobile.controller.zloopops.ZloopTask;
import net.zloop.mobile.controller.zloopops.comment.ZloopPostCommentImpl;
import net.zloop.mobile.controller.zloopops.item.ZloopGetAllItemsImpl;
import net.zloop.mobile.controller.zloopops.login.ZloopLoginImpl;
import net.zloop.mobile.imageCache.CacheCallback;
import net.zloop.mobile.model.Comment;
import net.zloop.mobile.model.Item;
import net.zloop.mobile.model.LoginData;
import android.os.Bundle;
import android.support.v4.view.ViewPager;
import android.util.Log;
import android.widget.ImageView;
import android.widget.TabHost;

public class OpsTestActivity extends ZloopFragmentActivity implements
		CacheCallback {
	TabHost mTabHost;
	ViewPager mViewPager;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		Log.d("onZloopStart", "onCreate:");
		// dummy call
//		 new ZloopTask(this).execute(new ZloopLoginDummy(new LoginData("demo",
//		 "demo")));
		// new ZloopTask(this).execute(new ZloopGetItemDummy(0));
		// new ZloopTask(this).execute(new ZloopPostItemDummy(new Item(0,
		// "DummyTitle", 10, 100, "DummyContent", "DummyPresentation",
		// "DummySummary", "DummyTag", 0, 0, 0, 101, 0, 0, 0, 0, 0, null)));

		// real call
		 new ZloopTask(this).execute(new ZloopLoginImpl(new LoginData("demo",
		 "demo")));
		
		// new ZloopTask(this).execute(new
		// ZloopGetItemsByCategoryImpl(categoryId));
		// cache implementation
		/*
		 * Cache.setupCache(this); setContentView(R.layout.opstest); ImageView
		 * iv = (ImageView) findViewById(R.id.opsimageview); iv.setTag("hello");
		 * Cache.loadImage(this, this,
		 * "http://www4.comp.polyu.edu.hk/~csweilou/comp437/image/PolyULogo.gif"
		 * , 0, iv);
		 */
		// getItem list by int category
		// new ZloopTask(this).execute(new ZloopGetItemImpl(101));

		// search by keywords eg
		// http://localhost/zloop/index.php/api/item?keyString=a%20bcd
		// new ZloopTask(this).execute(new ZloopSearchItem("a bcd"));'

		/*
		 * ArrayList<ItemImg> pics = new ArrayList<ItemImg>(); pics.add(new
		 * ItemImg("15")); pics.add(new ItemImg("16")); Item mItem = new Item(0,
		 * "DummyTitle", 10, 100, "DummyContent", "DummyPresentation",
		 * "DummySummary", "DummyTag", 0, 0, 0, 101, 0, 0, 0, 0, 0, pics);
		 * 
		 * new ZloopTask(this).execute(new ZloopPostItemImpl(mItem));
		 */
	}

	int i = 0;

	public void onSuccess(int id, Object result) {
		/*
		 * TextView tv = (TextView) findViewById(R.id.opstextview);
		 * ArrayList<Item> items = (ArrayList<Item>) result; for (Item item :
		 * items) { tv.setText(tv.getText() + item.toString()+"\n"); }
		 */
		new ZloopTask(this).execute(new ZloopGetAllItemsImpl());
		if (result instanceof List ) {
			
			List<Item> items = (List<Item>) result;
			Item item = items.get(0);
			String uri = item.getUri();

			new ZloopTask(this).execute(new ZloopPostCommentImpl(new Comment(
					"hello", item.getUri())));
			i++;
		}
		i++;
		/*
		 * if (i == 0) {
		 * 
		 * // post item implementation ArrayList<ItemImg> pics = new
		 * ArrayList<ItemImg>(); Item item = new Item(0, "DummyTitle", 10, 100,
		 * "DummyContent", "DummyPresentation", "DummySummary", "DummyTag", 0,
		 * 0, 1, 101, 0, 0, 0, 0, 0, null); pics.add(new ItemImg(
		 * "file:///storage/emulated/0/Pictures/Zloop/IMG_20130507_165753.jpg",
		 * item)); pics.add(new ItemImg(
		 * "file:///storage/emulated/0/Pictures/Zloop/IMG_20130506_172314.jpg",
		 * item)); pics.add(new ItemImg(
		 * "file:///storage/emulated/0/Pictures/Zloop/IMG_20130505_163346.jpg",
		 * item));
		 * 
		 * item.setPics(pics); new ZloopTask(this).execute(new
		 * ZloopPostItemImpl(item)); } i++;
		 */
		// List<Item> items = (List<Item>) result;
		// Log.d("onZloopSuccess", "size is: " + items.size());
	}

	public void onHttpNotFound() {
		// TODO Auto-generated method stub

	}

	public void onHttpAuthenticationFail(int id) {
		int i = 0;
		i++;
	}

	public void onHttpNotFound(int id) {

	}

	public ImageView findImageViewWithTag(Object o) {
		return (ImageView) findViewById(R.id.opsTestView).findViewWithTag(o);
	}

}
