# FSON (Flexible Syntax Object Notation) - PHP and JavaScript Library

## Introduction

FSON (Flexible Syntax Object Notation) is a versatile and human-readable data notation concept designed to provide an alternative to traditional JSON notation. The FSON concept allows developers to represent structured data in a more intuitive and flexible format, making it easier to work with complex data structures. This README introduces the FSON concept and the accompanying libraries for both PHP and JavaScript, focusing on the `encode` and `decode` functions in each language.

## FSON Concept

The FSON concept aims to simplify the way structured data is represented while remaining compatible with JSON. Here are the key components of the FSON concept:

- **Objects**: In FSON, objects are enclosed in parentheses `()` and key-value pairs are separated by colons `:`.

   **JSON Example:**
   ```json
   {
      "name": "John",
      "age": 30
   }
   ```

   **FSON Equivalent:**
   ```plaintext
   (name:John,age:30)
   ```

- **Arrays**: FSON uses square brackets `[]` to define arrays, similar to JSON.

   **JSON Example:**
   ```json
   [1, 2, 3]
   ```

   **FSON Equivalent:**
   ```plaintext
   [1,2,3]
   ```

- **Flexibility**: FSON allows you to mix data types within a single structure, simplifying the notation.

   **FSON Example:**
   ```plaintext
   (name:John,age:30,interests:[music,sports],location:(city:New York,state:NY))
   ```

   In this example, FSON enables you to combine strings, numbers, arrays, and nested objects within one structure.

## PHP Library

The PHP library for FSON provides two primary functions:

- `fson_encode($value)`: Encode a PHP object into FSON format.

   ```php
   $data = ['name' => 'John', 'age' => 30];
   $fson = fson_encode($data);
   ```

- `fson_decode($str)`: Decode an FSON string into a PHP object.

   ```php
   $fson = '(name:John,age:30)';
   $decodedData = fson_decode($fson);
   ```

Here is a test example   
```
<?php 

    include("FSON.php"); 
    $str= '(a:1,b:hi,c:[1,2],d:(e:5.65,f:hi,g:[3,4]))'; 
    echo $str.'<br>';
    echo json_encode(fson_decode($str),JSON_PRETTY_PRINT).'<br>';
    echo '<br>'; 
    $str= '(a:[0,1,2])'; 
    echo $str.'<br>';
    echo var_dump(fson_decode($str),JSON_PRETTY_PRINT).'<br>';
    echo json_encode(fson_decode($str),JSON_PRETTY_PRINT).'<br>';
    echo '<br>'; 
?>
```

## JavaScript Library

In JavaScript, the FSON concept can be applied directly using the following functions:

- `FSON.parse(value, result)`: Parse an FSON string and return a JavaScript object.

   ```javascript
   const fson = '(name:John,age:30)';
   const decodedData = FSON.parse(fson);
   ```

- `FSON.stringify(value)`: Convert a JavaScript object to an FSON string.

   ```javascript
   const obj = { name: 'John', age: 30 };
   const fson = FSON.stringify(obj);
   ```

## Version

This documentation pertains to the FSON concept and the accompanying PHP and JavaScript libraries, all of which are version 1.0.1.

## License

The PHP and JavaScript libraries for FSON are open-source and released under the [MIT License](LICENSE). You are free to use, modify, and extend these libraries to suit your needs.

FSON introduces a fresh approach to data notation, offering enhanced flexibility and readability, making it a valuable tool for simplifying structured data representati
