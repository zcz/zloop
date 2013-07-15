package net.zloop.mobile.imageCache;

import java.io.File;
import java.lang.ref.WeakReference;

import net.zloop.mobile.BuildConfig;
import android.graphics.Bitmap;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.ImageView;

public class NormalWorkerTask extends AsyncTask<Object, Void, Bitmap> {
	private static final String TAG = "BitmapWorkerTask";
	public Object data;
	private final WeakReference<ImageView> imageViewReference;
	private DiskLruCache mImageCache;
	private boolean mExitTasksEarly = false;
	private String imgTag;

	public NormalWorkerTask(ImageView imageView, DiskLruCache imageCache) {
		imageViewReference = new WeakReference<ImageView>(imageView);
		this.mImageCache = imageCache;
		imgTag = (String) imageView.getTag();
		if (BuildConfig.DEBUG) {
			String abc = "";
			abc += " Imageview exists:" + (imageView != null);
			Log.d(TAG, "init: " + abc);
		}
	}

	/**
	 * Background processing.
	 */
	@Override
	protected Bitmap doInBackground(Object... params) {
		data = params[0];
		final String dataString = String.valueOf(data);
		if (BuildConfig.DEBUG) {
			String abc = "";
			abc += " First:"
					+ (mImageCache != null && !isCancelled()
							&& getAttachedImageView() != null && !mExitTasksEarly);
			abc += " Cache :" + (mImageCache != null);
			abc += " Cancelled :" + (!isCancelled());
			abc += " Attach :" + (getAttachedImageView() != null);
			Log.d(TAG, "start: " + dataString + abc);
		}
		Bitmap bitmap = null;

		// If the image cache is available and this task has not been cancelled
		// by another
		// thread and the ImageView that was originally bound to this task is
		// still bound back
		// to this task and our "exit early" flag is not set then try and fetch
		// the bitmap from
		// the cache
		if (mImageCache != null && !isCancelled()
				&& getAttachedImageView() != null && !mExitTasksEarly) {
			bitmap = mImageCache.get(dataString);
			if (BuildConfig.DEBUG) {
				Log.d(TAG, "hit cache");
			}
		}
		if (BuildConfig.DEBUG) {
			String abc = "";
			abc += " Second:"
					+ (bitmap == null && !isCancelled()
							&& getAttachedImageView() != null && !mExitTasksEarly);

			abc += " Bitmap :" + (bitmap == null);
			abc += " Cancelled :" + (!isCancelled());
			abc += " Attach :" + (getAttachedImageView() != null);
			Log.d(TAG, "start: " + dataString + abc);
		}
		// If the bitmap was not found in the cache and this task has not been
		// cancelled by
		// another thread and the ImageView that was originally bound to this
		// task is still
		// bound back to this task and our "exit early" flag is not set, then
		// call the main
		// process method (as implemented by a subclass)
		if (bitmap == null && !isCancelled() && getAttachedImageView() != null
				&& !mExitTasksEarly) {
			final File f = new File(dataString);
			if (BuildConfig.DEBUG) {
				Log.d(TAG, "start fetching bitmap");
			}
			if (f != null) {
				if (BuildConfig.DEBUG) {
					Log.d(TAG, "fetching bitmap");
				}
				// Return a sampled down version
				bitmap = Decoder.decodeSampledBitmapFromFile(f.toString(), 500,
						400);
			}
		}

		// If the bitmap was processed and the image cache is available, then
		// add the processed
		// bitmap to the cache for future use. Note we don't check if the task
		// was cancelled
		// here, if it was, and the thread is still running, we may as well add
		// the processed
		// bitmap to our cache as it might be used again in the future
		if (bitmap != null && mImageCache != null) {
			mImageCache.put(dataString, bitmap);
		}
		if (BuildConfig.DEBUG) {
			if (bitmap == null)
				Log.d(TAG, "end returning: null - " + isCancelled());
			else
				Log.d(TAG, "end returning: something");
		}
		return bitmap;
	}

	/**
	 * Once the image is processed, associates it to the imageView
	 */
	@Override
	protected void onPostExecute(Bitmap bitmap) {
		// if cancel was called on this task or the "exit early" flag is set
		// then we're done
		if (isCancelled() || mExitTasksEarly) {
			bitmap = null;
		}

		final ImageView imageView = getAttachedImageView();
		if (bitmap != null && imageView != null) {
			Utils.setImageBitmap(imageView, bitmap);
		}
	}

	/**
	 * Returns the ImageView associated with this task as long as the
	 * ImageView's task still points to this task as well. Returns null
	 * otherwise.
	 */
	private ImageView getAttachedImageView() {

		final ImageView imageView = imageViewReference.get();
        final NormalWorkerTask bitmapWorkerTask = Utils.getNormalWorkerTask(imageView);

        if (this == bitmapWorkerTask) {
            return imageView;
        }

        return null;
	}

}
