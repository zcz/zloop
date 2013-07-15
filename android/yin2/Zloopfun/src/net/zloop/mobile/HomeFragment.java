package net.zloop.mobile;

import android.app.Activity;
import android.graphics.Color;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentTabHost;
import android.support.v4.view.MenuItemCompat;
import android.support.v4.widget.SearchViewCompat;
import android.support.v4.widget.SearchViewCompat.OnCloseListenerCompat;
import android.support.v4.widget.SearchViewCompat.OnQueryTextListenerCompat;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.MenuItem.OnMenuItemClickListener;
import android.view.View;
import android.view.View.OnFocusChangeListener;
import android.view.ViewGroup;
import android.widget.Toast;

public class HomeFragment extends Fragment {
	private FragmentTabHost mTabHost;
	LogoutCallback mCallback;
	SearchCallback mSearchCallback;
	
	public FragmentTabHost getmTabHost() {
		return mTabHost;
	}

	public void setmTabHost(FragmentTabHost mTabHost) {
		this.mTabHost = mTabHost;
	}
	
	public interface LogoutCallback{
		public void onLogout();		
	}
	
	public interface SearchCallback{
		public void onSearchKeyword(String key);
	}
	
	class LogoutClickedListener implements OnMenuItemClickListener{

		public boolean onMenuItemClick(MenuItem item) {
			// TODO Auto-generated method stub
			mCallback.onLogout();
			return false;
		}
		
	}

	@Override
	public void onActivityCreated(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onActivityCreated(savedInstanceState);
		setHasOptionsMenu(true);
	}

	@Override
	public void onAttach(Activity activity) {
		// TODO Auto-generated method stub
		super.onAttach(activity);
		((MainActivity)activity).setHomeFragment(this);
		
		try {
            mCallback = (LogoutCallback) activity;
            mSearchCallback = (SearchCallback)activity;
        } catch (ClassCastException e) {
            throw new ClassCastException(activity.toString()
                    + " must implement LogoutCallback and SearchCallback");
        }
		
	}

	@Override
	public void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
	}

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		//View v = inflater.inflate(R.layout.home, container, false);
//		mTabHost = (MyFragmentTabHost) getActivity().findViewById(android.R.id.tabhost);
//		mTabHost.setup(getActivity(), getChildFragmentManager(), R.id.realtabcontent);
		
		mTabHost = new FragmentTabHost(getActivity());
        mTabHost.setup(getActivity(), getChildFragmentManager(), R.id.realtabcontent);
		
        mTabHost.addTab(mTabHost.newTabSpec("category").setIndicator(null, getResources().getDrawable(android.R.drawable.ic_menu_mapmode)),
                CategoryFragment.class, null);      
        mTabHost.addTab(mTabHost.newTabSpec("post").setIndicator(null, getResources().getDrawable(android.R.drawable.ic_menu_upload)),
                PostItemFragment.class, null);
//        mTabHost.addTab(mTabHost.newTabSpec("detail").setIndicator(null, getResources().getDrawable(android.R.drawable.ic_menu_view)),
//                ItemDetailFragment.class, null);
//        mTabHost.addTab(mTabHost.newTabSpec("list").setIndicator(null, getResources().getDrawable(R.drawable.logo)),
//                ItemListFragment.class, null);


		return mTabHost;
	}

	@Override public void onCreateOptionsMenu(Menu menu, MenuInflater inflater) {
		/*********Search menu item****************/

	    // Place an action bar item for searching.
	    MenuItem item = menu.add("Search");
	    item.setIcon(android.R.drawable.ic_menu_search);
	    MenuItemCompat.setShowAsAction(item, MenuItemCompat.SHOW_AS_ACTION_IF_ROOM
	            | MenuItemCompat.SHOW_AS_ACTION_COLLAPSE_ACTION_VIEW);
	    final View searchView = SearchViewCompat.newSearchView(getActivity());
	    searchView.setBackgroundColor(Color.WHITE);
	    
	    SearchViewCompat.setQueryHint(searchView, "Search an item ...");
	    searchView.setOnFocusChangeListener(new OnFocusChangeListener(){

			public void onFocusChange(View arg0, boolean arg1) {
				// TODO Auto-generated method stub
				if(!arg1){
					arg0.setVisibility(View.INVISIBLE);
				}
			}
	    	
	    });
	    
	    if (searchView != null) {
	        SearchViewCompat.setOnQueryTextListener(searchView,
	                new OnQueryTextListenerCompat() {
	            
	            @Override
	            public boolean onQueryTextSubmit(String query){
	            	//process the query
	            	 Toast.makeText(getActivity(), "Searching for \""+ query + "\"" , Toast.LENGTH_LONG).show();
	            	
	            	 //revert the search box to empty
	            	 SearchViewCompat.setQuery(searchView, null, false);	            	 
	            	 mSearchCallback.onSearchKeyword(query);	            	 
	            	 return true;
	            }
	        });
	        SearchViewCompat.setOnCloseListener(searchView,
	                new OnCloseListenerCompat() {
	                    @Override
	                    public boolean onClose() {
	                    	SearchViewCompat.setQuery(searchView, null, false);
	                        return true;
	                    }
	            
	        });
	        MenuItemCompat.setActionView(item, searchView);
	    }
	    
	    /************Logout menu item****************/
		MenuItem logout_item = menu.add("Logout");
		logout_item.setIcon(android.R.drawable.ic_menu_close_clear_cancel);
		MenuItemCompat.setShowAsAction(logout_item, MenuItemCompat.SHOW_AS_ACTION_IF_ROOM
	            | MenuItemCompat.SHOW_AS_ACTION_COLLAPSE_ACTION_VIEW);
		logout_item.setOnMenuItemClickListener(new LogoutClickedListener());
		
	}

}
