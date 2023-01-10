
<html>
     <link rel="stylesheet" href="style.css" type="text/css" />
     <head>
         <h1> Arts and pictures</h1>
     </head>
     <body>
         <table width="350" height="50" border="2">
    <tbody>
        <tr>
            <td width="154" height="184">
            
<div class="city">
    <div class="image-container">
        <?php
        $folder = 'images/';
        $files = scandir($folder);
        foreach($files as $file) {
            $file_path = $folder . '/' . $file;
            if(is_file($file_path)) {
                echo '<img src="' . $file_path . '" class="small-image" width="200" height="250">';
            }
        }
    ?>
    </div>
</div>
          
            </td>
        </tr>
    </tbody>
</table>
<td>
<h1>Some words from the creator</h1>
<p>If any one will like to add more photos in our website,please contact us. As we are still in developing phase it will take time to develop our webstie fully.
Hope you all can understanda</p> </td>
  <a href="index.html" text-align="center"> GO to Home </a>
     </body>
 </html>
