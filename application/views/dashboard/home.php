<div class="list-group">
    <?php
    foreach($menu as $item) {
        $icon = $item["icon"];
        $label = $item["label"];
        $url = $item["url"];
        
        echo "<a class=\"list-group-item\" href=\"$url\"";
        if(isset($item["target"])) {
            echo " target='" . $item["target"] . "'";
        }
        echo ">"
                . "<i class=\"fa fa-5x fa-$icon fa-fw\" aria-hidden=\"true\"></i>"
                . "<br />$label</a>";
        
    }
    
    if(count($clients)>0) {
    ?>
        <div>&nbsp;</div>
        <h2>My Clients</h2>
        <table class="dataTable">
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($clients as $client) {
                    $company = $client["company"];
                    $contact = $client["contact"];
                    $status = $client["status"];
                    $id = $client["id"];
                    echo "<tr>"
                    . "<td>$company</td>"
                    . "<td>$contact</td>"
                    . "<td>$status</td>"
                    . "<td>" . anchor("/Clients/details/$id","View") . "</td>"
                    . "</tr>";
                }
                ?>
            </tbody>
        </table>     
    <?php
    }
    ?>
</div>