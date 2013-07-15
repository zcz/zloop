package net.zloop.mobile.imageCache;

import android.graphics.Bitmap;

public class BitmapAndPath {
	private Bitmap bitmap;
	private String path;
	public Bitmap getBitmap() {
		return bitmap;
	}
	public void setBitmap(Bitmap bitmap) {
		this.bitmap = bitmap;
	}
	public String getPath() {
		return path;
	}
	public void setPath(String path) {
		this.path = path;
	}
	public BitmapAndPath(Bitmap bitmap, String path) {
		super();
		this.bitmap = bitmap;
		this.path = path;
	}
	
}
