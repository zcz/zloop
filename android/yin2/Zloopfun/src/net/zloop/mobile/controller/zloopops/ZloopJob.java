package net.zloop.mobile.controller.zloopops;

import java.lang.ref.WeakReference;

import net.zloop.mobile.controller.database.DataSourceCallback;

import org.springframework.web.client.HttpClientErrorException;


public class ZloopJob {
	
	ZloopTaskStatus mStatus = ZloopTaskStatus.NEW;
	int ZloopJobId = 0;
	public Object getResult(){
		return null;
		
	}

	public void doOnlineBackground(String baseUri, WeakReference<DataSourceCallback> datasource) throws HttpClientErrorException, Exception {
		
	}
	
	public void doOfflineBackground(WeakReference<DataSourceCallback> datasource){
		
	}
	
	public void doPostExecute(){
		
	}

	public ZloopTaskStatus getStatus(){
		return mStatus;
	}
	
	public void setStatus(ZloopTaskStatus status) {
		mStatus = status;
	}
	
	public int getZloopJobId() {
		return ZloopJobId;
	}
	public void setZloopJobId(int id) {
		ZloopJobId = id;
	}
}
