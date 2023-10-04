<?php
    //JSON, or "JavaScript Object Notation," is a lightweight data interchange format that is easy for humans to read and write, and easy for machines to parse and generate. JSON is often used for data exchange between a server and a web application, as well as for configuration files and data storage. Readable format, support data structure, doesn't contain excessive formatting or metadata, not tied to any particular programming language and can be used with virtually any language that supports text parsing. Data exchange format used in api request response.
    $data = array();
    echo json_encode($data, JSON_PRETTY_PRINT);

    //json_decode(): Now, we will get standard class object. Now we can access it like- $decodedData->name. But if we want array rather than object- json_decode($jsonData, true)

    //data.firstName, data['First Name']
    //If we encode json from object, we won't get private and static property or method, get only public.

    //Working with unicode data
    $unicodeData = [
        "country" => "বাংলাদেশ"
    ];
    $jsonData = json_encode($unicodeData); //value will be converted as unicode literal, rather than main word. If we want original format-
    echo json_encode($unicodeData, JSON_UNESCAPED_UNICODE);

    //Working with error
    $json = '{"country": "বাংলাদেশ"}'; //key value must be double code, if we take single code - we will get error.
    if(json_last_error_msg()){};
?>