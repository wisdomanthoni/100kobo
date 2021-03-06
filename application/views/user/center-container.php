			<div class="center-container col-lg-6 col-md-6 col-xs-12">
				<?php if($this->session->flashdata('message_f')) { ?>
				<div class="alert alert-danger alert-dismissible" role="alert">
			  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  		<?php echo $this->session->flashdata('message_f'); ?>
			  	</div>
			  	<?php } elseif($this->session->flashdata('message_i')) { ?>
				<div class="alert alert-info alert-dismissible" role="alert">
			  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  		<?php echo $this->session->flashdata('message_i'); ?>
			  	</div>
			  	<?php } elseif ($this->session->flashdata('message_s')) { ?>
			  	<div class="alert alert-success alert-dismissible" role="alert">
			  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  		<?php echo $this->session->flashdata('message_s'); ?>
			  	</div>
			  	<?php } ?>

				<div class="row link">
                    <button class="col-xs-6 selected" id="btn-posts">Posts</button>
                    <button class="col-xs-6" id="btn-gallery">Gallery</button>
              	</div>

				<?php
				if ($posts) :
					foreach ($posts as $post) :
						if (!$g_access && strlen($post->image) > 0) : else :
				?>
				<div class="row post <?php if (strlen($post->image) == 0) echo 'no-image'; else echo 'image'; ?>" id="<?= $post->username.'-'.$post->id ?>">
					<div class="left-post">
						<img src="<?php if ($post->profile_image) echo base_url().'images/'.$post->profile_image; else echo base_url().'assets/img/no-profile.png' ?>" class="profile" />
					</div>
					<div class="right-post">
						<div class="line">
							<a href="<?= base_url()."user/".$post->username ?>"><h5><?= $post->first_name ?> <?= $post->surname ?></h5></a>
							<a href="<?= base_url().'post/p/'.$post->id ?>"><span class="time-ago"><?= $post->time_ago ?></span></a>
							<span class="hidden" id="mrk"><?= $post->id ?></span>
						</div>
						<div class="line">
							<p class="post_text">
	                        <?php 
	                        echo '<span class="line-text">'.$post->text.'</span>';
	                        if (strlen($post->image) > 1) {
	                              echo '<a href="'.base_url().'images/'.$post->image./*'" data-title="'.$post->text.'*/'" data-lightbox="'.$post->id.'"><img src="'.base_url().'images/'.$post->image.'" class="post_image" /></a>';
	                        }
	                        ?>
	                        </p>
						</div>
					</div>
					<div class="bottom-post">
						<button class="anchor" data-toggle="collapse" data-target="#sub-<?= $post->id ?>"><span class="glyphicon glyphicon-comment"></span><?php if($post->comments > 0) echo '<span class="count-comments">'.$post->comments.'</span>'; ?></button>
						<button class="anchor" data-toggle="modal" data-target="#modal-<?php if ($access > 0) echo $post->id; else echo 'login' ?>"><span class="glyphicon glyphicon-pencil"></span></button>
						<?php if (isset($this->session->all_userdata()['user_id']) && $post->user_id == $this->session->all_userdata()['user_id']) : ?>
							<a href="<?= base_url().'delete/post/'.$post->id ?>" class="btn btn-xs btn-danger btn-m" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
							<?php if (strlen($post->image) > 1 && $post->billboard == 0) : ?>
	    	                    <a href="<?= base_url().'edit/add_billboard/'.$post->id ?>" class="btn btn-xs btn-default btn-m">Add to billboard</a>
	    	                <?php elseif (strlen($post->image) > 1 && $post->billboard == 1) : ?>
	    	                    <a href="<?= base_url().'edit/remove_billboard/'.$post->id ?>" class="btn btn-xs btn-danger btn-m">Remove from billboard</a>
		                    <?php endif; ?>
	                        <button type="button" class="btn btn-xs btn-default btn-m" data-toggle="modal" data-target="#modal-edit">Edit</button>
	                    <?php endif; ?>
	                    <!-- <span class="text-muted align-right number-n">N<?= number_format($post->comment_worth, 2) ?></span> -->
					</div>
	      		</div><!-- /.post -->

	      		<?php if (isset($post->sub_post)) : ?>
	      		<div class="sub-posts collapse" id="sub-<?= $post->id ?>">
	      			<?php foreach ($post->sub_post as $sub_post) : ?>
	      			<div class="row sub-post">
						<div class="left-post">
							<img src="<?php if ($sub_post->profile_image) echo base_url().'images/'.$sub_post->profile_image; else echo base_url().'assets/img/no-profile.png' ?>" class="profile" />
						</div>
						<div class="right-post">
							<div class="line">
								<a href="<?= base_url()."user/".$sub_post->username ?>"><h5><?= $sub_post->first_name ?> <?= $sub_post->surname ?></h5></a>
								<a href="<?= base_url().'post/p/'.$post->id ?>"><span class="time-ago"><?= $sub_post->time_ago ?></span></a>
								<span class="hidden"><?= $sub_post->id ?></span>
							</div>
							<div class="line">
								<p class="post_text">
	                            <?php 
	                            echo '<span class="line-text">'.$sub_post->text.'</span>';
	                            if (strlen($sub_post->image) > 1) {
	                                  echo '<a href="'.base_url().'images/'.$sub_post->image./*'" data-title="'.$sub_post->text.'*/'" data-lightbox="'.$sub_post->id.'"><img src="'.base_url().'images/'.$sub_post->image.'" class="post_image" /></a>';
	                            }
	                            ?>
	                            </p>
							</div>
						</div>
						<?php if (isset($this->session->all_userdata()['user_id']) && $sub_post->user_id == $this->session->all_userdata()['user_id']) : ?>
	                  		<div class="bottom-post">
	                            <a href="<?= base_url().'delete/post/'.$sub_post->id ?>" class="btn btn-xs btn-danger btn-m" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
	                            <button type="button" class="btn btn-xs btn-default btn-m" data-toggle="modal" data-target="#modal-edit">Edit</button>
	                  		</div>
	                  	<?php endif; ?>
					</div><!-- /.sub-post -->
					<?php endforeach; ?>
	      		</div><!-- /.sub-posts -->
	      		<?php endif; ?>

	      		<div id="modal-<?= $post->id ?>" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<?php
							$args = array('id' => $post->id);
							echo form_open_multipart('post', $args);
							?>
						  	<div class="modal-header">
						    	<button type="button" class="close" data-dismiss="modal">&times;</button>
						    	<h4 class="modal-title">Write a comment to <?= $post->surname ?></h4>
						  	</div>
						  	<div class="modal-body post">
						    	<div class="line">
									<h5>Message</h5>
									<span id="textarea_feedback" class="counter align-right"></span>
									<textarea name="message" id="textarea" class="form-control" maxlength="160" placeholder="Message..."></textarea>
								</div>
								<div class="line push-top-2 push-bottom-1">
									<h5>Upload image (optional)</h5>
									<input type="file" name="file" size="20" />
								</div>
						  	</div>
						  	<div class="modal-footer">
						  		<?php
						  		echo form_hidden('reply_id', $post->id);
						  		$args = array('class' => 'btn btn-blue align-right');
						  		echo form_submit('submit', 'Post', $args);
						  		?>
						  	</div>
						  	<?= form_close() ?>
						</div>
					</div>
				</div>
	      		<?php
	      				endif;
	      			endforeach;
	      		endif;

	      		if ($p_empty) :
              	?>
              	<div class="row post no-image">
                    <div class="text-center">Nothing posted yet.</div>
              	</div><!-- /.gallery -->
              	<?php
              	endif;
              	
              	if ($g_empty) :
              	?>
              	<div class="row post image">
              		<div class="text-center">Gallery is empty.</div>
              	</div>
              	<?php
              	elseif (!$g_access) :
              	?>
              	<div class="row post image">
                    <div class="text-center">Gallery is locked.</div>
                    <div class="text-center push-top-2"><a href="<?= base_url().'settings/unlock_gallery/'.$g_user_id ?>" class="btn btn-primary">Unlock it</a> for N<?= $g_price ?></div>
              	</div><!-- /.gallery -->
              	<?php 
              	endif;
              	?>
            </div><!-- /.center -->