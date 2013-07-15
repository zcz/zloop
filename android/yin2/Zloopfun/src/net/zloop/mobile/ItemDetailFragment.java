package net.zloop.mobile;

import java.util.List;

import net.zloop.mobile.ItemListFragment.LoadImageCallback;
import net.zloop.mobile.model.Category;
import net.zloop.mobile.model.Condition;
import net.zloop.mobile.model.Item;
import net.zloop.mobile.model.ItemImg;
import android.app.Activity;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.EditText;


public class ItemDetailFragment extends Fragment {
	Item item;
	private LoadImageCallback loadImageCallback;
	private PostCommentCallback mPostCommentCallback;
	
	public interface PostCommentCallback{
		public void onPostComment(String comment, String itemUri);
	}
	
	class CommentButtonListener implements OnClickListener{

		public void onClick(View v) {
			// TODO Auto-generated method stub
			String comment = ((EditText)getView().findViewById(R.id.editText_detail_comment)).getText().toString();
			mPostCommentCallback.onPostComment(comment, item.getUri());
		}
		
	}
	
	public Item getItem() {
		return item;
	}

	public void setItem(Item item) {
		this.item = item;
	}


	public ItemDetailFragment() {
		super();
		// TODO Auto-generated constructor stub
	}

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		return inflater.inflate(R.layout.item_detail, container, false);
	}
	
	@Override
	public void onAttach(Activity activity) {
		// TODO Auto-generated method stub
		super.onAttach(activity);
		((MainActivity)activity).setItemDetailFragment(this);
		
		try {
			loadImageCallback = (LoadImageCallback)activity;
			mPostCommentCallback = (PostCommentCallback)activity ;
        } catch (ClassCastException e) {
            throw new ClassCastException(activity.toString()
                    + " must implement LoadImageCallback and PostCommentCallback");
        }
	}

	@Override
	public void onActivityCreated(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onActivityCreated(savedInstanceState);
		
		((Button)getView().findViewById(R.id.button_detail_send)).setOnClickListener(new CommentButtonListener());
		
//		//Dummy: create an item
//		Item item1 = new Item();
//	    item1.setTitle("Introduction to algorithm and data structure");
//	    item1.setConditionid(102);
//	    item1.setCategoryid(1);
//	    item1.setPricelow(100);
//	    item1.setPricehigh(200);
//	    item = item1;
//		
		
		
		if(this.item != null){
			//retrieve the attributes
			String title = item.getTitle();
			String category = new Category().idToString(item.getCategoryid());
			String condition = new Condition().idToString(item.getConditionid());
			String price = item.getPricelow() + " to " + item.getPricehigh() + " HKD";
			String description = item.getContent();
			
			
			//fill in the content view
			((TextView)getView().findViewById(R.id.textView_detail_title)).setText(title);
			((TextView)getView().findViewById(R.id.textView_detail_category)).setText(category);
			((TextView)getView().findViewById(R.id.textView_detail_condition)).setText(condition);
			((TextView)getView().findViewById(R.id.textView_detail_price)).setText(price);
			((TextView)getView().findViewById(R.id.textView_detail_description)).setText(description);
			//load the picture here
			ItemImg imageUri = null;
			ImageView iv = (ImageView)getView().findViewById(R.id.imageView_detail_image);
			try{
				imageUri = ((List<ItemImg>)item.getPics()).get(0);
			}catch(Exception ignore){
				
			}
			if(imageUri != null){
				this.loadImageCallback.onLoadImage(iv, imageUri);
			}
			else{
				iv.setVisibility(View.GONE);
			}
		}
	}
	
	public void onCommentDone(){
		EditText et = (EditText)getView().findViewById(R.id.editText_detail_comment);
		if(et != null){
			et.setText("");
		}
	}
}
