package net.zloop.mobile;

import java.util.ArrayList;
import java.util.List;

import net.zloop.mobile.model.Category;
import net.zloop.mobile.model.Condition;
import net.zloop.mobile.model.Item;
import net.zloop.mobile.model.ItemImg;
import android.app.Activity;
import android.content.Context;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.FragmentTransaction;
import android.support.v4.app.ListFragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

public class ItemListFragment extends ListFragment {
	ItemArrayAdapter adapter = null;
	LoadImageCallback loadImageCallback;
	List<Item> itemist = null;
	
	public List<Item> getItemist() {
		return itemist;
	}

	public void setItemist(List<Item> itemist) {
		this.itemist = itemist;
	}

	public LoadImageCallback getLoadImageCallback() {
		return loadImageCallback;
	}

	public interface LoadImageCallback{
		public void onLoadImage(ImageView iv, ItemImg itemImg);
	}
	
//	public void setNewItemList(List<Item> list){
//		adapter.clear();
//		adapter.addAll(list);
//	}
	
	@Override
	public void onAttach(Activity activity) {
		// TODO Auto-generated method stub
		super.onAttach(activity);
		((MainActivity)activity).setItemListFragment(this);
		
		try {
			loadImageCallback = (LoadImageCallback) activity;
        } catch (ClassCastException e) {
            throw new ClassCastException(activity.toString()
                    + " must implement LoadImageCallback");
        }
	}
	
	@Override
	  public void onActivityCreated(Bundle savedInstanceState) {
	    super.onActivityCreated(savedInstanceState);
	    
	    if(adapter == null){
		    
		    setEmptyText("No items selected.");
		    
		    adapter = new ItemArrayAdapter(getActivity(), this, new ArrayList<Item>());
		    setListAdapter(adapter);
		    
		    
		    //create two dummy items
//		    Item item1 = new Item();
//		    item1.setTitle("Introduction to algorithm and data structure");
//		    item1.setConditionid(102);
//		    item1.setCategoryid(1);
//		    item1.setPricelow(100);
//		    item1.setPricehigh(200);
//		    
//		    Item item2 = new Item();
//		    item2.setTitle("Harry Potter and Barack Obama");
//		    item2.setConditionid(101);
//		    item2.setCategoryid(2);
//		    item2.setPricelow(99);
//		    item2.setPricehigh(123);
//		    item2.setPresentation("I've got a custom dialog layout that has two EditText fields and I've initially set the visibility to GONE for both (in the layout XML).");
//		    ArrayList<ItemImg> pics = new ArrayList<ItemImg>();
//		    pics.add(new ItemImg("http://people.cs.vt.edu/~shaffer/Book/C++.jpg"));
//		    item2.setPics(pics);
//		    
//		    ArrayList<Item> templist = new ArrayList<Item>();
//		    templist.add(item1);
//		    templist.add(item2);
//		    this.setNewItemList(templist);
	    }
	    if(this.getItemist() != null){
	    	adapter.clear();
	    	adapter.addAll(this.getItemist());
	    }
	  }

	  @Override
	public void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		
	}

	@Override
	  public void onListItemClick(ListView l, View v, int position, long id) {
	    // Display the item detail
//		  Item item = adapter.getItem(position);
//		  ItemDetailFragment detailFragment = new ItemDetailFragment();
//		  detailFragment.setItem(item);
//		  
//		  FragmentTransaction txn = getActivity().getSupportFragmentManager().beginTransaction();
//		  txn.replace(R.id.mainframe, detailFragment);
//		  txn.addToBackStack(null);
//		  txn.commit();

		//Launch the View Pager
		ItemPagerFragment ipf = new ItemPagerFragment();
		ipf.setItemList(this.getItemist());
		ipf.setInitialPosition(position);
		
		FragmentTransaction txn = getActivity().getSupportFragmentManager().beginTransaction();
		txn.replace(R.id.mainframe, ipf);
		txn.addToBackStack(null);
		txn.commit();
	

	  }

}

class ItemArrayAdapter extends ArrayAdapter<Item> {
	  private final Activity context;
	  private List<Item> items;
	  private ItemListFragment listFragment;

	  public ItemArrayAdapter(Activity context, ItemListFragment listFragment, List<Item> items) {
	    super(context, R.layout.item_entry, items);
	    this.context = context;
	    this.items = items;
	    this.listFragment = listFragment;
	  }

	  @Override
	  public View getView(int position, View convertView, ViewGroup parent) {
		 //inflate list entry layout
	    LayoutInflater inflater = (LayoutInflater) context
	        .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
	    
	    //retrieve attribute values
	    View rowView = inflater.inflate(R.layout.item_entry, parent, false);
	    String title = items.get(position).getTitle();
	    String category = new Category().idToString(items.get(position).getCategoryid());
	    String condition = new Condition().idToString(items.get(position).getConditionid());
	    String price = items.get(position).getPricelow() + " to " + items.get(position).getPricehigh() + " HKD";
	    
	    //fill values into views
	    ((TextView)rowView.findViewById(R.id.textView_list_title)).setText(title);
	    ((TextView)rowView.findViewById(R.id.textView_list_category)).setText(category);
	    ((TextView)rowView.findViewById(R.id.textView_list_condition)).setText(condition);
	    ((TextView)rowView.findViewById(R.id.textView_list_price)).setText(price);
	    
	    //load the thumbnail here
	    try{
	    	ImageView iv = (ImageView)rowView.findViewById(R.id.imageView_list_thumbnail);
		    ItemImg img = ((List<ItemImg>)items.get(position).getPics()).get(0);
		    if(img != null){
		    	this.listFragment.getLoadImageCallback().onLoadImage(iv, img);
		    }
		    else{
		    	iv.setVisibility(View.GONE);
		    }
	    }catch(Exception ignore){}

	    return rowView;
	  }
} 