package net.zloop.mobile.model;

import java.util.Scanner;

import org.simpleframework.xml.Element;
import org.simpleframework.xml.Root;

@Root(name="comment")
public class Comment {
	@Element
	private String content;
	
	@Element
	private int itemid;
	
	@Element
	private int isprivate = 1;

	private String itemUri;

	public Comment(String content, String itemUri) {
		super();
		this.content = content;
		this.itemUri = itemUri;
		Scanner in = new Scanner(itemUri).useDelimiter("[^0-9]+");
		itemid = in.nextInt();
	}

	public Comment() {
		super();
	}

	public String getContent() {
		return content;
	}

	public void setContent(String content) {
		this.content = content;
	}

	public int getItemid() {
		return itemid;
	}

	public void setItemid(int itemid) {
		this.itemid = itemid;
	}

	public int getIsprivate() {
		return isprivate;
	}

	public void setIsprivate(int isprivate) {
		this.isprivate = isprivate;
	}

	public String getItemUri() {
		return itemUri;
	}

	public void setItemUri(String itemUri) {
		this.itemUri = itemUri;
	}
	
	
}
