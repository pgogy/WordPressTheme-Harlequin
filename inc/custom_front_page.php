<?php

class popuppigeonCustomFrontPage extends WP_Customize_Control
{
    public $type = 'textarea';

    public function __construct($manager, $id, $args = array())
    {
        parent::__construct($manager, $id, $args);
    }

    public function enqueue()
    {
        wp_enqueue_style( 'popuppigeon-customizer-draggable', get_template_directory_uri() . '/css/customizer/customizer.css' );
        wp_enqueue_script("jquery-ui-sortable", array('jquery'));
    }
	
    public function render_content()
    {
	
	    ?><input type="text" value="<?php echo $this->value(); ?>" <?php $this->link(); ?> /><?PHP
		$data = $this->value();
		$ids = explode(" ", trim($data));
		$ids = array_filter($ids);
	
		?>
		<div class="scroll"><ul id='pppsortable'><?PHP
	
		foreach ( $ids as $post) {
			$post = get_post($post);
			echo "<li page_id='" . $post->ID . "'>Title : " . $post->post_title . "<b class='pppright ppptop'>Top</b>  <b class='pppright pppend'>Bottom</b></li>";
		}
		
		$query_posts_args = array( 'posts_per_page' => -1,  'post_type' => 'post', 'post_status' => 'publish' );	

		$query_posts = get_posts( $query_posts_args );
		
		foreach ( $query_posts as $post) {
			if(!in_array($post->ID, $ids)){
				echo "<li page_id='" . $post->ID . "'>Title : " . $post->post_title . " <b class='pppright ppptop'>Jump</b>  <b class='pppright pppend'>Bottom</b></li>";
			}
		}
		
		$query_posts_args = array( 'posts_per_page' => -1,  'post_type' => 'post', 'post_status' => 'publish' );	
		
		$query_posts = get_posts( $query_posts_args );
		
		foreach ( $query_posts as $post) {
			if(!in_array($post->ID, $ids)){
				echo "<li page_id='" . $post->ID . "'>Title : " . $post->post_title . " <b class='pppright ppptop'>Jump</b>  <b class='pppright pppend'>Bottom</b></li>";
			}
		}
		?></ul></div>
			<script type="text/javascript">
				jQuery( ".ppptop" )
					.each(
						function(index, value){
							jQuery(value)
								.on("click", function(event){
										list = "";
										jQuery(event.currentTarget)
											.parent()
											.parent()
											.prepend(jQuery(event.currentTarget).parent());
										jQuery( "#pppsortable" )
											.children()
											.each(
												function(index, value){
													list = list + jQuery(value).attr("page_id") + " ";
												}
											);
										jQuery("#customize-control-front_page_posts_list")
											.children()
											.first()
											.val(list);
										jQuery("#customize-control-front_page_posts_list")
											.children()
											.first()
											.trigger("keyup");
											
									}
								);
						}
					);
				jQuery( ".pppend" )
					.each(
						function(index, value){
							jQuery(value)
								.on("click", function(event){
										list = "";
										jQuery(event.currentTarget)
											.parent()
											.parent()
											.append(jQuery(event.currentTarget).parent());
										jQuery( "#pppsortable" )
											.children()
											.each(
												function(index, value){
													list = list + jQuery(value).attr("page_id") + " ";
												}
											);
										jQuery("#customize-control-front_page_posts_list")
											.children()
											.first()
											.val(list);
										jQuery("#customize-control-front_page_posts_list")
											.children()
											.first()
											.trigger("keyup");
											
									}
								);
						}
					);	
				jQuery( "#pppsortable" ).sortable();
				jQuery( "#pppsortable" ).disableSelection();	
				jQuery( "#pppsortable" )
					.droppable({
					  hoverClass: "sortable-ui-state-hover",
					  drop: function( event, ui ) {
							list = jQuery(ui.draggable[0]).attr("page_id") + " ";
							jQuery( "#pppsortable" )
								.children()
								.each(
									function(index, value){
										if(index!=0){
											list = list + jQuery(value).attr("page_id") + " ";
										}
									}
								);
							jQuery("#customize-control-front_page_posts_list")
								.children()
								.first()
								.val(list);
							jQuery("#customize-control-front_page_posts_list")
								.children()
								.first()
								.trigger("keyup");
								
						}
					}
				);
			</script>		
		<?PHP
    }
	
    protected function theTitle()
    {
        ?>
        <label>
            <span class="customize-control-title">
                <?php echo esc_html($this->label); ?>
            </span>
        </label>
        <?php
    }
	
    protected function getImages()
    {
        $options = $this->value();
        if (!isset($options['image_sources'])) {
            return '';
        }
        return $options['image_sources'];
    }
	
    public function theButtons()
    {
        ?>
        <div>
            <input type="hidden" value="<?php echo $this->value(); ?>" <?php $this->link(); ?> class="multi-images-control-input"/>
            <a href="#" class="button-secondary multi-images-upload">
                <?php echo 'Upload'; ?>
            </a>
            <a href="#" class="button-secondary multi-images-remove">
               <?php echo 'Remove all images'; ?>
           </a>
       </div>
       <?php
   }
   
   public function theUploadedImages($srcs = array())
   {
    ?>
    <div class="customize-control-content">
        <ul class="thumbnails">
            <?php if (is_array($srcs)): ?>
                <?php foreach ($srcs as $src): ?>
                    <?php if ($src != ''): ?>
                        <li class="thumbnail" style="background-image: url(<?php echo $src; ?>);" data-src="<?php echo $src; ?>" >
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?> 
            <?php endif; ?>
        </ul>
    </div>
    <?php
	}
}