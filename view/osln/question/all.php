<?php
?>
<div class="floating-block">
    <h1>All questions</h1>
    <h2> <a href="question/create">Post a new question</a> </h2>
</div>
<?php foreach ($items as $item): ?>
    <div class="question-item floating-block">
        <small>
            Posted by <a href="user/show/<?=$item["author"]?>">
                <?=$item["author"]?>
            </a>
            on <?=$item["created"]?>
            Tags:
            <?php foreach ($item["tags"] as $key => $tag): ?>
                <a href="tag/show/<?=$key?>"><?=$tag?></a>
            <?php endforeach; ?>
        </small>
        <p>
            <a href="question/show/<?=$item["id"]?>"><?= $item["title"]?></a>
        </p>
    </div>
<?php endforeach; ?>
