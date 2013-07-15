package net.zloop.mobile;

import java.util.ArrayList;
import java.util.Iterator;

import net.zloop.mobile.model.Category;
import net.zloop.mobile.model.Condition;
import net.zloop.mobile.model.Item;
import net.zloop.mobile.model.ItemImg;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.Toast;

public class PostItemFragment extends Fragment {
	public static final int CAPTURE_IMAGE_ACTIVITY_REQUEST_CODE = 10;
	private Uri fileUri = null;
	private PostItemCallback mPostItemCallback;
	private int stored_category_selection = 0;
	private int stored_condition_selection = 0;
	ProgressDialog myProgressDialog;
	
	
	
	public interface PostItemCallback{
		public void onPostItem(Item item);
	}

	class CameraButtonListener implements OnClickListener{

		public void onClick(View v) {
			// TODO Auto-generated method stub
			// create Intent to take a picture and return control to the calling application
		    Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);

		    fileUri = CameraHelper.getOutputMediaFileUri(CameraHelper.MEDIA_TYPE_IMAGE); // create a file to save the image
		    intent.putExtra(MediaStore.EXTRA_OUTPUT, fileUri); // set the image file name
		    ((MainActivity)getActivity()).setCapturedImageUri(fileUri);
//		    Toast.makeText(getActivity(), "URI created:" + fileUri
//                    , Toast.LENGTH_LONG).show();
//		    
		   
