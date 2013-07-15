/*package net.zloop.mobile.controller.zloopops;

import java.util.ArrayList;
import java.util.Collection;
import java.util.List;

import net.zloop.mobile.R;
import net.zloop.mobile.R.id;
import net.zloop.mobile.R.layout;
import net.zloop.mobile.R.string;
import net.zloop.mobile.controller.database.ConnectionUtil;
import net.zloop.mobile.controller.database.DataSourceCallback;
import net.zloop.mobile.model.Item;
import net.zloop.mobile.model.ItemImg;
import net.zloop.mobile.model.User;

import org.codehaus.jackson.map.ser.StdSerializers.UtilDateSerializer;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.client.HttpClientErrorException;
import org.springframework.web.client.RestTemplate;

import android.app.Activity;
import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.GridView;
import android.widget.TextView;

import com.j256.ormlite.dao.RuntimeExceptionDao;

//haha

public class ItemGridFragment extends Fragment{
	DataSourceCallback dataSourceController;
	String[] hihi = {"adf","asdfas"};
	GridView categoryGridView;
	public void onAttach(Activity activity) {
		super.onAttach(activity);
		dataSourceController = (DataSourceCallback) activity;
	}
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
	}
	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		View view = inflater.inflate(R.layout.category_grid, container, false);
		return view;
	}
	@Override
	public void onViewCreated(View view, Bundle savedInstanceState) {
		super.onViewCreated(view, savedInstanceState);
		categoryGridView = (GridView) view.findViewById(R.id.category_grid_view);
	}
	@Override
	public void onActivityCreated(Bundle savedInstanceState) {
		super.onActivityCreated(savedInstanceState);
		new FetchItemTask().execute();
	}
	public void onItemsLoaded (ArrayList<Item> items) {
		
		categoryGridView.setAdapter(new ItemGridAdaptor());
	}
	public class ItemGridAdaptor extends BaseAdapter {
		
		
		public int getCount() {
			// TODO Auto-generated method stub
			return 2;
		}

		public Object getItem(int position) {
			return hihi[position];
		}

		public long getItemId(int position) {
			return position;
		}

		public View getView(int position, View convertView, ViewGroup parent) {
			TextView tv = new TextView(getActivity());
			tv.setText(hihi[position]);
			return tv;
		}
	}
	public class FetchItemTask extends AsyncTask<Void, Void, ArrayList<Item>> {

		final String fetchItemUrl = getString(R.string.base_uri)
				+ "/index.php/api/item";

		@Override
		protected ArrayList<Item> doInBackground(Void... params) {
			ArrayList<Item> items = new ArrayList<Item>();
			if (! ConnectionUtil.isConnected(getActivity())) {
				return items;
			}
			MediaType mediaType = MediaType.APPLICATION_JSON;
			HttpHeaders requestHeaders = new HttpHeaders();
//			RuntimeExceptionDao<User, Integer> simpleDao = dataSourceController.getUserDataSource();
//			List<User> user = simpleDao.queryForAll();
//			if (user.size() > 0)
//				requestHeaders.add("Cookie", user.get(0).getSession());
			try {
//				RuntimeExceptionDao<Item, Integer> itemDao = dataSourceController.getItemDataSource();
//				List<Item> abc = itemDao.queryForAll();
				RestTemplate restTemplate = new RestTemplate();
				ResponseEntity<Item[]> responseEntity = restTemplate.getForEntity(fetchItemUrl, Item[].class);
				Item[] itemarray = responseEntity.getBody();
				HttpHeaders header = responseEntity.getHeaders();
				
				for (int i = 0; i < itemarray.length; i++) {
					Item item = itemarray[i];
					Collection<ItemImg> imgs = item.getPics();
					for (ItemImg itemImg : imgs) {
						itemImg.setItem(item);
					}
					items.add(itemarray[i]);
//					itemDao.create(itemarray[i]);
				}
				return items;
				
				
			} catch (HttpClientErrorException e) {
				return null;
				// }
			} catch (Exception e) {
				e.printStackTrace();
				int i = 0;
				i++;
			}
			return null;
		}

		@Override
		protected void onPostExecute(ArrayList<Item> items) {

			onItemsLoaded(items);
		}

	}
}
*/