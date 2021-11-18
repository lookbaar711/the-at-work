var pass= document.getElementById("passw").innerHTML;
var char = pass.length;
var password ="";
for (i=0;i<char;i++)
{
password += "*";
}
document.getElementById("passw").innerHTML = password;