package net.zloop.mobile.imageCache;

import java.io.File;

import android.content.ContentResolver;
import android.widget.ImageView;

public interface CacheCallback {
	public ImageView findImageViewWithTag(Object o);
	public ContentResolver getContentResolver();
	public File getCacheDir();
}
