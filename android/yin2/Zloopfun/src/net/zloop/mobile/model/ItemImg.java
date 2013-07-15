package net.zloop.mobile.model;

import org.codehaus.jackson.annotate.JsonIgnore;
import org.simpleframework.xml.Element;
import org.simpleframework.xml.Root;

import com.j256.ormlite.field.DatabaseField;

@Root(name="ItemImg")
public class ItemImg {
	@DatabaseField(generatedId=true)
	private int id;
	@DatabaseField
	@Element
	private String uri;
	@DatabaseField
	private String localPath;
	@DatabaseField(foreign=true,foreignAutoRefresh=true)
    private Item item;
	public ItemImg() {
		super();
	}
	public ItemImg(String uri) {
		super();
		this.uri = uri;
	}
	
	public ItemImg(String localPath, Item item) {
		super();
		this.localPath = localPath;
		this.item = item;
	}
	public String getLocalPath() {
		return localPath;
	}
	public void setLocalPath(String localPath) {
		this.localPath = localPath;
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
	public Item getItem() {
		return item;
	}
	public void setItem(Item item) {
		this.item = item;
	}
	@Override
	public String toString() {
		return "ItemImg [id=" + id + ", uri=" + uri + ", localPath="
				+ localPath + ", item=" + item + "]";
	}
}
