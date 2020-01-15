<?php


 ?>
<div class="region-main has-sidebar-right has-sidebar">
    <div class="floating-block">
        <h1>We love bread</h1>
        <p>
            Welcome to Breaddit, a forum for discussing everything from homemade bread to
            that delicious baguette that you had for lunch yesterday!
            We hope to give all users a pleasant stay at our site.
            <a href="/user/signup">Signup</a> to start contributing with your own posts about bread.
        </p>
    </div>
    <h2 class="floating-block">Trending</h2>
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
</div>
