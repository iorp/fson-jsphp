   
  /* 
  Use as  
  let obj = FSON.parse("(a:1,b:2,c:[3,4],d:xxx,e:(a:1,b:2))");
  console.log(FSON.stringify(obj));
  */
  const FSON_OBJECT_O = "(";
  const FSON_OBJECT_C = ")";
  const FSON_ARRAY_O = "[";
  const FSON_ARRAY_C = "]";
  const FSON_ESCAPE_M = "~";
  const FSON_ELEMENT_SEPARATOR = ",";
  const FSON_KEY_SEPARATOR = ":";
  
  class FSON{
  
  static getType(value){
    value=value.trim(); 
  if(value.startsWith(FSON_OBJECT_O) && value.endsWith(FSON_OBJECT_C)){ 
  return 'object';
  }else if(value.startsWith(FSON_ARRAY_O) && value.endsWith(FSON_ARRAY_C)){ 
  return 'array';
  }else{	
  return 'string';
  }
  }
  
  
  static   parse(value,result=null){
  //console.log(2,value)
  
  try{
  if(!value)return null;
  let type = FSON.getType(value);
  
  let elements;
  switch(type){
  case 'array':
   value = value.substr(1,value.length-2)  
   result = result ? result : [];
    elements=getElements(value); for(let i =0;i<elements.length;i++){result.push(FSON.parse(elements[i]))	}
  break;
  case 'object':
   value = value.substr(1,value.length-2)  
   result = result ? result : {}; 
    elements=getElements(value);for(let i =0;i<elements.length;i++){let segments = getKeyValue(elements[i]);if(!segments){break;} result[segments.key]= FSON.parse(segments.value);}
  break;
  case 'string':  
   result= value.replace(new RegExp((FSON_ESCAPE_M=="\\")? "\\\\" : FSON_ESCAPE_M,"g"), '') //replace escape marks
  
  }
  }catch(e){
  console.log(e);
  console.log(value);
  }
  
  
  function getKeyValue(str){
  for(let i =0;i<str.length;i++){
  if(str[i]==FSON_KEY_SEPARATOR){
  
  let key=str.substr(0,i);
  let val=str.substr(i+1,str.length-key.length);
  return {
  key:key.trim(),
  value:  val.trim()
  }
  }
  }
  }
  
  function getElements(str){
  
  ///
  // GET SEPARATORS
  let bracket=0; // bracket level
  let square=0;  // square bracket level	
  
  let separators=[];
  
  for(let i=0;i<str.length;i++) { 
  
  // continue if escaped 
  if(i>0 && str[i-1]==='\\') continue;
  
  //if(str[i]==FSON_OBJECT_O && (i>0 && str[i-1]==='\\')) continue;
  
  
  if(str[i]==FSON_OBJECT_O) {bracket++;}
  else if(str[i]==FSON_OBJECT_C) {bracket--;}
  if(str[i]==FSON_ARRAY_O) {square++;}
  else if(str[i]==FSON_ARRAY_C) {square--;}
  else if(square==0 && bracket==0 && str[i]==FSON_ELEMENT_SEPARATOR){
  separators.push(i)
  }
  
  }
  
  if(bracket!=0) console.error("Unclosed brackets")
  if(square!=0) console.error("Unclosed squares")
  
  /// GET ELEMENTS
  let elements=[];
  let previous=0;
  for(let i =0;i<separators.length;i++){
  let length; 
  length=separators[i]-previous;
  if(length>0)elements.push(str.substr(previous,length));
  previous = separators[i]+1;
  }
  // the last 
  if( str.length-previous>0)elements.push(str.substr(previous,str.length-previous));
  
  return elements;
  
  
  
  
  } 
  
  return result;
  }
  
  static stringify(value){
  
  let  res=value;
  res= JSON.stringify(res).replace(new RegExp('"',"g"), '')
  
  
  // NO  res=res.replace("[null]","[]");
  res=res.replace(new RegExp('{',"g"),FSON_OBJECT_O)
  res=res.replace(new RegExp('}',"g"),FSON_OBJECT_C) 
  //res=res.replace(new RegExp('$',"g"),FSON_ESCAPE_M)
  res=res.replace(new RegExp(',',"g"),FSON_ELEMENT_SEPARATOR)
  res=res.replace(new RegExp('\\[',"g"),FSON_ARRAY_O)
  res=res.replace(new RegExp('\\]',"g"),FSON_ARRAY_C) 
  res=res.replace(new RegExp(':',"g"),FSON_KEY_SEPARATOR)
  return res;
  } 
  }
  
  //#endregion Fson 
  