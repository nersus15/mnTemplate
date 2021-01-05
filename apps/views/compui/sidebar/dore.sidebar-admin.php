<?php if(isset($sidebarConf) && !empty($sidebarConf)) extract($sidebarConf) ?>

<div class="sidebar">
    <div class="main-menu">
        <div class="scroll">
            <ul class="list-unstyled">
                <?php if(isset($menus)):
                        foreach($menus as $menu):
                ?>
                <li class="<?php echo isset($menu['active']) ? 'active': null ?>">
                    <a href="<?php echo $menu['link'] ?>">
                        <i class="<?php echo isset($menu['icon']) ? $menu['icon'] : null ?>"></i>
                        <span><?php echo $menu['text'] ?></span>
                    </a>
                </li>
                <?php endforeach; endif?>
            </ul>
        </div>
    </div>
    
    <?php if(isset($subMenus)): ?>
    <div class="sub-menu">
        <div class="scroll">
            <?php foreach($subMenus as $submenu):?>
            <ul style="margin-top: 10%;" class="list-unstyled" data-link="<?php echo $submenu['induk'] ?>">
                <?php foreach($submenu['menus'] as $menu): ?>
                <li class="submenu-item <?php echo isset($menu['active']) ? 'active': null ?>">
                    <a style="font-size: 17px;" href="<?php echo $menu['link'] ?>">
                        <i class="<?php echo isset($menu['icon']) ? $menu['icon'] : null ?>"></i><?php echo $menu['text'] ?>
                    </a>
                </li>
                <?php endforeach ?>
            </ul>
            <?php endforeach ?>
        </div>
    </div>
    <?php endif ?>
</div>