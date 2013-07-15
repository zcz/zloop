package net.zloop.mobile.imageCache;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.lang.ref.WeakReference;
import java.net.URL;
import java.text.SimpleDateFormat;
import java.util.Date;

import net.zloop.mobile.BuildConfig;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.Matrix;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Environment;
import android.provider.MediaStore.MediaColumns;
import android.util.Log;
import android.widget.ImageView;

public class BitmapWorkerTask extends AsyncTask<Object, Void, BitmapAndPath> {
	private static final String TAG = "BitmapWorkerTask";
	public Object data;
	private final WeakReference<ImageView> imageViewReference;
	private DiskLruCache mImageCache;
	private boolean mExitTasksEarly = false;
	private final WeakReference<CacheCallback> callbackReference;
	private String imgTag;
	private String resultUriPath;

	private static final String JPEG_FILE_PREFIX = "IMG_";
	private static final String JPEG_FILE_SUFFIX = ".jpg";
	private AlbumStorageDirFactory mAlbumStorageDirFactory = null;
	
	private int targetWidth = 0;
	private int targetHeight = 0;

	public BitmapWorkerTask(ImageView imageView, DiskLruCache imageCache,
			CacheCallback callback) {
		imageViewReference = new WeakReference<ImageView>(imageView);
		callbackReference = new WeakReference<CacheCallback>(callback);
		this.mImageCache = imageCache;
		targetHeight = imageView.getHeight();
		targetWidth = imageView.getWidth();
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
	protected BitmapAndPath doInBackground(Object... params) {

		data = params[0];
		final String dataString = String.valueOf(data);
		Uri selectedImage = Uri.parse(dataString);

		int rotation = (Integer) params[1];

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
		if (mImageCache != null && !isCancelled() && !mExitTasksEarly) {
			bitmap = mImageCache.get(dataString);
			if (!selectedImage.toString().startsWith(
					"content://com.")) {
				resultUriPath = dataString;
			}
			if (BuildConfig.DEBUG) {
				Log.d(TAG, "Second: hit cache");
			}
		}
		if (BuildConfig.DEBUG) {
			String abc = "";
			abc += " Second:"
					+ (bitmap == null && !isCancelled() && !mExitTasksEarly);

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
		if (bitmap == null && !isCancelled() && !mExitTasksEarly) {
			File cacheDir = null;
			Bitmap bitmapraw = fetchBitmap(imgTag, selectedImage);
			Matrix matrix = new Matrix();
			matrix.postRotate(rotation);
			if (bitmapraw != null)
				bitmap = Bitmap.createBitmap(bitmapraw, 0, 0, bitmapraw.getWidth(), bitmapraw.getHeight(),
			        matrix, true);

		}
		else {
			if (BuildConfig.DEBUG) {
				Log.d(TAG, "Third: not hitting third");
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
		return new BitmapAndPath(bitmap, resultUriPath);
	}

	/**
	 * Once the image is processed, associates it to the imageView
	 */
	@Override
	protected void onPostExecute(BitmapAndPath bitmap) {
		// if cancel was called on this task or the "exit early" flag is set
		// then we're done
		if (isCancelled() || mExitTasksEarly) {
			bitmap = null;
		}
		final CacheCallback callback = callbackReference.get();
		final ImageView imageView = getAttachedImageView();
		if (BuildConfig.DEBUG){
			String abc = "";
			abc += "  path is null:"
					+ (bitmap.getPath() == null);
			Log.d(TAG, "onPostExecute: " + abc);
		}
		if (bitmap != null && imageView != null && callback != null && bitmap.getPath() != null) {
			if (BuildConfig.DEBUG)
				Log.d(TAG, "onPostExecute returning: something - ");
			Utils.setImageBitmap(imageView, bitmap.getBitmap());
//			callback.setAbsoluteUriPath(bitmap.getPath());
		}
	}

	/**
	 * Returns the ImageView associated with this task as long as the
	 * ImageView's task still points to this task as well. Returns null
	 * otherwise.
	 */
	private ImageView getAttachedImageView() {

		if (BuildConfig.DEBUG) {
			Log.d(TAG, " image tag:" + imgTag);
		}

		final CacheCallback callback = callbackReference.get();
		if (callback != null) {
			return callback.findImageViewWithTag(imgTag);
		}

		return null;
	}
	private CacheCallback getCallback() {
		return callbackReference.get();
	}
	
	private Bitmap fetchBitmap (String tag, Uri selectedImage){
		final String[] filePathColumn = { MediaColumns.DATA,
				MediaColumns.DISPLAY_NAME };
		final CacheCallback callback = callbackReference.get();
		if (callback == null) {
			if (BuildConfig.DEBUG) {
				String abc = "";
				abc += " callback not found";
				Log.d(tag, "background: " + abc);
			}
			return null;
		}
		Cursor cursor = callback.getContentResolver().query(selectedImage,
				filePathColumn, null, null, null);
		// some devices (OS versions return an URI of com.android
		// instead of com.google.android
		if (selectedImage.toString().startsWith(
				"content://com.android.gallery3d.provider")) {
			// use the com.google provider, not the com.android
			// provider.
			selectedImage = Uri.parse(selectedImage.toString().replace(
					"com.android.gallery3d",
					"com.google.android.gallery3d"));
		}
		if (cursor != null) {
			cursor.moveToFirst();
			int columnIndex = cursor.getColumnIndex(MediaColumns.DATA);
			// if it is a picasa image on newer devices with OS 3.0 and
			// up
			if (selectedImage.toString().startsWith(
					"content://com.google.android.gallery3d")) {
				columnIndex = cursor
						.getColumnIndex(MediaColumns.DISPLAY_NAME);
				if (columnIndex != -1) {
					final Uri uriurl = selectedImage;
					// Do this in a background thread, since we are
					// fetching a large image from the web
//					new Thread(new Runnable() {
//						public void run() {
//							Bitmap the_image = getBitmap(
//									"image_file_name.jpg", uriurl);
//						}
//					}).start();
					Log.d(tag, "picasa image after 3.0: " + uriurl.toString());
					return getPicasaBitmap(tag, uriurl);
					
				}
			} else { // it is a regular local image file
				String filePath = cursor.getString(columnIndex);
				cursor.close();
//				TextView tv = (TextView) findViewById(R.id.textView1);
				File file = new File(filePath);
				if (file.exists()) {
					Log.d(tag, "local file: " + filePath.toString());
					resultUriPath = selectedImage.toString();
					return Decoder.decodeSampledBitmapFromFile(filePath, targetWidth,targetHeight);
				}
				
//				Bitmap the_image = decodeFile(new File(filePath));
			}
		}
		// If it is a picasa image on devices running OS prior to 3.0
		else if (selectedImage != null
				&& selectedImage.toString().length() > 0) {
			final Uri uriurl = selectedImage;
			// Do this in a background thread, since we are fetching a
			// large image from the web
//			new Thread(new Runnable() {
//				public void run() {
//					Bitmap the_image = getBitmap("image_file_name.jpg",
//							uriurl);
//				}
//			}).start();
			Log.d(tag, "picasa image prior to 3.0: " + uriurl.toString());
			return getPicasaBitmap(tag, uriurl);
		}
		return null;
	}
	private Bitmap getPicasaBitmap(String tag, Uri uri) {
		File cacheDir;
		if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.FROYO) {
			mAlbumStorageDirFactory = new FroyoAlbumDirFactory();
		} else {
			mAlbumStorageDirFactory = new BaseAlbumDirFactory();
		}
		
		try {
			Bitmap bitmap = null;
			InputStream is = null;
			File f = setUpPhotoFile();
			if (uri.toString().startsWith(
					"content://com.google.android.gallery3d")) {
				final CacheCallback callback = getCallback();
				if (callback == null) {
					if (BuildConfig.DEBUG) {
						String abc = "";
						abc += " callback not found";
						Log.d("getImagePickerCallback", "background: " + abc);
					}
					return null;
				}
				is = callback.getContentResolver().openInputStream(uri);
			} else {
				is = new URL(uri.toString()).openStream();
			}
			OutputStream os = new FileOutputStream(f);
			Utils.CopyStream(is, os);
			os.close();
			resultUriPath = Uri.fromFile(f).toString();
			bitmap = Decoder.decodeSampledBitmapFromFile(f.getAbsolutePath(),  targetWidth,targetHeight);
//			mImageCache.removeCache(tag);
//			fd.close();
			int i = 0;
			i++;
			return bitmap;
		} catch (Exception ex) {
			Log.d(TAG, "Exception: " + ex.getMessage());
			// something went wrong
			ex.printStackTrace();
			return null;
		}
	}
	private String getAlbumName() {
		return "yinAlbum";
	}

	
	private File getAlbumDir() {
		File storageDir = null;

		if (Environment.MEDIA_MOUNTED.equals(Environment.getExternalStorageState())) {
			
			storageDir = mAlbumStorageDirFactory.getAlbumStorageDir(getAlbumName());

			if (storageDir != null) {
				if (! storageDir.mkdirs()) {
					if (! storageDir.exists()){
						Log.d("CameraSample", "failed to create directory");
						return null;
					}
				}
			}
			
		} else {
			Log.v("FetchBitmapTask", "External storage is not mounted READ/WRITE.");
		}
		
		return storageDir;
	}

	private File createImageFile() throws IOException {
		// Create an image file name
		String timeStamp = new SimpleDateFormat("yyyyMMdd_HHmmss").format(new Date());
		String imageFileName = JPEG_FILE_PREFIX + timeStamp + "_";
		File albumF = getAlbumDir();
		File imageF = File.createTempFile(imageFileName, JPEG_FILE_SUFFIX, albumF);
		return imageF;
	}

	private File setUpPhotoFile() throws IOException {
		
		File f = createImageFile();
//		mCurrentPhotoPath = f.getAbsolutePath();
		
		return f;
	}
}
