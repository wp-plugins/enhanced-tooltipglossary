<style type="text/css">
    .subsubsub li+li:before {content:'| ';}
</style>
<ul class="subsubsub">
    <?php foreach ($submenus as $menu): ?>
    <li><a href="<?php echo $menu['link']; ?>" <?php echo ($menu['current'])?'class="current"':''; ?>><?php echo $menu['title']; ?></a></li>
    <?php endforeach; ?>
</ul>
<p class="clear"></p>