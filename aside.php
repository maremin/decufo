<?php
  $sqlAside = 'SELECT * from categories'; 
?>
<aside>
    <ul>
        <?php foreach($database->selectAll($sqlAside) as $item): ?>
          <li><a href="tasks.php?id=<?=$item["id_category"]?>"><?=$item["category_name"]?></a><a href="report.php?id=<?= $item["id_category"] ?>">$</a></li>
        <?php endforeach; ?>
    </ul>
</aside>