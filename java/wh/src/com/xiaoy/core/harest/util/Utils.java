package com.xiaoy.core.harest.util;

import java.math.BigInteger;

public class Utils {
	
	public static String objToString (Object o) {
		if (o!=null) {
			return o.toString();
		}
		return "";
	}

	public static int objToInt (Object o) {
		if (o!=null) {
			try{
				return Integer.parseInt(o.toString());
			}catch(Exception e){
				return -1;
			}
		}
		return -1;
	}
	
	public static BigInteger objToBigInteger (Object o) {
		
		if (o!=null) {
			return  new BigInteger(o.toString());
		}
		return new BigInteger("0");
	}
	
}
