package net.zloop.mobile.model;

import java.sql.Date;

import org.simpleframework.xml.Element;
import org.simpleframework.xml.Root;

import com.j256.ormlite.field.DatabaseField;

@Root(name="user")
public class User {
	@DatabaseField(generatedId=true)
	@Element
	private int id;
	@DatabaseField
	@Element
	private String email;
	@DatabaseField(index=true)
	@Element
	private String username;
	@DatabaseField
	@Element
	private String password;
	@DatabaseField
	@Element
	private String salt;
	@DatabaseField
	@Element
	private String address;
	@DatabaseField
	@Element
	private String phone;
	@DatabaseField
	@Element
	private int ifNotify;
	@DatabaseField
	@Element
	private int sendWeeklyEmail;
	@DatabaseField
	@Element
	private int nextNotify;
	@DatabaseField
	@Element
	private long intervalNotify;
	@DatabaseField
	@Element
	private long create_time;
	@DatabaseField
	@Element
	private long last_modified;
	@DatabaseField
	@Element
	private int profilepicid;
	@DatabaseField
	private String session;
	
	public String getSession() {
		return session;
	}

	public void setSession(String session) {
		this.session = session;
	}

	public User() {
		super();
	}

	public User(int id, String email, String username, String password,
			String salt, String address, String phone, int ifNotify,
			int sendWeeklyEmail, int nextNotify, long intervalNotify,
			long create_time, long last_modified, int profilepicid,
			String session) {
		super();
		this.id = id;
		this.email = email;
		this.username = username;
		this.password = password;
		this.salt = salt;
		this.address = address;
		this.phone = phone;
		this.ifNotify = ifNotify;
		this.sendWeeklyEmail = sendWeeklyEmail;
		this.nextNotify = nextNotify;
		this.intervalNotify = intervalNotify;
		this.create_time = create_time;
		this.last_modified = last_modified;
		this.profilepicid = profilepicid;
		this.session = session;
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getEmail() {
		return email;
	}

	public void setEmail(String email) {
		this.email = email;
	}

	public String getUsername() {
		return username;
	}

	public void setUsername(String username) {
		this.username = username;
	}

	public String getPassword() {
		return password;
	}

	public void setPassword(String password) {
		this.password = password;
	}

	public String getSalt() {
		return salt;
	}

	public void setSalt(String salt) {
		this.salt = salt;
	}

	public String getAddress() {
		return address;
	}

	public void setAddress(String address) {
		this.address = address;
	}

	public String getPhone() {
		return phone;
	}

	public void setPhone(String phone) {
		this.phone = phone;
	}

	public int getIfNotify() {
		return ifNotify;
	}

	public void setIfNotify(int ifNotify) {
		this.ifNotify = ifNotify;
	}

	public int getSendWeeklyEmail() {
		return sendWeeklyEmail;
	}

	public void setSendWeeklyEmail(int sendWeeklyEmail) {
		this.sendWeeklyEmail = sendWeeklyEmail;
	}

	public int getNextNotify() {
		return nextNotify;
	}

	public void setNextNotify(int nextNotify) {
		this.nextNotify = nextNotify;
	}

	public long getIntervalNotify() {
		return intervalNotify;
	}

	public void setIntervalNotify(long intervalNotify) {
		this.intervalNotify = intervalNotify;
	}

	public long getCreate_time() {
		return create_time;
	}

	public void setCreate_time(long create_time) {
		this.create_time = create_time;
	}

	public long getLast_modified() {
		return last_modified;
	}

	public void setLast_modified(long last_modified) {
		this.last_modified = last_modified;
	}

	public int getProfilepicid() {
		return profilepicid;
	}

	public void setProfilepicid(int profilepicid) {
		this.profilepicid = profilepicid;
	}

}
