package net.zloop.mobile;

import java.util.List;

import net.zloop.mobile.model.Category;
import android.app.Activity;
import android.content.Context;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ArrayAdapter;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.ImageView.ScaleType;
import android.widget.TextView;

public class CategoryFragment extends Fragment {
	private ItemIconArrayAdapter adapter = null;
	private CategoryCallback mCategoryCallback;
	
	public interface CategoryCallback{
		public void onCategorySelected(int categoryId);
	}

	@Override
	public void onActivityCreated(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onActivityCreated(savedInstanceState);
		
		
	}

	
	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		
		View view = inflater.inflate(R.layout.category,container,false);
        GridView gridView = (GridView) view.findViewById(R.id.gridview_category);
        adapter = new ItemIconArrayAdapter(view.getContext(), RenderableCategory.getList());
        gridView.setAdapter(adapter); // uses the view to get the context instead of getActivity().
        
   
        gridView.setOnItemClickListener(new OnItemClickListener() {
            public void onItemClick(AdapterView<?> parent, View v, int position, long id) {
//                Toast.makeText(HelloGridView.this, "" + position, Toast.LENGTH_SHORT).show();
            	mCategoryCallback.onCategorySelected(RenderableCategory.getList().get(position).getCategoryId());
            	
            }
        });
        
        return view;
	}


	@Override
	public void onAttach(Activity activity) {
		// TODO Auto-generated method stub
		super.onAttach(activity);
		
		try {
			mCategoryCallback = (CategoryCallback) activity;
        } catch (ClassCastException e) {
            throw new ClassCastException(activity.toString()
                    + " must implement CategoryCallback");
        }
	}

}


class ItemIconArrayAdapter extends ArrayAdapter<CategoryIconEntry> {
	  private final Context context;
	  private List<CategoryIconEntry> entries;

	  public ItemIconArrayAdapter(Context context, List<CategoryIconEntry> entries) {
	    super(context, R.layout.category_grid_entry, entries);
	    this.context = context;
	    this.entries = entries;
	  }

	  @Override
	  public View getView(int position, View convertView, ViewGroup parent) {
		 //inflate list entry layout
	    LayoutInflater inflater = (LayoutInflater) context
	        .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
	    
	    //retrieve attribute values and fill in the content view
	    View rowView = inflater.inflate(R.layout.category_grid_entry, parent, false);
	    CategoryIconEntry entry = entries.get(position);
	    ImageView iv =(ImageView)rowView.findViewById(R.id.imageView_category_grid_icon);
	    iv.setScaleType(ScaleType.FIT_CENTER);
	    iv.setImageDrawable(context.getResources().getDrawable(entry.getIconResourceId()));
	    TextView tv = (TextView)rowView.findViewById(R.id.textView_category_grid_text);
	    tv.setText(new Category().idToString(entry.getCategoryId()));

	    return rowView;
	  }
} 

