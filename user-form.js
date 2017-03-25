
function user(event) {
    var x = document.getElementById("name");
    if (x.value == "") {
        event.preventDefault();
        document.getElementsByClassName("alert")[0].style.display ="block";
        document.getElementById("message").innerHTML ="Error! you need to need in a name!";
        return false;

    }
    else {
        //  document.getElementById("validatorform").submit();
    }



}
function cancel(event)
{
    event.preventDefault();
   return window.location = "index.php";
}
