<?php 

$user_data = file("../get-panel/info-panel.txt", FILE_IGNORE_NEW_LINES);           
foreach ($user_data as $line) {
    list($id_user,$user_ip,$timestamp,$user_agent,$link_panel,$remove_ID,$block_user) = explode(",", $line);
    echo "<tr class='information-user'>";
    echo "<td>#$id_user</td>";
    echo "<td>$user_ip</td>";
    echo "<td>$timestamp</td>";
    echo "<td>$user_agent</td>";
    echo "<td><a href='$link_panel' class='button-table' target='_blank'><i class='fa-solid fa-up-right-from-square'></i>View_Panel</a></td>";
    echo "<td><form action='../actions/remove_id.php' method='post'><input type='hidden' name='user_id' value='$id_user'><button type='submit' class='button-table' name='remove_id' value='$remove_ID'><i class='fa-solid fa-trash-can'></i> Remove</button></form></td>";
    echo "<td><form action='../actions/block_user.php' method='post'><input type='hidden' name='user_id' value='$id_user'><button type='submit' class='button-table' name='block_user' value='$block_user'><i class='fa-solid fa-user-minus'></i> Block</button></form></td>";
    echo "</tr>";
}


?>