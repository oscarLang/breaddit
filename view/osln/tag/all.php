<?php
var_dump($items);

 ?>

 <?php
 ?>
 <h1>All tags</h1>
<ul>
    <?php foreach ($items as $tag): ?>
        <li>
            <a href="tag/show/<?=$tag->id?>"><?=$tag->name?></a>
        </li>
    <?php endforeach; ?>
</ul>
