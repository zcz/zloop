package net.zloop.mobile.controller.zloopops.login;

import java.lang.ref.WeakReference;

import net.zloop.mobile.controller.database.DataSourceCallback;
import net.zloop.mobile.model.LoginData;

import org.springframework.http.HttpEntity;
import org.springframework.http.HttpHeaders;
import org.springframework.http.HttpMethod;
import org.springframework.http.ResponseEntity;
import org.springframework.util.LinkedMultiValueMap;
import org.springframework.util.MultiValueMap;
import org.springframework.web.client.RestTemplate;

public class ZloopAuthUtil {
	public static void checkSession (String baseUri, String session) throws Exception{
		final String mURI = baseUri + "/index.php/api/checkSession";
		RestTemplate restTemplate = new RestTemplate();
		HttpHeaders requestHeaders = new HttpHeaders();
		requestHeaders.add("Cookie", session);
		HttpEntity<Object> requestEntity = new HttpEntity<Object>(
				null, requestHeaders);
		ResponseEntity<Object> responseEntity = restTemplate.exchange(mURI, HttpMethod.GET, requestEntity, null);
	}
}
