 


<?php  
 // FSON - Flexible Syntax Object Notation 1.0.1
	
 
 class FSON{
    const FSON_OBJECT_O = "(";
    const FSON_OBJECT_C = ")";
    const FSON_ARRAY_O = "[";
    const FSON_ARRAY_C = "]";
    const FSON_ESCAPE_M = "\\";
    const FSON_ELEMENT_SEPARATOR = ",";
    const FSON_KEY_SEPARATOR = ":";
public static function encode($obj,$flags=null){
  
    $res= json_encode($obj,$flags);

   $res=str_replace('"','',$res);

     
$res=str_replace('{',self::FSON_OBJECT_O,$res);
$res=str_replace('}',self::FSON_OBJECT_C,$res);
$res=str_replace(',',self::FSON_ELEMENT_SEPARATOR,$res);
$res=str_replace('[',self::FSON_ARRAY_O,$res);
$res=str_replace(']',self::FSON_ARRAY_C,$res);
$res=str_replace(':',self::FSON_KEY_SEPARATOR,$res); 
   return $res;
    } 
public static  function  decode($str,$result=null){

	
		try{
 
	$type =self::get_type($str);
	 
    
		$elements=[];
		switch($type){
		case 'array':
		 $str = substr($str,1,strlen($str)-2) ;
		 $result = !is_null($result) ? $result : (array)[];
		  $elements=self::get_elements($str);for($i =0;$i<count($elements);$i++){ $result[]=self::decode($elements[$i]);	}
		break;
		case 'object':
		 $str = substr($str,1,strlen($str)-2)  ;
		
		 $result = !is_null($result) ? $result : (array)[];  // objects become an assoc. array
		  $elements=self::get_elements($str);for($i =0;$i<count($elements);$i++){$segments = self::get_key_value($elements[$i]);if(!$segments){break;} 
		  $result[$segments['key']]=self::decode($segments['value']);
		}
		break;
		case 'string':    
			// replace escapes
			$result = str_replace((self::FSON_ESCAPE_M=="\\")? "\\\\" : self::FSON_ESCAPE_M, "", $str);// replace escape marks
		break;
		case 'integer': 
			$result = intval($str);
		break;
		case 'float': 
			$result = floatval($str);
		break;
			
			
	//		 echo "<br>".$result." ".gettype($result)." ".ctype_digit($result);
		  
	 
		}
	 
	return $result;


}catch(\Exception $e){
	return (array)['errors'=>[(object)['code'=>'fson_decode_error','exception'=>$e]]];
	 
	
} 

}
private static function  get_type($value){
   
		$value=trim($value); 
		if(str_starts_with($value,self::FSON_OBJECT_O) && str_ends_with($value,self::FSON_OBJECT_C)){ 
		return 'object';
		}else if(str_starts_with($value,self::FSON_ARRAY_O) && str_ends_with($value,self::FSON_ARRAY_C)){ 
		return 'array';
		}else{	

		if(is_numeric($value) && strpos($value, '.') !== false) return 'float';
		if(is_numeric($value) ) return 'integer';
				 
		return 'string';
		}
}
private static function get_key_value($str){
		for( $i =0;$i<strlen($str);$i++){
		if($str[$i]==self::FSON_KEY_SEPARATOR){
		
		$key=substr($str,0,$i);
		$val=substr($str,$i+1,strlen($str)-strlen($key));
		return (array)[
		 'key'=>trim($key),
		 'value'=> trim($val),
		];
		}
		}
}
private static function get_elements($str){
		
		 ///
		 // GET SEPARATORS
		$bracket=0; // $bracket level
		$square=0;  // $square $bracket level	
		 
		$separators=[];
		
		for($i=0;$i<strlen($str);$i++) { 
		
		// continue if escaped 
		if($i>0 && $str[$i-1]==='\\') continue;
		
		//if($str[i]==self::FSON_OBJECT_O && (i>0 && $str[i-1]==='\\')) continue;
		 
		  
		if($str[$i]==self::FSON_OBJECT_O) {$bracket++;}
		else if($str[$i]==self::FSON_OBJECT_C) {$bracket--;}
		if($str[$i]==self::FSON_ARRAY_O) {$square++;}
		else if($str[$i]==self::FSON_ARRAY_C) {$square--;}
		else if($square==0 && $bracket==0 && $str[$i]==self::FSON_ELEMENT_SEPARATOR){
		$separators[]=$i;
		}
		 
		}
		 
		 if($bracket!=0) return ("Unclosed brackets");
		 if($square!=0) return ("Unclosed squares");
		 
		 /// GET ELEMENTS
		$elements=[];
		$previous=0;
		for($i =0;$i<count($separators);$i++){
	
		$length=$separators[$i]-$previous;
		$elements[]=substr($str,$previous,$length);
		$previous = $separators[$i]+1;
		}
		// the last 
		$elements[]=substr($str,$previous,strlen($str)-$previous);
		return $elements;
		}
    }
 	
 
	function fson_decode($str){ return FSON::decode($str); }
	function fson_encode($value){  return FSON::encode($value); }


 

?>