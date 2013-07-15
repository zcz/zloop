package net.zloop.mobile.imageCache;

import java.lang.ref.WeakReference;

import android.content.res.Resources;
import android.graphics.Bitmap;
import android.graphics.drawable.BitmapDrawable;

/**
 * A custom Drawable that will be attached to the imageView while the work is in progress.
 * Contains a reference to the actual worker task, so that it can be stopped if a new binding is
 * required, and makes sure that only the last started worker process can bind its result,
 * independently of the finish order.
 */
public class AsyncDrawable extends BitmapDrawable {
    private final WeakReference<Object> bitmapWorkerTaskReference;

    public AsyncDrawable(Resources res, Bitmap bitmap, Object bitmapWorkerTask) {
        super(res, bitmap);

        bitmapWorkerTaskReference =
            new WeakReference<Object>(bitmapWorkerTask);
    }

    public Object getBitmapWorkerTask() {
        return bitmapWorkerTaskReference.get();
    }
}
