package net.zloop.mobile.imageCache;

import net.zloop.mobile.BuildConfig;
import android.util.Log;
import android.widget.ImageView;

public class ImageCache {
	

	public static boolean cancelPotentialWork(Object data, ImageView imageView) {
		final BitmapWorkerTask bitmapWorkerTask = Utils.getBitmapWorkerTask(imageView);
		final String TAG = "cancelPotentialWork";
		if (bitmapWorkerTask != null) {
			final Object bitmapData = bitmapWorkerTask.data;
			if (bitmapData == null || !bitmapData.equals(data)) {
				bitmapWorkerTask.cancel(true);
				if (BuildConfig.DEBUG) {
					Log.d(TAG , "cancelPotentialWork - cancelled work for "
							+ data);
				}
			} else {
				// The same work is already in progress.
				return false;
			}
		}
		return true;
	}
}
