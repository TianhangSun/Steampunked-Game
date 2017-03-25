/**
 * Created by Mateen on 4/14/2016.
 */

function errorCheckerAdd(event)
{
    $x = document.getElementsByName('id');
    for(var i = 0; i < $x.length; i++){
        if($x[i].checked){
            event.preventDefault();
            document.getElementsByClassName("alert")[0].style.display ="block";
            document.getElementById("message").innerHTML ="Error! You need shouldn't a user!";
        }
        else
        {
            {

            }
        }
    }

}
function errorCheckerDelete(event)
{
    $x = document.getElementsByName('id');
    for(var i = 0; i < $x.length; i++){
        if($x[i].checked){
        }
        else
        {
            {
                event.preventDefault();
                document.getElementsByClassName("alert")[0].style.display ="block";
                document.getElementById("message").innerHTML ="Error! You need a user!";
            }
        }
    }

}
function RemoveErrorMessage()
{
    document.getElementsByClassName("alert")[0].style.display ="none";

}