		    // start the image capture Intent
		    getActivity().startActivityForResult(intent, CAPTURE_IMAGE_ACTIVITY_REQUEST_CODE);
			
		}
		
	}
	
	class PostButtonListener implements OnClickListener{

		public void onClick(View v) {
			// TODO Auto-generated method stub
			Item item = new Item();
			try{
				//prepare the new Item
				item.setTitle(((EditText)getView().findViewById(R.id.textView_list_title)).getText().toString());
				if(item.getTitle().equals("")){
					throw new Exception("Item title cannot be empty");
				}
				item.setUserid(((MainActivity)getActivity()).getZloop_user().getId());
				item.setCategoryid(new Category().stringToId(((Spinner)getView().findViewById(R.id.Spinner_post_category)).getSelectedItem().toString()));
				item.setConditionid(new Condition().stringToId(((Spinner)getView().findViewById(R.id.spinner_post_condition)).getSelectedItem().toString()));
				item.setPricelow(Integer.valueOf(((EditText)getView().findViewById(R.id.editText_post_pricelow)).getText().toString()));
				item.setPricehigh(Integer.valueOf(((EditText)getView().findViewById(R.id.editText_post_pricehigh)).getText().toString()));
				item.setPresentation(((EditText)getView().findViewById(R.id.editText_post_itemDesc)).getText().toString());
				
				if(fileUri != null){
					ArrayList<ItemImg> pics = new ArrayList<ItemImg>();
					pics.add(new ItemImg(fileUri.toString(), item));
					item.setPics(pics);
				}
				
			}catch(Exception ex){
				Log.e(this.getClass().toString(), ex.toString());
	            Toast.makeText(getActivity(), "Incorrect input", Toast.LENGTH_LONG).show();
	            return;
			}
			
			//use the callback to post the item in a thread
			mPostItemCallback.onPostItem(item);
		}
		
	}
	
	class DeleteButtonListener implements OnClickListener{

		public void onClick(View arg0) {
			// TODO Auto-generated method stub
			removeImage();
		}
		
	}

	/* (non-Javadoc)
	 * @see android.support.v4.app.Fragment#onCreateView(android.view.LayoutInflater, android.view.ViewGroup, android.os.Bundle)
	 */
	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		View v = inflater.inflate(R.layout.post_item, container, false);
		
		return v;
	}

	@Override
	public void onStart() {
		// TODO Auto-generated method stub
		super.onStart();
		//restore spinners
		((Spinner)getView().findViewById(R.id.Spinner_post_category)).setSelection(stored_category_selection);
		((Spinner)getView().findViewById(R.id.spinner_post_condition)).setSelection(stored_condition_selection);
			
		//set button listener
		((ImageButton)getView().findViewById(R.id.ImageButton_post_takephoto)).setOnClickListener(new CameraButtonListener());
		((ImageButton)getView().findViewById(R.id.ImageButton_post_delete)).setOnClickListener(new DeleteButtonListener());
		((Button)getView().findViewById(R.id.button_post)).setOnClickListener(new PostButtonListener());
		
		//dynamically create spinner array for condition
		ArrayList<String> spinnerArray_condition = new ArrayList<String>();
		Condition condition = new Condition();
		Iterator<Integer> it = condition.getSelectable().iterator();
		while(it.hasNext()){
			spinnerArray_condition.add(condition.idToString(it.next()));
		}
		ArrayAdapter<String> spinnerArrayAdapter_condition = new ArrayAdapter<String>(getActivity(),
		        android.R.layout.simple_spinner_dropdown_item, spinnerArray_condition);
		
		//set spinner adapter
		((Spinner)getView().findViewById(R.id.spinner_post_condition)).setAdapter(spinnerArrayAdapter_condition);
		
		//dynamically create spinner array
		ArrayList<String> spinnerArray_category = new ArrayList<String>();
		Category category = new Category();
		Iterator<Integer> it2 = category.getSelectable().iterator();
		while(it2.hasNext()){
			spinnerArray_category.add(category.idToString(it2.next()));
		}
		ArrayAdapter<String> spinnerArrayAdapter_category = new ArrayAdapter<String>(getActivity(),
		        android.R.layout.simple_spinner_dropdown_item, spinnerArray_category);
		
		//set spinner adapter
		((Spinner)getView().findViewById(R.id.Spinner_post_category)).setAdapter(spinnerArrayAdapter_category);
		
	}
	
	

	@Override
	public void onAttach(Activity activity) {
		// TODO Auto-generated method stub
		super.onAttach(activity);
		((MainActivity)activity).setPostItemFragment(this);
		
		try {
			this.mPostItemCallback = (PostItemCallback) activity;
        } catch (ClassCastException e) {
            throw new ClassCastException(activity.toString()
                    + " must implement PostItemCallback");
        }
	}
	
	public boolean setImage(Uri uri){
		ImageView thumbnail = (ImageView)getView().findViewById(R.id.imageView_list_thumbnail);
        if(thumbnail != null){	//populate the thumbnail image view
        	thumbnail.setScaleType(ImageView.ScaleType.FIT_CENTER);
        	thumbnail.setImageURI(uri);
        	//show and hide buttons
        	getView().findViewById(R.id.ImageButton_post_takephoto).setVisibility(View.GONE);
        	getView().findViewById(R.id.ImageButton_post_delete).setVisibility(View.VISIBLE);
        	return true;
        }
        else
        	return false;
	}
	
	public boolean removeImage(){
		ImageView thumbnail = (ImageView)getView().findViewById(R.id.imageView_list_thumbnail);
        if(thumbnail != null){	//populate the thumbnail image view
        	thumbnail.setImageURI(null);
        	//show and hide buttons
        	getView().findViewById(R.id.ImageButton_post_takephoto).setVisibility(View.VISIBLE);
        	getView().findViewById(R.id.ImageButton_post_delete).setVisibility(View.GONE);
        	fileUri = null;
        	return true;
        }
        else
        	return false;
	}
	
	public void onPostDone(boolean result){
		//clear the inputs if successful
		if(result){
			((EditText)getView().findViewById(R.id.textView_list_title)).setText("");
			((EditText)getView().findViewById(R.id.editText_post_pricelow)).setText("");
			((EditText)getView().findViewById(R.id.editText_post_pricehigh)).setText("");
			((EditText)getView().findViewById(R.id.editText_post_pricelow)).setText("");
			((EditText)getView().findViewById(R.id.editText_post_itemDesc)).setText("");
			removeImage();
		}
	}

	@Override
	public void onPause() {
		// TODO Auto-generated method stub
		super.onPause();
		this.stored_category_selection = ((Spinner)getView().findViewById(R.id.Spinner_post_category)).getSelectedItemPosition();
		this.stored_condition_selection = ((Spinner)getView().findViewById(R.id.spinner_post_condition)).getSelectedItemPosition();
	}
	
	

}
