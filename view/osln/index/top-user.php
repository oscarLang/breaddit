<div class="wrap-sidebar region-sidebar-right has-sidebar-right has-sidebar">
    <div class="floating-block">
        <h3>Top users</h3>
        <ul>
            <?php foreach ($items as $user): ?>
                <li>
                    <a href="user/show/<?=$user->acronym?>"><?=$user->acronym?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
