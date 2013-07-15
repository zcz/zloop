package net.zloop.mobile.controller.zloopops;

import java.util.List;
import java.util.StringTokenizer;

import net.zloop.mobile.R;
import net.zloop.mobile.R.id;
import net.zloop.mobile.R.layout;
import net.zloop.mobile.R.string;
import net.zloop.mobile.controller.database.ConnectionUtil;
import net.zloop.mobile.model.LoginData;
import net.zloop.mobile.model.User;

import org.springframework.http.HttpEntity;
import org.springframework.http.HttpHeaders;
import org.springframework.http.HttpMethod;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.client.HttpClientErrorException;
import org.springframework.web.client.RestTemplate;

import android.app.Activity;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;


public class LoginFragment extends Fragment implements OnClickListener {
	

	/**
	 * Create a new instance of CountingFragment, providing "num" as an
	 * argument.
	 */
	static LoginFragment newInstance(String name, String password) {
		LoginFragment f = new LoginFragment();

		// Supply num input as an argument.
		/*
		 * Bundle args = new Bundle(); args.putInt("num", num);
		 * f.setArguments(args);
		 */

		return f;
	}

	/**
	 * When creating, retrieve this instance's number from its arguments.
	 */
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		// mNum = getArguments() != null ? getArguments().getInt("num") : 1;
	}

//	@Override
//	public View onCreateView(LayoutInflater inflater, ViewGroup container,
//			Bundle savedInstanceState) {
//		View v = inflater.inflate(R.layout.login_activity, container, false);
//		return v;
//	}
	
	@Override
	public void onAttach(Activity activity) {
		super.onAttach(activity);
//		loginController = (LoginController) activity;
	}

	@Override
	public void onStart() {
		super.onStart();
		Button submit_button = (Button) getView().findViewById(
				R.id.button_submit);
		submit_button.setOnClickListener(this);
	}

	public void onClick(View arg0) {
		EditText loginName = (EditText) getView().findViewById(
				R.id.editText_username);
		EditText password = (EditText) getView().findViewById(
				R.id.editText_password);
		

		new LoginTask().execute(loginName.getText().toString(), password.getText().toString());
		
	}

	public class LoginTask extends AsyncTask<String, Void, User> {

		LoginData loginData = new LoginData();
		final String loginUrl = getString(R.string.base_uri)
				+ "/index.php/api/login";

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			
		}

		@Override
		protected User doInBackground(String... params) {
			if (! ConnectionUtil.isConnected(getActivity())) {
				return null;
			}
			String loginName = params[0];
			String password = params[1];
			loginData.setUsername(loginName);
			loginData.setPassword(password);
			String session = "";
			MediaType mediaType = MediaType.APPLICATION_JSON;
			HttpHeaders requestHeaders = new HttpHeaders();
			requestHeaders.add("Cookie", session);
			HttpEntity<LoginData> requestEntity = new HttpEntity<LoginData>(
					loginData, requestHeaders);
			try {
				RestTemplate restTemplate = new RestTemplate();
				ResponseEntity<User> responseEntity = restTemplate.exchange(
						loginUrl, HttpMethod.POST, requestEntity, User.class);
				User user = responseEntity.getBody();
				HttpHeaders header = responseEntity.getHeaders();
				if (header.containsKey("Set-Cookie")) {
					List<String> sessionIDs = header.get("Set-Cookie");
					if (sessionIDs.size() > 1) {
						StringTokenizer tok = new StringTokenizer(
								sessionIDs.get(1), "* ");
						session = tok.nextToken();

						int i = 0;
						i++;
					}
				}
				return user;
				
				
			} catch (HttpClientErrorException e) {
				return null;
				// }
			} catch (Exception e) {
				int i = 0;
				i++;
			}
			return null;
		}

		@Override
		protected void onPostExecute(User user) {
//			RuntimeExceptionDao<User, Integer> simpleDao = loginController.getUserDataSource();
//			List<User> list = simpleDao.queryForMatching(user);
//			if (list.size() == 0) {
//				simpleDao.create(user);
//			}
//			else {
//				User currentUser = list.get(0);
//				currentUser.setSession(user.getSession());
//				simpleDao.update(currentUser);
//			}
//			LoginController controller = (LoginController) getActivity();
//			controller.onLoginSuccess();
		}

	}
}
