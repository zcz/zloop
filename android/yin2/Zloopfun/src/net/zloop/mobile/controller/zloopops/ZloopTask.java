package net.zloop.mobile.controller.zloopops;

import java.lang.ref.WeakReference;

import org.springframework.web.client.HttpClientErrorException;

import net.zloop.mobile.BuildConfig;
import net.zloop.mobile.R;
import net.zloop.mobile.controller.database.DataSourceCallback;

import android.os.AsyncTask;
import android.util.Log;

public class ZloopTask extends AsyncTask<ZloopJob, Void, ZloopJob> {
	WeakReference<ZloopTaskCallback> zloopTaskCallbackReference;
	private static final String TAG = "ZloopTask";
	private String baseUri = "";
	private boolean isConnected = false;

	public ZloopTask(ZloopTaskCallback zloopTaskCallback) {
		super();
		// this.zloopTaskCallback = zloopTaskCallback;
		zloopTaskCallbackReference = new WeakReference<ZloopTaskCallback>(
				zloopTaskCallback);
		baseUri = zloopTaskCallback.getString(R.string.base_uri);
		isConnected = zloopTaskCallback.isConnected();
	}

	@Override
	protected void onPreExecute() {
		// TODO Auto-generated method stub
		super.onPreExecute();

	}

	@Override
	protected ZloopJob doInBackground(ZloopJob... params) {
		ZloopJob mJob = params[0];
		ZloopTaskCallback callback = zloopTaskCallbackReference.get();
		try {
			if (callback != null) {
				if (isConnected)
					mJob.doOnlineBackground(baseUri,
							new WeakReference<DataSourceCallback>(callback));
				else
					mJob.doOfflineBackground(new WeakReference<DataSourceCallback>(
							callback));
			}
			if (mJob.getResult() != null) {
				mJob.setStatus(ZloopTaskStatus.SUCCESS);
			}
			else {
				mJob.setStatus(ZloopTaskStatus.NOT_FOUND);
			}

		} catch (HttpClientErrorException e) {
			String msg = e.getMessage();
			if (e.getMessage().startsWith("401")) {
				mJob.setStatus(ZloopTaskStatus.AUTHENTICATION_FAILED);
			}
			else {
				mJob.setStatus(ZloopTaskStatus.NOT_FOUND);
			}
			// }
		} catch (Exception e) {
			int i = 0;
			i++;
			e.printStackTrace();
		}

		// TODO Auto-generated method stub
		return mJob;
	}

	@Override
	protected void onPostExecute(ZloopJob result) {
		super.onPostExecute(result);
		result.doPostExecute();
		ZloopTaskCallback callback = zloopTaskCallbackReference.get();
		if (callback != null) {
			if (BuildConfig.DEBUG) {
				Log.d(TAG, "Postexecute: callback found");
			}
			switch (result.getStatus()) {
			case SUCCESS:
				callback.onSuccess(result.getZloopJobId(), result.getResult());
				break;
			case AUTHENTICATION_FAILED:
				callback.onHttpAuthenticationFail(result.getZloopJobId());
				break;
			case NOT_FOUND:
				callback.onHttpNotFound(result.getZloopJobId());
			}
		}
	}

}
