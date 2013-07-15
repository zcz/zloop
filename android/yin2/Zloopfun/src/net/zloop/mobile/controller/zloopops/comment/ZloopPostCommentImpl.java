package net.zloop.mobile.controller.zloopops.comment;

import java.lang.ref.WeakReference;
import java.net.URI;

import net.zloop.mobile.controller.database.DataSourceCallback;
import net.zloop.mobile.controller.database.ZloopDatabaseManager;
import net.zloop.mobile.controller.zloopops.ZloopJob;
import net.zloop.mobile.model.Comment;
import net.zloop.mobile.model.Item;

import org.springframework.http.HttpEntity;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.web.client.HttpClientErrorException;
import org.springframework.web.client.RestTemplate;

public class ZloopPostCommentImpl extends ZloopJob {

	Comment mComment = null;

	public ZloopPostCommentImpl(Comment mComment) {
		super();
		this.mComment = mComment;
	}

	Comment mResult;

	@Override
	public Object getResult() {
		// TODO Auto-generated method stub
		return mResult;
	}

	@Override
	public void doOnlineBackground(String baseUri,
			WeakReference<DataSourceCallback> datasourceRef)
			throws HttpClientErrorException, Exception {
		final DataSourceCallback datasource = datasourceRef.get();
		if (datasource != null) {
			String session = ZloopDatabaseManager
					.getCurrentSessionId(datasource);
			String commentUri = baseUri + "/index.php/api/comment";
			MediaType mediaType = MediaType.APPLICATION_JSON;
			HttpHeaders postHeaders = new HttpHeaders();
			postHeaders.setContentType(mediaType);
			postHeaders.add("Cookie", session);
			RestTemplate restTemplate = new RestTemplate();
			HttpEntity<Comment> requestEntity = new HttpEntity<Comment>(mComment,
					postHeaders);
			URI uri = restTemplate.postForLocation(commentUri, requestEntity);
			String mUri = uri.toASCIIString();
			mResult = mComment;
		}
		
	}
}
