package net.zloop.mobile.imageCache;

import java.io.File;

import net.zloop.mobile.R;
import android.app.Activity;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.widget.ImageView;

public class Cache {
	private static DiskLruCache mDiskCache;
	private static Bitmap mLoadingBitmap;
	public static DiskLruCache getInstance() {
		return mDiskCache;
	}
	public static void setupCache(Context mContext) {
		ImageCacheParams cacheParams = new ImageCacheParams("FunPlayer");
		cacheParams.memCacheSize = 1024 * 1024 * Utils.getMemoryClass(mContext) / 3;

		final File diskCacheDir = DiskLruCache.getDiskCacheDir(mContext,
				cacheParams.uniqueName);

		mDiskCache = DiskLruCache.openCache(mContext, diskCacheDir,
				cacheParams.diskCacheSize);
		mDiskCache.setCompressParams(cacheParams.compressFormat,
				cacheParams.compressQuality);
		if (cacheParams.clearDiskCacheOnStart) {
			mDiskCache.clearCache();
		}
		mLoadingBitmap = BitmapFactory.decodeResource(mContext.getResources(),
				R.drawable.ic_launcher);
	}
	public static void loadImage(Activity mContext, CacheCallback callback, Object data, int rotation,
			ImageView imageView) {
		String addr = data.toString();
		if (!addr.startsWith("file"))
			addr = mContext.getString(R.string.base_uri) + addr;
		data = addr;
		if (mDiskCache != null && imageView != null) {
			if (ImageCache.cancelPotentialWork(data, imageView)) {
				final BitmapWorkerTask task = new BitmapWorkerTask(imageView, mDiskCache,  callback);
				final AsyncDrawable asyncDrawable = new AsyncDrawable(
						mContext.getResources(), mLoadingBitmap, task);
				imageView.setImageDrawable(asyncDrawable);
				task.execute(data, rotation);
			}
		}
	}
	public static void clearCache() {
		if (mDiskCache != null)
			mDiskCache.clearCache();
	}
	public static void clearCache(String key) {
		if (mDiskCache != null)
			mDiskCache.removeCache(key);
	}
}
