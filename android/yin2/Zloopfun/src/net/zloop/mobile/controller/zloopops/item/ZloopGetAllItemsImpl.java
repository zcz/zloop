package net.zloop.mobile.controller.zloopops.item;

import java.lang.ref.WeakReference;
import java.net.URI;
import java.util.ArrayList;
import java.util.Collection;
import java.util.List;

import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.client.HttpClientErrorException;
import org.springframework.web.client.RestTemplate;

import android.provider.SyncStateContract.Helpers;

import com.j256.ormlite.dao.RuntimeExceptionDao;

import net.zloop.mobile.controller.database.DataSourceCallback;
import net.zloop.mobile.controller.database.ZloopDatabaseManager;
import net.zloop.mobile.controller.zloopops.ZloopJob;
import net.zloop.mobile.controller.zloopops.ZloopTaskStatus;
import net.zloop.mobile.model.Item;
import net.zloop.mobile.model.ItemImg;
import net.zloop.mobile.model.User;

public class ZloopGetAllItemsImpl extends ZloopJob {

	private List<Item> mResult = null;
	private static final String itemUri = "/index.php/api/item/";
	
	public Object getResult() {
		return mResult;
	}

	public void doOnlineBackground(String baseUri,
			WeakReference<DataSourceCallback> datasourceRef) throws Exception {
		String fetchItemUrl = baseUri + itemUri;
		List<Item> items = new ArrayList<Item>();
		MediaType mediaType = MediaType.APPLICATION_JSON;
		HttpHeaders requestHeaders = new HttpHeaders();
		final DataSourceCallback datasource = datasourceRef.get();
		if (datasource != null) {
			String session = ZloopDatabaseManager
					.getCurrentSessionId(datasource);
			requestHeaders.add("Cookie", session);
		} else {
			setStatus(ZloopTaskStatus.NOT_FOUND);
			return;
		}

		RestTemplate restTemplate = new RestTemplate();

		ResponseEntity<Item[]> responseEntity = restTemplate.getForEntity(
				fetchItemUrl, Item[].class);
		Item[] itemarray = responseEntity.getBody();
		HttpHeaders header = responseEntity.getHeaders();
		for (int i = 0; i < itemarray.length; i++) {
			Item item = itemarray[i];
			item.setUri(itemUri + item.getId());
			ZloopDatabaseManager.updateItem(datasource, itemarray[i]);
			items.add(itemarray[i]);
		}
		mResult = items;
	}

	public void doOfflineBackground(
			WeakReference<DataSourceCallback> datasourceRef) {
		// TODO Auto-generated method stub
		DataSourceCallback datasource = datasourceRef.get();
		if (datasource != null) {
			List<Item> items = ZloopDatabaseManager.getAllItem(datasource);
			mResult = items;
		}
	}

}
