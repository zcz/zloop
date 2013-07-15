package net.zloop.mobile.controller.zloopops.item;

import java.lang.ref.WeakReference;
import java.util.ArrayList;
import java.util.Collection;
import java.util.List;

import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.client.HttpClientErrorException;
import org.springframework.web.client.RestTemplate;

import com.j256.ormlite.dao.RuntimeExceptionDao;

import net.zloop.mobile.controller.database.DataSourceCallback;
import net.zloop.mobile.controller.database.ZloopDatabaseManager;
import net.zloop.mobile.controller.zloopops.ZloopJob;
import net.zloop.mobile.controller.zloopops.ZloopTaskStatus;
import net.zloop.mobile.model.Item;
import net.zloop.mobile.model.ItemImg;

public class ZloopSearchItemImpl extends ZloopJob {

	private List<Item> mResult = null;
	private String keyword = "";

	public ZloopSearchItemImpl(String keyword) {
		super();
		this.keyword = keyword;
	}

	public Object getResult() {
		return mResult;
	}

	public void doOnlineBackground(String baseUri,
			WeakReference<DataSourceCallback> datasourceRef) throws Exception {
		String fetchItemUrl = baseUri + "/index.php/api/item?keyString={keyword}";
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
				fetchItemUrl, Item[].class, keyword);
		Item[] items = responseEntity.getBody();
		mResult = new ArrayList<Item>();
		for (int i = 0; i < items.length; i++) {
			Item item = items[i];
			ZloopDatabaseManager.updateItem(datasource, item);
			mResult.add(item);
		}
	}

	public void doOfflineBackground(
			WeakReference<DataSourceCallback> datasourceRef) {
		// TODO Auto-generated method stub
		DataSourceCallback datasource = datasourceRef.get();
		if (datasource != null) {
			
		}
	}
}
