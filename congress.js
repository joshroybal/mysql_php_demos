function decapitalizeFirstLetter(string) {
    return string.charAt(0).toLowerCase() + string.slice(1);
}

function AddImage()
{  
   var stylesheet = document.getElementById("styleinfo");
   stylesheet.innerHTML = "<link rel='stylesheet' media='all' type='text/css' href='/includes/style.css'/>";

   var table = document.getElementById("myTable");
   table.classList.add("gradienttable-left-justify");
   
   var statecol = -1;

   for (var j = 0, col; col = table.rows[0].cells[j]; j++) {
      var str = col.innerHTML;
      if (str === 'state') statecol = j;
   }
   document.getElementById('statecol').innerHTML = statecol;


   for (var i = 1, row; row = table.rows[i]; i++) {      
      // iterate through rows
      // rows would be accessed using the "row" variable assigned in the for loop
      for (var j = 0, col; col = row.cells[j]; j++) {
         //iterate through columns
         //columns would be accessed using the "col" variable assigned in the for loop
         var str = col.innerHTML;
         // Democrat or Republican logo replaces string
         if (str === 'Democratic') col.innerHTML = "<img src='parties/democratic.jpg' alt='Democratic'> ";
         if (str === 'Republican') col.innerHTML = "<img src='parties/republican.jpg' alt='Republican'> ";
         
         // highlight hypertext link
         if (str.indexOf("http://") == 0 || str.indexOf("https://") == 0)
            col.innerHTML = "<a href=" + str + ">" + str + "</a>";

         // see if we can pull the flag
         if (j == statecol) {
            var str = col.innerHTML;
            var flagstr = str.replace(/\s+/g, '-').toLowerCase() + ".jpg";
            flagstr = "<img src='/flags/" + flagstr + "' height='64' alt='" + str + "'> " + str;
            col.innerHTML = flagstr;
         }
      }
   }
}
window.onload = AddImage;
