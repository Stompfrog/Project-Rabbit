<div class="page-header">
        <h1>Artists</h1>
</div>
<div class="row">
        <div class="span10">
                <h2>What are artists?</h2>
                <hr />
                <p><b>Artists are...</b> Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet 
                <ul>
                   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
                   <li>Aliquam tincidunt mauris eu risus.</li>
                   <li>Vestibulum auctor dapibus neque.</li>
                </ul>
                <?php if (!$this->tank_auth->is_logged_in()) { ?>
                        <a class="btn danger" href="<?php echo base_url(); ?>index.php/auth/register">Sign up as an artist!</a>
                <?php } 
                
                
                echo 'pagina' . $pagination;
                
                
                ?>
           <hr />
                <h2>Latest Artists</h2>
                <hr />
				<ul class="search-results">
					<?php foreach($artists as $row): ?>
					    <li>
							<ul class="media-grid">
								<li><a href="<?php echo base_url(); ?>index.php/artists/get_user"><img src="http://www.gravatar.com/avatar/<?= md5( strtolower( trim( $row->email ) ) )?>?s=60" class="thumbnail" /></a></li>
							</ul>
							<h3><a href="<?php echo base_url(); ?>index.php/artists/<?php echo $row->user_id; ?>"><?php echo $row->first_name; ?> <?php echo $row->last_name; ?></a></h3>
							<p><?php echo $row->about_me; ?></p>
							
							<?php
							foreach ($row->interests as $interest) {
							    echo '<span class="label important">' . $interest . '</span> ';
							}?>
							<a class="pull-right" href="<?php echo base_url(); ?>index.php/artists/<?php echo $row->user_id; ?>">View profile &raquo;</a>
					    </li>
					<?php endforeach; ?>
				</ul>

                <?php if (isset($pagination)) echo $pagination; ?>
                
				<?php
				if (isset($page)) {
				    echo $page;
				}
				?>
                
        </div>
        <div class="span4">
                <h3>Search artists</h3>
                <input class="span3" type="text" placeholder="Search..." /> <a href="<?= base_url(); ?>index.php/search/" class="btn primary" />Go</a>
                <br /><br />
                <h3>Latest Artists</h3>
                <ul class="events unstyled">
                        <?php foreach($latest as $row): ?>
                                <li>
                                        <a href="<?php echo base_url(); ?>index.php/artists/<?php echo $row->user_id; ?>"><?php echo $row->first_name; ?> <?php echo $row->last_name; ?></a>
                                </li>
                        <?php endforeach; ?>
                </ul>
        </div>
</div>