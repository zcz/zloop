package net.zloop.mobile.controller.zloopops.item;

import java.io.File;
import java.lang.ref.WeakReference;
import java.net.URI;

import net.zloop.mobile.controller.database.DataSourceCallback;
import net.zloop.mobile.controller.database.ZloopDatabaseManager;
import net.zloop.mobile.controller.zloopops.ZloopJob;
import net.zloop.mobile.controller.zloopops.ZloopTaskStatus;
import net.zloop.mobile.controller.zloopops.login.ZloopAuthUtil;

import org.springframework.core.io.FileSystemResource;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.util.LinkedMultiValueMap;
import org.springframework.util.MultiValueMap;
import org.springframework.web.client.HttpClientErrorException;
import org.springframework.web.client.RestTemplate;

import android.net.Uri;
import android.os.Environment;

public class ZloopPostItemImgImpl  {
	String path = null;
	String mResult = null;
	public ZloopPostItemImgImpl(String path) {
		super();
		this.path = path;
	}

	public Object getResult() {
		// TODO Auto-generated method stub
		return mResult;
	}

	public static String doOnlineBackground(String baseUri, String path,
			WeakReference<DataSourceCallback> datasourceRef)
			throws HttpClientErrorException, Exception {
		final DataSourceCallback datasource = datasourceRef.get();
		if (datasource != null && path != null) {
			File file =new File(Uri.parse(path).getPath());
			if (file.exists()) {
				final String postItemImgUrl = baseUri + "/index.php/api/pic";
				MediaType mediaType = MediaType.APPLICATION_JSON;
				HttpHeaders postHeaders = new HttpHeaders();
				postHeaders.setContentType(mediaType);
				String session = ZloopDatabaseManager
						.getCurrentSessionId(datasource);
				ZloopAuthUtil.checkSession(baseUri, session);
				RestTemplate restTemplate = new RestTemplate();
				MultiValueMap<String, Object> form = new LinkedMultiValueMap<String, Object>();
				form.add("pic", new FileSystemResource(file));
				URI uri = restTemplate.postForLocation(postItemImgUrl, form, postHeaders);
				return uri.toASCIIString();
			}
		}
		return "";
	}

	public void doOfflineBackground(WeakReference<DataSourceCallback> datasource) {
		// TODO Auto-generated method stub

	}
}
