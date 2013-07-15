package net.zloop.mobile.controller.zloopops.login;

import java.lang.ref.WeakReference;
import java.net.URI;
import java.util.List;
import java.util.StringTokenizer;

import net.zloop.mobile.controller.database.DataSourceCallback;
import net.zloop.mobile.controller.database.ZloopDatabaseManager;
import net.zloop.mobile.controller.zloopops.ZloopJob;
import net.zloop.mobile.controller.zloopops.ZloopTaskStatus;
import net.zloop.mobile.model.LoginData;
import net.zloop.mobile.model.User;

import org.springframework.http.HttpEntity;
import org.springframework.http.HttpHeaders;
import org.springframework.http.HttpMethod;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.util.LinkedMultiValueMap;
import org.springframework.util.MultiValueMap;
import org.springframework.web.client.HttpClientErrorException;
import org.springframework.web.client.RestTemplate;

import com.j256.ormlite.dao.RuntimeExceptionDao;

public class ZloopLoginImpl extends ZloopJob {

	private static final String LOGIN_URI = "/index.php/api/login";
	private LoginData loginData;
	private User mResult = null;
	
	public ZloopLoginImpl(LoginData loginData) {
		super();
		this.loginData = loginData;
	}

	public void doOfflineBackground(WeakReference<DataSourceCallback> datasourceRef) {
		DataSourceCallback datasource = datasourceRef.get();
		if (datasource != null) {
			User me = ZloopDatabaseManager.getMe(datasource);
			if (me.getUsername().equals(loginData.getUsername())) {
				mResult = me;
			}
		}
	}

	public void doOnlineBackground(String baseUri,
			WeakReference<DataSourceCallback> datasourceRef) throws Exception {
		final String mURI = baseUri + LOGIN_URI;
		String session = "";
		MediaType mediaType = MediaType.APPLICATION_JSON;
		HttpHeaders requestHeaders = new HttpHeaders();
		requestHeaders.add("Cookie", session);
		HttpEntity<LoginData> requestEntity = new HttpEntity<LoginData>(
				loginData, requestHeaders);

		RestTemplate restTemplate = new RestTemplate();
		ResponseEntity<User> responseEntity = restTemplate.exchange(mURI,
				HttpMethod.POST, requestEntity, User.class);
		User user = responseEntity.getBody();
		HttpHeaders header = responseEntity.getHeaders();
		if (header.containsKey("Set-Cookie")) {
			List<String> sessionIDs = header.get("Set-Cookie");
			if (sessionIDs.size() > 1) {
				StringTokenizer tok = new StringTokenizer(sessionIDs.get(1),
						"* ");
				session = tok.nextToken();

				int i = 0;
				i++;
			}
		}
		user.setSession(session);
		ZloopAuthUtil.checkSession(baseUri, session);
		DataSourceCallback datasource = datasourceRef.get();
		if (datasource != null) {
			ZloopDatabaseManager.updateUser(datasource, user);
			mResult = user;
		}
	}

	public Object getResult() {
		return mResult;
	}

}
