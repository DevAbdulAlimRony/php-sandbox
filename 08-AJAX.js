
 //Ajax, which stands for "Asynchronous JavaScript and XML," is a web development technique that allows you to send and receive data from a web server asynchronously without having to reload the entire web page. Ajax plays a crucial role in modern web applications for several reasons: Improve User Experience, Reduce Server Load, Real time Updates, Single Page Application, Cross Origin Request etc.

 //Sending Get Request
 function sendData(){
    let params = {
        "key1": "Value 1",
        "key2": "Value 2",
    }
    let queryString = formatParams(params);
    let xhr = new XMLHttpRequest();
    //xhr.open("GET", "data.php?hello=takaDe", true); //true means asynchronous, data.php is a file.
    xhr.open("GET", "data.php?"+queryString, true);

    //If POST and PUT request, Not For GET and DELETE
    // xhr.open("POST", "data.php?", true);
    xhr.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded"
    );
    //

    xhr.onreadystatechange = function(){
        if(this.readyState===4 && this.status===200){
            //4 means request completed, 200 means success valid response
            console.log(this.responseText);
            var response = JSOn.parse(this.responseText) //automatically parse if valid json
        }
        xhr.send();

        //If post request- pass query string: xhr.send($queryString);
    }
 }

 //Building Query Strings
 function formatParams(data){
    // return Object.keys(data).map(function(key){
    //     return key + "=" +encodeURIComponent(data[key])
    // }).join('&');
    //Alternative for modern browsers
    return new URLSearchParams(data).toString();
 }

//Calling Ajax using Jquery
function sendDataUsingJquery(){
    let params = {
        "key1": "Value 1",
        "key2": "Value 2",
    }
    $.ajax({
        "method": "POST",
        "url": "data.php",
        "data": params.done
    }).done(function(response){
        $("#result").html(response);
    });

    //quick alternative way
    $.post("data.php", params, function(response){
        $("#result").html(response);
    })
}

