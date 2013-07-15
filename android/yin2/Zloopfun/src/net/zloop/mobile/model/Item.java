package net.zloop.mobile.model;

import java.util.Collection;
import java.util.Collections;

import org.simpleframework.xml.Element;
import org.simpleframework.xml.ElementArray;
import org.simpleframework.xml.ElementList;
import org.simpleframework.xml.Root;

import com.j256.ormlite.field.DatabaseField;
import com.j256.ormlite.field.ForeignCollectionField;

@Root(name="item")
public class Item {
	@DatabaseField(generatedId=true)
	@Element
	private int id;
	@DatabaseField
	@Element
	private String title;
	@DatabaseField
	private String uri;
	@DatabaseField
	@Element
	private int pricelow;
	@DatabaseField
	@Element
	private int pricehigh;
	@DatabaseField
	@Element
	private String content;
	@DatabaseField
	@Element
	private String presentation;
	@DatabaseField
	@Element
	private String summary;
	@DatabaseField
	@Element
	private String tagString;
	@DatabaseField
	@Element
	private long create_time;
	@DatabaseField
	@Element
	private long last_modified;
	@DatabaseField
	@Element
	private int userid;
	@DatabaseField
	@Element
	private int categoryid;
	@DatabaseField
	@Element
	private int conditionid;
	@DatabaseField
	@Element
	private int statusid;
	@DatabaseField
	@Element
	private long expire_time;
	@DatabaseField
	@Element
	private int conditionbackup;
	@DatabaseField
	@Element
	private long expire_email_flag_time;
	@ForeignCollectionField
	@ElementList
	private Collection<ItemImg> pics;
	public Item() {
		super();
	}
	public Item(int id, String title, int pricelow, int pricehigh,
			String content, String presentation, String summary,
			String tagString, long create_time, long last_modified, int userid,
			int categoryid, int conditionid, int statusid, long expire_time,
			int conditionbackup, long expire_email_flag_time,
			Collection<ItemImg> pics) {
		super();
		this.id = id;
		this.title = title;
		this.pricelow = pricelow;
		this.pricehigh = pricehigh;
		this.content = content;
		this.presentation = presentation;
		this.summary = summary;
		this.tagString = tagString;
		this.create_time = create_time;
		this.last_modified = last_modified;
		this.userid = userid;
		this.categoryid = categoryid;
		this.conditionid = conditionid;
		this.statusid = statusid;
		this.expire_time = expire_time;
		this.conditionbackup = conditionbackup;
		this.expire_email_flag_time = expire_email_flag_time;
		this.pics = pics;
	}
	public String getUri() {
		return uri;
	}
	public void setUri(String uri) {
		this.uri = uri;
	}
	public int getId() {
		return id;
	}
	public void setId(int id) {
		this.id = id;
	}
	public String getTitle() {
		return title;
	}
	public void setTitle(String title) {
		this.title = title;
	}
	public int getPricelow() {
		return pricelow;
	}
	public void setPricelow(int pricelow) {
		this.pricelow = pricelow;
	}
	public int getPricehigh() {
		return pricehigh;
	}
	public void setPricehigh(int pricehigh) {
		this.pricehigh = pricehigh;
	}
	public String getContent() {
		return content;
	}
	public void setContent(String content) {
		this.content = content;
	}
	public String getPresentation() {
		return presentation;
	}
	public void setPresentation(String presentation) {
		this.presentation = presentation;
	}
	public String getSummary() {
		return summary;
	}
	public void setSummary(String summary) {
		this.summary = summary;
	}
	public String getTagString() {
		return tagString;
	}
	public void setTagString(String tagString) {
		this.tagString = tagString;
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
	public int getUserid() {
		return userid;
	}
	public void setUserid(int userid) {
		this.userid = userid;
	}
	public int getCategoryid() {
		return categoryid;
	}
	public void setCategoryid(int categoryid) {
		this.categoryid = categoryid;
	}
	public int getConditionid() {
		return conditionid;
	}
	public void setConditionid(int conditionid) {
		this.conditionid = conditionid;
	}
	public int getStatusid() {
		return statusid;
	}
	public void setStatusid(int statusid) {
		this.statusid = statusid;
	}
	public long getExpire_time() {
		return expire_time;
	}
	public void setExpire_time(long expire_time) {
		this.expire_time = expire_time;
	}
	public int getConditionbackup() {
		return conditionbackup;
	}
	public void setConditionbackup(int conditionbackup) {
		this.conditionbackup = conditionbackup;
	}
	public long getExpire_email_flag_time() {
		return expire_email_flag_time;
	}
	public void setExpire_email_flag_time(long expire_email_flag_time) {
		this.expire_email_flag_time = expire_email_flag_time;
	}
	public Collection<ItemImg> getPics() {
		return pics;
	}
	public void setPics(Collection<ItemImg> pics) {
		this.pics = pics;
	}
	@Override
	public String toString() {
		return "Item [id=" + id + ", title=" + title + ", uri=" + uri + "]";
	}

	
}
