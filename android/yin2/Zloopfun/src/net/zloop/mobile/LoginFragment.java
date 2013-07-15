package net.zloop.mobile;

import android.app.Activity;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;


public class LoginFragment extends Fragment implements OnClickListener {
	LoginCallback mCallback;
	
	public interface LoginCallback{
		public void onLogin(String username, String password);
	}
	

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

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		View v = inflater.inflate(R.layout.login, container, false);
		return v;
	}
	
	@Override
	public void onAttach(Activity activity) {
		super.onAttach(activity);
		// This makes sure that the container activity has implemented
        // the callback interface. If not, it throws an exception
        try {
            mCallback = (LoginCallback) activity;
        } catch (ClassCastException e) {
            throw new ClassCastException(activity.toString()
                    + " must implement LoginCallback");
        }
		
		
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
		String username = ((EditText) getView().findViewById(
				R.id.editText_username)).getText().toString();
		String password = ((EditText) getView().findViewById(
				R.id.editText_password)).getText().toString();
		
		//hide textviews and show progress bar
//		getView().findViewById(R.id.imageView_logo).setVisibility(View.INVISIBLE);
//		getView().findViewById(R.id.editText_username).setVisibility(View.INVISIBLE);
//		getView().findViewById(R.id.editText_password).setVisibility(View.INVISIBLE);
//		getView().findViewById(R.id.button_submit).setVisibility(View.INVISIBLE);

//		getView().findViewById(R.id.loginbox).setVisibility(View.INVISIBLE);
//		getView().findViewById(R.id.progressBar_login).setVisibility(View.VISIBLE);
		
		
		mCallback.onLogin(username, password);

	}
}
