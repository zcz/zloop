package net.zloop.mobile;

import java.util.ArrayList;
import java.util.List;

import net.zloop.mobile.controller.database.ZloopDatabaseManager;
import net.zloop.mobile.controller.database.ZloopFragmentActivity;
import net.zloop.mobile.controller.zloopops.ZloopJob;
import net.zloop.mobile.controller.zloopops.ZloopTask;
import net.zloop.mobile.controller.zloopops.comment.ZloopPostCommentImpl;
import net.zloop.mobile.controller.zloopops.item.ZloopGetItemsByCategoryImpl;
import net.zloop.mobile.controller.zloopops.item.ZloopPostItemImpl;
import net.zloop.mobile.controller.zloopops.item.ZloopSearchItemImpl;
import net.zloop.mobile.controller.zloopops.login.ZloopLoginImpl;
import net.zloop.mobile.imageCache.Cache;
import net.zloop.mobile.imageCache.CacheCallback;
import net.zloop.mobile.model.Comment;
import net.zloop.mobile.model.Item;
import net.zloop.mobile.model.ItemImg;
import net.zloop.mobile.model.LoginData;
import net.zloop.mobile.model.User;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.DialogInterface.OnCancelListener;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.FragmentTransaction;
import android.support.v4.view.ViewPager;
import android.widget.ImageView;
import android.widget.TabHost;
import android.widget.Toast;

