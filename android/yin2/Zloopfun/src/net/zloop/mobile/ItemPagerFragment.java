package net.zloop.mobile;

import java.util.List;

import net.zloop.mobile.model.Item;

import android.app.Activity;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentStatePagerAdapter;
import android.support.v4.view.ViewPager;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

public class ItemPagerFragment extends Fragment {
    // When requested, this adapter returns a DemoObjectFragment,
    // representing an object in the collection.
    ItemListPagerAdapter adapter;
    ViewPager mViewPager;
    List<Item> itemList = null;
	int initialPosition = 0;
    
    public List<Item> getItemList() {
		return itemList;
	}

	public void setItemList(List<Item> itemList) {
		this.itemList = itemList;
	}

	public int getInitialPosition() {
		return initialPosition;
	}

	public void setInitialPosition(int initialPosition) {
		this.initialPosition = initialPosition;
	}


    @Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
    	View v = inflater.inflate(R.layout.item_detail_pager, container, false);	
		return v;

	}


	@Override
	public void onActivityCreated(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onActivityCreated(savedInstanceState);
		adapter = new ItemListPagerAdapter(this.getChildFragmentManager(), this.getItemList());
        mViewPager = (ViewPager)getView().findViewById(R.id.pager_item);
        mViewPager.setAdapter(adapter);
        mViewPager.setCurrentItem(initialPosition);
        
	}



	@Override
	public void onAttach(Activity activity) {
		// TODO Auto-generated method stub
		super.onAttach(activity);
	}

}
// Since this is an object collection, use a FragmentStatePagerAdapter,
// and NOT a FragmentPagerAdapter.
class ItemListPagerAdapter extends FragmentStatePagerAdapter {
	List<Item> itemList = null;
	
    public ItemListPagerAdapter(FragmentManager fm, List<Item> list) {
        super(fm);
        this.itemList = list;
    }

    @Override
    public Fragment getItem(int i) {
        ItemDetailFragment fragment = new ItemDetailFragment();
        fragment.setItem(this.itemList.get(i));
        return fragment;
    }

    @Override
    public int getCount() {
        return this.itemList.size();
    }

}