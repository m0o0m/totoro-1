package com.xiaoy.core.harest.servlet;

import java.io.FileNotFoundException;
import java.io.IOException;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.webharvest.definition.ScraperConfiguration;
import org.webharvest.runtime.Scraper;
import org.webharvest.runtime.variables.Variable;

import com.xiaoy.core.harest.conn.HttpConn;
import com.xiaoy.core.harest.util.JacksonMapperImpl;
import com.xiaoy.core.harest.util.Utils;

/**
 * Servlet implementation class GrabCpDataServlet
 */
public class GrabCpDataServlet extends HttpServlet {
	private static final long serialVersionUID = 1L;
       

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		doPost(request, response);
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {

		String diqu = request.getParameter("dq");
		String nowDate = request.getParameter("nd");	// 格式2015/06/09
		String result = "";
		
		if ("chongqing2".equals(diqu)) {
			result = chongqing2();
		}else if ("".equals(diqu)) {
			
		}else if ("".equals(diqu)) {
			
		}else if ("".equals(diqu)) {
			
		}else if ("".equals(diqu)) {
			
		}else if ("".equals(diqu)) {
			
		}else if ("".equals(diqu)) {
			
		}else if ("".equals(diqu)) {
			
		}else if ("".equals(diqu)) {
			
		}else if ("".equals(diqu)) {
			
		}else if ("".equals(diqu)) {
			
		}
		response.getWriter().write(result);
	}

	
	JacksonMapperImpl mapper = new JacksonMapperImpl();
	
	public static void main(String[] args) throws Exception {
		
		GrabCpDataServlet gc = new GrabCpDataServlet();
		gc.chongqing2();			//ok
//		gc.tianjin1 ();			
//		gc.xinqiang1();
//		gc.jiangxi2();				//ok
	}

	public String chongqing2() throws FileNotFoundException {
		ScraperConfiguration config = new ScraperConfiguration("src/chongqing/chongqing2.xml");
		Scraper scraper = new Scraper(config, "d:/wh/work/");
		scraper.setDebug(true);
		scraper.execute();
//		Variable r1 = scraper.getContext().getVar("targetPage");
//		System.out.println(r1.toString());
//		System.out.println("----------------");
		Variable catalog = scraper.getContext().getVar("catalog");
//		System.out.println(catalog);
//		System.out.println("===========");
		String s = catalog.toString().replaceAll("<result>", ",{").replaceAll("</result>", "}");
		System.out.println("["+s.substring(1)+"]");
		return "["+s.substring(1)+"]";
//		System.out.println(catalog.toList());
//		List list = catalog.toList();
//		for (Object s :list) {
//			Map<String,Object> m = (Map<String, Object>) s;
//			System.out.println("-->"+m.get("qs"));
//		}
		
//		Variable result = scraper.getContext().getVar("result");
//		System.out.println(result);
	}
	
	public void tianjin1 () throws Exception {
		
		/**
		 * 这个是通过ajax取值  http://www.tjflcpw.com/Handlers/WinMessageHandler.ashx
		 * 
		 * BasicCode 为号码 （是uncode 编码需要转换）
		 * TermCode  期数
		 */
		
		String url = "http://www.tjflcpw.com/Handlers/WinMessageHandler.ashx";
		String param = "currentPage=1&pageSize=13&playType=4&startTime=2015/06/01 00:00:00&endTime=2015/06/01 23:59:59";
		String datas = HttpConn.getData_post(url,param);
		System.out.println(datas);
		datas = new String(datas.getBytes("ISO-8859-1"), "GB18030");
		
		HashMap<String,Object> map = mapper.fromJson(datas, HashMap.class);
		
		List<Map<String,Object>> list1 = (List) map.get("WinNumList");
		for (Map<String,Object>m:list1) {
			
			String qs = Utils.objToString(m.get("TermCode"));
			String hm = Utils.objToString(m.get("BasicCode"));
			hm = hm.replaceAll("<span class='ballRed'>", "").replaceAll("<b>","").replaceAll("</b>"," ").replaceAll("</span>","");
			System.out.println("qs-->"+qs+"--hm-->"+hm);
		}
		
		
//		System.out.println(map);
	}
	
	public void xinqiang1 () throws FileNotFoundException {
		
		ScraperConfiguration config = new ScraperConfiguration("src/xinqiang/xinqiang1.xml");
		Scraper scraper = new Scraper(config, "d:/wh/work/");
		scraper.setDebug(true);
		scraper.execute();
		Variable r1 = scraper.getContext().getVar("targetPage");
		System.out.println(r1.toString());
	}
	
	public void jiangxi2 () throws Exception {
		/**
		 * http://baidu.lecai.com/lottery/draw/sorts/ajax_get_draw_data.php?lottery_type=202&date=2015-06-02
		 */
		String url = "http://baidu.lecai.com/lottery/draw/sorts/ajax_get_draw_data.php?lottery_type=202&date=2015-06-02";
		String datas = HttpConn.getData(url);
		HashMap<String,Object> map = mapper.fromJson(datas, HashMap.class);
		
//		System.out.println("1-->"+map.get("data"));
        Map<String,Object> map2 = (Map<String, Object>) map.get("data");
//        System.out.println("2-->"+map2.get("data"));
        List<Map<String,Object>> list1 = (List) map2.get("data");
        for (Map<String,Object> m : list1) {
//        	System.out.println("phase-->"+m.get("phase"));
        	String phase = Utils.objToString(m.get("phase"));//phase 期数
        	String time_draw = Utils.objToString(m.get("time_draw"));//time_draw时间
        	Map<String,Object> results = (Map<String, Object>) m.get("result");
        	List lsit = (List) results.get("result");
        	Map<String,Object> r = (Map<String, Object>) lsit.get(0);
        	String hm = Utils.objToString(r.get("data"));		//号码
        	System.out.println(time_draw+"--"+phase+"=="+hm);
        	
        }
	}
}
