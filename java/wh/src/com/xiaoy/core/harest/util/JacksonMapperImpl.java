package com.xiaoy.core.harest.util;

import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;



import com.fasterxml.jackson.annotation.JsonInclude.Include;
import com.fasterxml.jackson.core.JsonParseException;
import com.fasterxml.jackson.core.type.TypeReference;
import com.fasterxml.jackson.databind.DeserializationFeature;
import com.fasterxml.jackson.databind.JavaType;
import com.fasterxml.jackson.databind.JsonMappingException;
import com.fasterxml.jackson.databind.ObjectMapper;



/**
 * 简单封装Jackson，实现JSON String<->Java Object的Mapper.
 * 
 * 封装不同的输出风格, 使用不同的builder函数创建实例.
 * 
 * @author chentianyi
 */
public class JacksonMapperImpl {

//	private Logger logger = LoggerFactory.getLogger(getClass());
	private ObjectMapper mapper;

	public JacksonMapperImpl () {
		mapper = new ObjectMapper();
	}
	
	public JacksonMapperImpl(Include include) {
		mapper = new ObjectMapper();
		// 设置输出时包含属性的风格
		if (include != null) {
			mapper.setSerializationInclusion(include);
		}
		// 设置输入时忽略在JSON字符串中存在但Java对象实际没有的属性
		mapper.disable(DeserializationFeature.FAIL_ON_UNKNOWN_PROPERTIES);
	}
	
	/**
	 * 创建只输出非Null且非Empty(如List.isEmpty)的属性到Json字符串的Mapper,建议在外部接口中使用.
	 */
	public static JacksonMapperImpl nonEmptyMapper() {
		return new JacksonMapperImpl(Include.NON_EMPTY);
	}

	/**
	 * 创建只输出初始值被改变的属性到Json字符串的Mapper, 最节约的存储方式，建议在内部接口中使用。
	 */
	public static JacksonMapperImpl nonDefaultMapper() {
		return new JacksonMapperImpl(Include.NON_DEFAULT);
	}	
	
	public String toJson(Object object) {

		try {
			return mapper.writeValueAsString(object);
		} catch (IOException e) {
//			logger.warn("write to json string error:" + object, e);
			return null;
		}
	}

	/**
	 * 反序列化POJO或简单Collection如List<String>.
	 * 
	 * 如果JSON字符串为Null或"null"字符串, 返回Null. 如果JSON字符串为"[]", 返回空集合.
	 * 
	 * 如需反序列化复杂Collection如List<MyBean>, 请使用fromJson(String,JavaType)
	 * 
	 * @see #fromJson(String, JavaType)
	 */
//	@Override
	public <X> X fromJson(String jsonString, Class<X> clazz) {

		if (null==jsonString||"".equals(jsonString)) {
			return null;
		}

		try {
			return mapper.readValue(jsonString, clazz);
		} catch (IOException e) {
//			logger.warn("parse json string error:" + jsonString, e);
			return null;
		}
	}
	
	
//	@Override
	public <X> List<X> json2List(String jsonString, Class<X> pojoClass) {
		
		JavaType beanListType = createCollectionType(List.class, pojoClass);
		return fromJson(jsonString, beanListType);
	}
	
//	@Override
	public <X> List<X> json2Map(String jsonString, Class<X> pojoClass) {
		JavaType beanListType = createCollectionType(List.class, String.class,pojoClass);
		return fromJson(jsonString, beanListType);
	}
	
	public <X> X json2Map2(String jsonString, Class<X> pojoClass) {
//		JavaType beanListType = createCollectionType(List.class, String.class,pojoClass);
		
		;
		
		JavaType type = mapper.getTypeFactory().constructParametricType(pojoClass,String.class, HashMap.class);
		
//		return fromJson(jsonString,  new TypeReference<Map<String, Object>>());
		try {
			return (X)mapper.readValue(jsonString, new TypeReference<Map<String, List>>(){});
		} catch (JsonParseException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (JsonMappingException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return null;
	}
	

	
	//---------------------------------------------------------------
	
	/**
	 * 反序列化复杂Collection如List<Bean>, 先使用函數createCollectionType构造类型,然后调用本函数.
	 * 
	 * @see #createCollectionType(Class, Class...)
	 */
	public <T> T fromJson(String jsonString, JavaType javaType) {
		if (null==jsonString||"".equals(jsonString)) {
			return null;
		}

		try {
			return (T) mapper.readValue(jsonString, javaType);
		} catch (IOException e) {
//			logger.warn("parse json string error:" + jsonString, e);
			return null;
		}
	}
	
	/**
	 * 構造泛型的Collection Type如:
	 * ArrayList<MyBean>, 则调用constructCollectionType(ArrayList.class,MyBean.class)
	 * HashMap<String,MyBean>, 则调用(HashMap.class,String.class, MyBean.class)
	 */
	public JavaType createCollectionType(Class<?> collectionClass, Class<?>... elementClasses) {
		return mapper.getTypeFactory().constructParametricType(collectionClass, elementClasses);
	}


	
}
