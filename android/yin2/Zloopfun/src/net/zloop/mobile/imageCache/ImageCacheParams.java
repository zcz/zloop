package net.zloop.mobile.imageCache;

import android.graphics.Bitmap.CompressFormat;

public class ImageCacheParams {
	
	// Default memory cache size
    private static final int DEFAULT_MEM_CACHE_SIZE = 1024 * 1024 * 5; // 5MB

    // Default disk cache size
    private static final int DEFAULT_DISK_CACHE_SIZE = 1024 * 1024 * 10; // 10MB

    // Compression settings when writing images to disk cache
    private static final CompressFormat DEFAULT_COMPRESS_FORMAT = CompressFormat.JPEG;
    private static final int DEFAULT_COMPRESS_QUALITY = 70;

    // Constants to easily toggle various caches
    private static final boolean DEFAULT_MEM_CACHE_ENABLED = true;
    private static final boolean DEFAULT_DISK_CACHE_ENABLED = true;
    private static final boolean DEFAULT_CLEAR_DISK_CACHE_ON_START = true;
	
    public String uniqueName;
    public int memCacheSize = DEFAULT_MEM_CACHE_SIZE;
    public int diskCacheSize = DEFAULT_DISK_CACHE_SIZE;
    public CompressFormat compressFormat = DEFAULT_COMPRESS_FORMAT;
    public int compressQuality = DEFAULT_COMPRESS_QUALITY;
    public boolean memoryCacheEnabled = DEFAULT_MEM_CACHE_ENABLED;
    public boolean diskCacheEnabled = DEFAULT_DISK_CACHE_ENABLED;
    public boolean clearDiskCacheOnStart = DEFAULT_CLEAR_DISK_CACHE_ON_START;

    public ImageCacheParams(String uniqueName) {
        this.uniqueName = uniqueName;
    }
}