public class MainActivity extends ZloopFragmentActivity 
	implements CacheCallback, LoginFragment.LoginCallback, HomeFragment.LogoutCallback, 
		HomeFragment.SearchCallback, ItemListFragment.LoadImageCallback, 
		PostItemFragment.PostItemCallback, CategoryFragment.CategoryCallback, ItemDetailFragment.PostCommentCallback {
	public final static String EXTRA_USER = "net.zloop.mobile.MainActivity.EXTRA_USER";
	public final static int LOGIN_JOB_ID = 1;
	public final static int LOAD_IMG_JOB_ID = 2;
	public final static int SEARCH_JOB_ID = 3;
	public final static int POST_ITEM_JOB_ID = 4;
	public final static int SELECT_CATEGORY_JOB_ID = 5;
	public final static int POST_COMMENT_JOB_ID = 6;
    TabHost mTabHost;
    ViewPager  mViewPager;
    User zloop_user = null;
    Uri capturedImageUri = null;
    ProgressDialog myProgressDialog;
    Item itemToShowDetail;
    
    PostItemFragment postItemFragment = null;
    ItemDetailFragment itemDetailFragment = null;
    ItemListFragment itemListFragment = null;
    HomeFragment homeFragment = null;
    
    
    public void setHomeFragment(HomeFragment homeFragment) {
		this.homeFragment = homeFragment;
	}

	public HomeFragment getHomeFragment() {
		return homeFragment;
	}

	public Item getItemToShowDetail() {
		return itemToShowDetail;
	}

	public void setItemToShowDetail(Item itemToShowDetail) {
		this.itemToShowDetail = itemToShowDetail;
	}

	public ItemListFragment getItemListFragment() {
		return itemListFragment;
	}

	public void setItemListFragment(ItemListFragment itemListFragment) {
		this.itemListFragment = itemListFragment;
	}

	public PostItemFragment getPostItemFragment() {
		return postItemFragment;
	}

	public void setPostItemFragment(PostItemFragment postItemFragment) {
		this.postItemFragment = postItemFragment;
	}

	public ItemDetailFragment getItemDetailFragment() {
		return itemDetailFragment;
	}

	public void setItemDetailFragment(ItemDetailFragment itemDetailFragment) {
		this.itemDetailFragment = itemDetailFragment;
	}

	public User getZloop_user() {
		return zloop_user;
	}

	public void setCapturedImageUri(Uri capturedImageUri) {
		this.capturedImageUri = capturedImageUri;
	}

	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        
        Cache.setupCache(this);
        setContentView(R.layout.activity_main);
        zloop_user = ZloopDatabaseManager.getMe(this);
        if (this.zloop_user == null)
        {
          LoginFragment localLoginFragment = new LoginFragment();
          getSupportFragmentManager().beginTransaction().replace(R.id.mainframe, localLoginFragment).commit();
          return;
        }
        HomeFragment localHomeFragment = new HomeFragment();
        getSupportFragmentManager().beginTransaction().replace(R.id.mainframe, localHomeFragment).commit();
        
        // dummy call
//        new ZloopTask(this).execute(new ZloopLoginDummy(new LoginData("demo", "demo")));
//        new ZloopTask(this).execute(new ZloopGetItemDummy(0));
//        new ZloopTask(this).execute(new ZloopPostItemDummy(new Item(0, "DummyTitle", 10, 100, "DummyContent", "DummyPresentation", "DummySummary", "DummyTag", 0, 0, 0, 101, 0, 0, 0, 0, 0, null)));
//        
        // real call
//        new ZloopTask(this).execute(new ZloopLoginImpl(new LoginData("demo", "demo")));
//        new ZloopTask(this).execute(new ZloopGetItemListImpl());
//        new ZloopTask(this).execute(new ZloopGetItemListImpl());
    }

	@SuppressWarnings("unchecked")
	public void onSuccess(int id, final Object result) {
		if(id == LOGIN_JOB_ID && result instanceof User){	//Login success
			if(myProgressDialog != null){
				myProgressDialog.dismiss();
			}
			zloop_user = (User)result;
			HomeFragment localHomeFragment = new HomeFragment();
		    getSupportFragmentManager().beginTransaction().replace(R.id.mainframe, localHomeFragment).commit();
		    return;
		}
		
		if(id == SEARCH_JOB_ID && result instanceof List){	//Search success
			ItemListFragment lf = new ItemListFragment();
			lf.setItemist((List<Item>) result);
			FragmentTransaction txn = this.getSupportFragmentManager().beginTransaction();
			txn.replace(R.id.mainframe, lf);
			txn.addToBackStack(null);
			txn.commit();	
			
			return;
		}
		
		if(id == POST_ITEM_JOB_ID && result instanceof Item){	//Post success
			if(myProgressDialog != null){
				myProgressDialog.dismiss();
			}
			Toast.makeText(this, "Your item is posted.", Toast.LENGTH_LONG).show();
			this.getPostItemFragment().onPostDone(true);
			
			//Launch the View Pager
			ItemPagerFragment ipf = new ItemPagerFragment();
			ArrayList<Item> templist = new ArrayList<Item>();
			templist.add((Item)result);
			ipf.setItemList(templist);
			ipf.setInitialPosition(0);
			
			FragmentTransaction txn = this.getSupportFragmentManager().beginTransaction();
			txn.replace(R.id.mainframe, ipf);
			txn.addToBackStack(null);
			txn.commit();
			
			return;			
		}
		
		if(id == SELECT_CATEGORY_JOB_ID && result instanceof List){	//select category success
			ItemListFragment lf = new ItemListFragment();
			lf.setItemist((List<Item>) result);
			FragmentTransaction txn = this.getSupportFragmentManager().beginTransaction();
			txn.replace(R.id.mainframe, lf);
			txn.addToBackStack(null);
			txn.commit();	
			
			return;
		}
		
		if(id == POST_COMMENT_JOB_ID){	//post comment success
			Toast.makeText(this, "Your message is posted.", Toast.LENGTH_LONG).show();
			this.itemDetailFragment.onCommentDone();
		}
	}
	
	@Override
	public void onHttpAuthenticationFail(int id) {
		// TODO Auto-generated method stub
		super.onHttpAuthenticationFail(id);
		if(id == LOGIN_JOB_ID){	//login fail or search fail
			if(myProgressDialog != null){
				myProgressDialog.dismiss();
			}
            Toast.makeText(this, "Authentication failed.", Toast.LENGTH_LONG).show();
//            LoginFragment localLoginFragment = new LoginFragment();
//            getSupportFragmentManager().beginTransaction().replace(R.id.mainframe, localLoginFragment).commit();
            return;
		}
		
		if(id == POST_ITEM_JOB_ID){	//post item fail
			if(myProgressDialog != null){
				myProgressDialog.dismiss();
			}
			Toast.makeText(this, "Authetication error", Toast.LENGTH_LONG).show();
			this.getPostItemFragment().onPostDone(false);
			
		}
	}

	@Override
	public void onHttpNotFound(int id) {
		// TODO Auto-generated method stub
		super.onHttpNotFound(id);
	}

	public void onLogout() {
		// TODO Auto-generated method stub
		this.zloop_user = null;
	    LoginFragment localLoginFragment = new LoginFragment();
	    getSupportFragmentManager().beginTransaction().replace(R.id.mainframe, localLoginFragment).commit();
	}

	public void onLogin(String username, String password) {
		// TODO Auto-generated method stub
		//display the progress ring

		myProgressDialog = new ProgressDialog(this);
		myProgressDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
		myProgressDialog.setCancelable(true);
//		myDialog.setTitle("Posting your item ...");
		myProgressDialog.setMessage("Logging in ...");
		myProgressDialog.show();
		
		//Execute the login task
		//Dummy:
//		ZloopJob job = new ZloopLoginDummy(new LoginData(username, password));
//		job.setZloopJobId(LOGIN_JOB_ID);
//		final ZloopTask ztask = new ZloopTask(this);
//		ztask.execute(job);
		
		//Real:
		ZloopJob job = new ZloopLoginImpl(new LoginData(username, password));
		job.setZloopJobId(LOGIN_JOB_ID);
		final ZloopTask ztask = new ZloopTask(this);
		ztask.execute(job);
		
		
		myProgressDialog.setOnCancelListener(new OnCancelListener(){

			public void onCancel(DialogInterface arg0) {
				// TODO Auto-generated method stub
				ztask.cancel(true);
			}
			
		});
		
		
	}
	
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
	    if (requestCode == PostItemFragment.CAPTURE_IMAGE_ACTIVITY_REQUEST_CODE) {
	        if (resultCode == RESULT_OK) {
	        	this.postItemFragment.setImage(capturedImageUri);
	            // Image captured and saved to fileUri specified in the Intent
//	            Toast.makeText(this, "Image saved to:\n" +
//	                     data.getData(), Toast.LENGTH_LONG).show();
//	            ImageView thumbnail = (ImageView)findViewById(R.id.itemPostThumbnail);
//	            if(thumbnail != null){	//populate the thumbnail image view
//	            	thumbnail.setScaleType(ImageView.ScaleType.FIT_CENTER);
//	            	thumbnail.setImageURI(this.capturedImageUri);
//	            	//show and hide buttons
//	            	findViewById(R.id.ImageButton_post_takephoto).setVisibility(View.GONE);
//	            	findViewById(R.id.ImageButton_post_delete).setVisibility(View.VISIBLE);
//	            	      	
	            
//	            this.getFragmentManager().findFragmentById(id)
	            
	        } else if (resultCode == RESULT_CANCELED) {
	            // User cancelled the image capture
	        } else {
	            // Image capture failed, advise user
	        }
	    }

	}
	
	@Override
	public void onSaveInstanceState(Bundle savedInstanceState) {
	    // Save the user's current game state
//		savedInstanceState.putParcelable(EXTRA_USER, zloop_user);
		
	    // Always call the superclass so it can save the view hierarchy state
	    super.onSaveInstanceState(savedInstanceState);
	}

	public void onLoadImage(ImageView iv, ItemImg itemImg) {
		// TODO Auto-generated method stub
		String uri = itemImg.getUri();
		String localPath = itemImg.getLocalPath();
		String data = null;
		if (localPath != null)
			data = localPath;
		else
			data = uri;
		if (data != null) {
			iv.setTag(data.toString());
			Cache.loadImage(this, this, data, 0, iv);
		}
		
	}

	public ImageView findImageViewWithTag(Object o) {
		return  (ImageView) findViewById(R.id.mainframe).findViewWithTag(o);
	}

	public void onSearchKeyword(String key) {
		// TODO Auto-generated method stub
		//Dummy
//		ZloopSearchItemDummy job = new ZloopSearchItemDummy(key);
//		job.setZloopJobId(SEARCH_JOB_ID);
//		new ZloopTask(this).execute(job);
		
		//Real
		ZloopSearchItemImpl job = new ZloopSearchItemImpl(key);
		job.setZloopJobId(SEARCH_JOB_ID);
		new ZloopTask(this).execute(job);		
		
		
	}

	public void onPostItem(Item item) {
		// TODO Auto-generated method stub
		ZloopPostItemImpl job = new ZloopPostItemImpl(item);
		job.setZloopJobId(POST_ITEM_JOB_ID);
		final ZloopTask ztask = new ZloopTask(this);
		ztask.execute(job);
		
		//prepare the progress dialog
		myProgressDialog = new ProgressDialog(this);
		myProgressDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
		myProgressDialog.setCancelable(true);
//		myProgressDialog.setTitle("Posting your item ...");
		myProgressDialog.setMessage("Posting your item ...");
		myProgressDialog.show();
		myProgressDialog.setOnCancelListener(new OnCancelListener(){

			public void onCancel(DialogInterface dialog) {
				// TODO Auto-generated method stub
				ztask.cancel(true);
			}
			
		});
//		Thread.sleep(3000);
//		myProgressDialog.dismiss();
	}

	public void onCategorySelected(int categoryId) {
		// TODO Auto-generated method stub
		//Dummy
//		ZloopGetItemsByCategoryDummy job = new ZloopGetItemsByCategoryDummy(categoryId);
//		job.setZloopJobId(SELECT_CATEGORY_JOB_ID);
//		new ZloopTask(this).execute(job);
		
		//Real
		 ZloopGetItemsByCategoryImpl job = new  ZloopGetItemsByCategoryImpl(categoryId);
		job.setZloopJobId(SELECT_CATEGORY_JOB_ID);
		new ZloopTask(this).execute(job);
		
	}

	public void onPostComment(String comment, String itemUri) {
		// TODO Auto-generated method stub
		//Real
		ZloopPostCommentImpl job = new ZloopPostCommentImpl(new Comment(comment, itemUri));
		job.setZloopJobId(POST_COMMENT_JOB_ID);
		new ZloopTask(this).execute(job);
		
	}
	


}
