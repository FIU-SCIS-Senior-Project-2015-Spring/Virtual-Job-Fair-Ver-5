<?php
/**
 * Created by PhpStorm.
 * User: analhernandez
 * Date: 7/24/14
 * Time: 6:05 PM
 */
?>

<script type="text/javascript">

$(document).ready(function()
{
    $('#saveQmodal').modal('show');
});

</script>

<div class="modal hide fade" id="saveQmodal" tabindex="-1">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Save Query Message:</h4>
        </div>
        <div class="modal-body">
            <?php
            if(isset($mesg) && $mesg ==1 ) { ?>
                <div id="alertEmpty" class="alert alert-success">
                    <strong>Great!</strong> The query have been saved!
                </div>
            <?php } if(isset($mesg) && $mesg == 0 ) {?>
                <div id="alertBig" class="alert alert-error">
                    <strong>Error!</strong> <p>Oops... The was an error!<br>
                    Please make sure your search parameter is not empty.</p>
                </div>
            <?php } ?>
        </div>
         <?php if($user->FK_usertype == 2) 
             {?>
        <div class="modal-footer">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'link',
                'type'=>'primary',
                'label'=>'OK',
                'url'=>'../job/emphome'
            )); ?>
        </div>
        <?php }else { ?>      
        <div class="modal-footer">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'link',
                'type'=>'primary',
                'label'=>'OK',
                'url'=>'../job/home'
            )); ?>
        </div>
        <?php } ?>
    </div><!-- /.modal-content -->
</div><!-- /.modal -->

