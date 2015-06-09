package com.xiaoy.core.harest.conn;

import org.webharvest.definition.ScraperConfiguration;
import org.webharvest.runtime.Scraper;
import org.webharvest.runtime.variables.Variable;

public class GrabPage {
	
	public static String getData (String _url) throws Exception {
		
		ScraperConfiguration config = new ScraperConfiguration(_url);
		Scraper scraper = new Scraper(config, "d:/wh/work/");
		scraper.setDebug(true);
		scraper.execute();
		Variable r1 = scraper.getContext().getVar("targetPage");
		return r1.toString();
	}

}
