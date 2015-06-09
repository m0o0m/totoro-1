package com.xiaoy.core.harest.conn;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;


public class HttpConn {
	
	public static String getData (String _url) throws Exception {
		
		 URL url = new URL(_url);
         HttpURLConnection urlcon = (HttpURLConnection)url.openConnection();
         
         urlcon.connect();         //获取连接
         InputStream is = urlcon.getInputStream();
         BufferedReader buffer = new BufferedReader(new InputStreamReader(is));
         StringBuffer bs = new StringBuffer();
         String l = null;
         while((l=buffer.readLine())!=null){
             bs.append(l).append("/n");
         }
         return bs.toString();
	}
	   public static String getData_post(String path, String params) throws Exception{
	        URL url = new URL(path);
	        HttpURLConnection urlcon = (HttpURLConnection) url.openConnection();
	        urlcon.setRequestMethod("POST");// 提交模式
	        // conn.setConnectTimeout(10000);//连接超时 单位毫秒
	        // conn.setReadTimeout(2000);//读取超时 单位毫秒
	        urlcon.setDoOutput(true);// 是否输入参数
	        byte[] bypes = params.toString().getBytes();
	        urlcon.getOutputStream().write(bypes);// 输入参数
	        
	        InputStream is = urlcon.getInputStream();
	        BufferedReader buffer = new BufferedReader(new InputStreamReader(is));
	         StringBuffer bs = new StringBuffer();
	         String l = null;
	         while((l=buffer.readLine())!=null){
	             bs.append(l).append("/n");
	         }
	         return bs.toString();
	    }

}
