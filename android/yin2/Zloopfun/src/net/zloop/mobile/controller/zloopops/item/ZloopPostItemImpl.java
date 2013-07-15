package net.zloop.mobile.controller.zloopops.item;

import java.lang.ref.WeakReference;
import java.net.URI;
import java.util.Collection;
import java.util.Iterator;
import java.util.List;

import net.zloop.mobile.controller.database.DataSourceCallback;
import net.zloop.mobile.controller.database.ZloopDatabaseManager;
import net.zloop.mobile.controller.zloopops.ZloopJob;
import net.zloop.mobile.controller.zloopops.ZloopTaskStatus;
import net.zloop.mobile.controller.zloopops.login.ZloopAuthUtil;
import net.zloop.mobile.controller.zloopops.login.ZloopLoginImpl;
import net.zloop.mobile.model.Item;
import net.zloop.mobile.model.ItemImg;

import org.springframework.http.HttpEntity;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.web.client.HttpClientErrorException;
import org.springframework.web.client.RestTemplate;

public class ZloopPostItemImpl extends ZloopJob {
	Item mItem = null;
	Item mResult = null;

	public Object getResult() {
		// TODO Auto-generated method stub
		return mResult;
	}

	public ZloopPostItemImpl(Item mItem) {
		super();
		this.mItem = mItem;
	}

	public void doOnlineBackground(String baseUri,
			WeakReference<DataSourceCallback> datasourceRef)
			throws HttpClientErrorException, Exception {
		final DataSourceCallback datasource = datasourceRef.get();
		if (datasource != null) {
			String session = ZloopDatabaseManager
					.getCurrentSessionId(datasource);
//			ZloopAuthUtil.checkSession(baseUri, session);
			Collection<ItemImg> pics = mItem.getPics();
			if (pics != null) {
				for (Iterator iterator = pics.iterator(); iterator.hasNext();) {
					ItemImg itemImg = (ItemImg) iterator.next();
					String uri = ZloopPostItemImgImpl.doOnlineBackground(baseUri,
							itemImg.getLocalPath(), datasourceRef);
					itemImg.setUri(uri);
					itemImg.setItem(null);
				}
			}

			final String postItemUrl = baseUri + "/index.php/api/item";
			MediaType mediaType = MediaType.APPLICATION_JSON;
			HttpHeaders postHeaders = new HttpHeaders();
			postHeaders.setContentType(mediaType);
			postHeaders.add("Cookie", session);
			RestTemplate restTemplate = new RestTemplate();
			HttpEntity<Item> requestEntity = new HttpEntity<Item>(mItem,
					postHeaders);
			URI uri = restTemplate.postForLocation(postItemUrl, requestEntity);
			String mUri = uri.toASCIIString();
			mItem.setUri(mUri);
			ZloopDatabaseManager.createNewItem(datasource, mItem);
			mResult = mItem;
		}

	}

	public void doOfflineBackground(WeakReference<DataSourceCallback> datasource) {

	}

}
