/**
 * Created by Mateen on 4/13/2016.
 */

function validatorForm(event) {
    var x = document.getElementById("validator");
  //  console.log(x);
    var y = document.getElementById("password");
   // console.log(y);
    var z = document.getElementById("password2");
    if (x.value == null) {
        event.preventDefault();
        document.getElementsByClassName("alert")[0].style.display ="block";
        document.getElementById("message").innerHTML ="Error invalid validator";
        return false;

    }
    else {
      //  document.getElementById("validatorform").submit();
    }
    if (y.value !== z.value)
    {
        event.preventDefault();
        document.getElementsByClassName("alert")[0].style.display ="block";
        document.getElementById("message").innerHTML ="Error! Passwords do not match!";
    return false;
    }
    else {
      //  document.getElementById("validatorform").submit();
    }
    if(y.value.length <8 || z.value.length <8)
    {
        event.preventDefault();
        document.getElementsByClassName("alert")[0].style.display ="block";
        document.getElementById("message").innerHTML ="Error! Passwords length is too short!";
        return false;
    }
    else {
     //   document.getElementById("validatorform").submit();

    }


}
