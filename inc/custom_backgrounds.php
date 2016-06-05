<?php

class harlequinMultiImageBackground extends WP_Customize_Control
{
    public $type = 'textarea';

    public function __construct($manager, $id, $args = array())
    {
        parent::__construct($manager, $id, $args);
    }

    public function enqueue()
    {
        wp_enqueue_style( 'harlequin-customizer-background', get_template_directory_uri() . '/css/customizer/cb_customizer.css' );
        wp_enqueue_script("jquery-ui-draggable", array('jquery'));
        wp_enqueue_script("jquery-ui-droppable", array('jquery'));
    }
	
    public function render_content()
    {
	
	    ?><input type="text" value="<?php echo $this->value(); ?>" <?php $this->link(); ?> /><?PHP
		$data = $this->value();
		$imgs = explode(" ", trim($data));
	
		?><ul id="pppcbsortable" style="min-height:30px; width:100%; border:1px solid #000">
			<?PHP
				foreach($imgs as $img){
					echo "<li pic_id='" . $img . "' class='deletable' style='display:inline-block'>" . wp_get_attachment_image( $img, array(34,34) ) . "</li>";
				}
			?>
		</ul>
		<a href="#" id="pppempty-backgrounds" class="button-secondary">
            <?php echo 'Remove all'; ?>
        </a>
		<div class="scroll"><ul><?PHP
		
		$query_images_args = array(
			'post_type' => 'attachment', 'post_status' => 'inherit', 'posts_per_page' => -1,
		);

		$query_images = new WP_Query( $query_images_args );
		
		foreach ( $query_images->posts as $image) {
			echo "<li pic_id='" . $image->ID . "' class='draggable' style='display:inline-block'>" . wp_get_attachment_image( $image->ID, array(34,34) ) . "</li>";
		}
		?></ul></div>
			<script type="text/javascript">
				jQuery( ".draggable" ).draggable(
					{
					  helper: "clone"
					}
				);
				jQuery( "ul, li" ).disableSelection();
				jQuery( "#pppcbsortable" )
					.droppable({
					  hoverClass: "sortable-ui-state-hover",
					  drop: function( event, ui ) {
						console.log(event);
						jQuery( this ).find( ".placeholder" ).remove();
						jQuery( "<li></li>" ).html( ui.draggable.html() ).appendTo( this );
						jQuery(this)
							.children()
							.last()
							.css("margin", "1.5px");
						jQuery(this)
							.children()
							.last()
							.attr("pic_id", jQuery(ui.draggable).attr("pic_id"));
						jQuery(this)
							.children()
							.last()
							.on("click", function(event){
														id = jQuery(event.currentTarget).attr("pic_id");
														console.log(id);
														jQuery(event.currentTarget).remove();
														val = jQuery("#customize-control-bkgsetting")
																.children()
																.first()
																.val();
														val = val.split(" " + id + " ").join("");
														console.log(val);
														jQuery("#customize-control-bkgsetting")
															.children()
															.first()
															.val(val);
														jQuery("#customize-control-bkgsetting")
															.children()
															.first()
															.trigger("keyup");
													}
							);
						val = jQuery("#customize-control-bkgsetting")
							.children()
							.first()
							.val();
						jQuery("#customize-control-bkgsetting")
							.children()
							.first()
							.val(val + " " + jQuery(ui.draggable).attr("pic_id") + " ");
						jQuery("#customize-control-bkgsetting")
							.children()
							.first()
							.trigger("keyup");
					  }
					}
				);
				jQuery(".deletable")
					.each(
						function(index,value){
							jQuery(value)
								.on("click", function(event){
										id = jQuery(event.currentTarget).attr("pic_id");
										jQuery(event.currentTarget).remove();
										val = jQuery("#customize-control-bkgsetting")
											.children()
											.first()
											.val();
										val = val.split(" " + id + " ").join("");
										console.log(val);
										jQuery("#customize-control-bkgsetting")
											.children()
											.first()
											.val(val);
										jQuery("#customize-control-bkgsetting")
											.children()
											.first()
											.trigger("keyup");
													}
												)
						}
					);
				jQuery("#pppempty-backgrounds")	
					.on("click", function(){
							jQuery("#pppcbsortable")
								.html("");
							jQuery("#customize-control-bkgsetting")
								.children()
								.first()
								.val("");
							jQuery("#customize-control-bkgsetting")
								.children()
								.first()
								.trigger("keyup");
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