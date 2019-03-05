<?php
echo "檔案名稱: " . $_FILES["pfile"]["name"]."<br/>";
echo "檔案類型: " . $_FILES["pfile"]["type"]."<br/>";
echo "檔案大小: " . ($_FILES["pfile"]["size"] / 1024)." Kb<br />";
echo "暫存名稱: " . $_FILES["pfile"]["tmp_name"];
move_uploaded_file($_FILES["pfile"]["tmp_name"],"/var/www/picture/".$_FILES["pfile"]["name"]);

?>