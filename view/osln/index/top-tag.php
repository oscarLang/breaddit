<?php

 ?>
<div class="wrap-sidebar region-sidebar-right has-sidebar-right has-sidebar">
    <div class="floating-block">
        <h3>Trending subjects</h3>
        <ul>
            <?php foreach ($items as $tag): ?>
                <li>
                    <a href="tag/show/<?=$tag->id?>"><?=$tag->name?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</div>
