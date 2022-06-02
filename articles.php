<?php
/**
* 归档
*
* @package custom
*/

$this->need('header.php'); ?>
<nav class="nav">
<ul class="flat">
<li class="active"><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
    <?php $this->widget('Widget_Contents_Page_List')
               ->parse('<li class="active"><a href="{permalink}">{title}</a></li>'); ?></ul>
                </nav>
            </div>
        <h1 class="post-title" itemprop="name headline">
            <?php $this->title() ?>
        </h1>
    <div class="post-content" itemprop="articleBody">
            <ul>
                <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y 年 m 月')->to($archives); ?>
                <?php while ($archives->next()) : ?>
                
                    <li class="archives-item">
                        <div class="archives-item-content">
                            <h4 class="archives-item-title"><a href="<?php $archives->permalink(); ?>"><?php $archives->date(); ?></a></h4>
                            <?php
                            $year = $archives->year;
                            $month = $archives->month;
                            $nextYear = $month == 12 ? $year + 1 : $year;
                            $nextMonth = $month == 12 ? 1 : $month + 1;
                            $contents = $this->db->fetchAll($this->select()
                                ->where('table.contents.status = ?', 'publish')
                                ->where('table.contents.created >= ?', strtotime("$year-$month"))
                                ->where('table.contents.created < ?', strtotime("$nextYear-$nextMonth"))
                                ->where('table.contents.type = ?', 'post')
                                ->order('table.contents.created', Typecho_Db::SORT_DESC), array($this, 'push'));
                            //var_dump($contents);
                            foreach ($contents as $content) {
                                echo "<p><span class='archives-time'>$content[month]-$content[day]</span> <a href='$content[permalink]' title='$content[title]'>$content[title]</a></p>";
                            }
                            ?>
    
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
<?php $this->need('footer.php'); ?>
</div>
</body>
</html>

