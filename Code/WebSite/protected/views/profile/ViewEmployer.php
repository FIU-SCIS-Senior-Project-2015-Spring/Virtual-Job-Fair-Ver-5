<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<?php
    /* @var $this UserController */
    /* @var $this ProfileController */
    /* @var $form CActiveForm */
    /* @var $user User */

    // This is the View for the employer's profile from the perspective of 
    // the employer.
    
    $this->breadcrumbs = array('Profile' => array('/profile'),'View',);
    
    
        
   // echo $incompleteProfile;
?>


<script type="text/javascript">
//for the video tutorials
    $(function() {
        $('div.one')
                .css("cursor", "pointer")
                .click(function() {
                    $(this).siblings('.child-' + this.id).toggle('slow');
                });
        $('div[class^=child-]').hide();
    });

</script>
<script type="text/javascript" src="http://the-echoplex.net/demos/upload-file/"></script>

<script>

    $(document).ready(function()
    {
        //Validates Email is a regular expression in the form xxxx@xxxxx.xxxx as per Regex below
            function validateEmail(sEmail) {
                var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Regular Expression
                if(filter.test(sEmail)) {
                    return true;
                }
                else {
                    return false;
                }
            }
            //Enables the Form fields for editing
            function enableBasicInfo() {
                $("#BasicInfo_about_me").attr("disabled", false);
                $("#User_email").attr("disabled", false);
                $("#BasicInfo_phone").attr("disabled", false);
                $("#BasicInfo_city").attr("disabled", false);
                $("#BasicInfo_state").attr("disabled", false);
                $("#BasicInfo_zip_code").attr("disabled", false);
                $("#edit").attr("name", "yt0");
                $("#edit img").attr("src", "/JobFair/images/ico/done.gif");
                $("#edit").attr("onclick", "(\"#user-EditStudent-form\").onsubmit(); return false;");
            }       
        
        $("#saveInterest").click(function(e) {
            $(this).closest('form').submit();
        });

        $("#edit").click(function(e) {
            if($("#BasicInfo_about_me").is(":disabled") && $("#User_email").is(":disabled")
                    && $("#BasicInfo_phone").is(":disabled") && $("#BasicInfo_city").is(":disabled")
                    && $("#BasicInfo_state").is(":disabled")) {
                $("#BasicInfo_about_me").attr("disabled", false);
                $("#User_email").attr("disabled", false);
                $("#BasicInfo_phone").attr("disabled", false);
                $("#BasicInfo_city").attr("disabled", false);
                $("#BasicInfo_state").attr("disabled", false);
                $("#edit").attr("name", "yt0");
                $("#edit img").attr("src", "/JobFair/images/ico/done.gif");
                $("#edit").attr("onclick", "(\"#user-EditStudent-form\").onsubmit(); return false;");
            } else {
                    var sEmail = $('#User_email').val();
                    if($.trim(sEmail).length == 0) { //Email can't be left blank
                        $("#edit").removeAttr("onclick",null);
                        alert('The email field is mandatory.');
                        e.preventDefault();
                    } else {
                        if(validateEmail(sEmail)) {//Validate email against Regex
                            $("#user-EditStudent-form").submit();
                        } else {
                            $("#edit").removeAttr("onclick",null);
                            alert('Invalid email format.');
                            e.preventDefault();
                        }
                    }
                enableBasicInfo();    
                //$(this).closest('form').submit()
            }
        });

        $("#editcompany").click(function(e) {
            if($("#CompanyInfo_description").is(":disabled")
                    && $("#CompanyInfo_city").is(":disabled")
                    && $("#CompanyInfo_state").is(":disabled") && $("#CompanyInfo_zipcode").is(":disabled")) {
                $("#CompanyInfo_description").attr("disabled", false);
                $("#CompanyInfo_city").attr("disabled", false);
                $("#CompanyInfo_website").attr("disabled", false);
                $("#CompanyInfo_state").attr("disabled", false);
                $("#CompanyInfo_zipcode").attr("disabled", false);
                $("#editcompany").attr("name", "yt0");
                $("#editcompany img").attr("src", "/JobFair/images/ico/done.gif");
                $("#editcompany").attr("onclick", "$(this).closest('form').submit(); return false;");
            } else {
                $(this).closest('form').submit()
            }
        });


    });

    function myFunction()
    {
        var data = 'var=' + encodeURIComponent('hi');
        $.ajax({
            type: 'GET',
            url: '<?php echo Yii::app()->createUrl('profile/SaveInterest'); ?>',
            dataType: 'json',
            data: data,
            success: function() {
                alert('success');
                window.reload();
            },
            error: function() {
                alert('error');
            }
        });
    }

    /** 
     * Rene: Helper function to get the extension of a file.
     * Checks file formats. No need to check for upper or lower cases anymore.
     */ 
    function endWith(str, suffix) 
    {            
        // Upper case to cover examples such as: pdf and PDF.
        strUpperCase = str.toUpperCase();
        suffixUpperCase = suffix.toUpperCase();
            
        return strUpperCase.indexOf(suffixUpperCase, str.length - suffix.length) !== -1;
    }

    // Code for uploading a profile picture.
    // Bug fix #689
    function uploadpic()
    {
        document.getElementById("User_image_url").click();
        document.getElementById("User_image_url").onchange = function()
        {
            var imageExt = document.getElementById("User_image_url").value;

            // Check for valid picture type.
            if(endWith(imageExt, 'jpg') || endWith(imageExt, 'png'))
                document.getElementById("user-uploadPicture-form").submit();

            else
                alert('Image must be in JPG or PNG format.');
        }
    }


    function toggleJobMatching()
    {
        var val = $('#myonoffswitch').val();

        if(val == '1')
            $('#myonoffswitch').val('0');

        else
            $('#myonoffswitch').val('1');
    
        $.get("/JobFair/index.php/user/toggleEmailMatch", {"value": val}, function(data) {
            data = JSON.parse(data);
            if(data["status"] == '0')
                $("#myonoffswitch").prop('checked', false);
            
            else
                $("#myonoffswitch").prop('checked', true);

            $("#user_lastmodified").html(data["username"]);
            $("#user_lastmodifieddate").html(data["last_modified"]);
            $("#myonoffswitch").val(data["status"]);
        });
    }

    function toggleLookingForJob()
    {
        var val = $('#myonoffswitch_1').val();
        if(val == '1')
        {
            var jm = $('#myonoffswitch').val();
            if(jm == '1')
            {
                toggleJobMatching();
            }
            $('#myonoffswitch_1').val('0');
        }
        else
        {
            $('#myonoffswitch_1').val('1');
        }
        $.get("/JobFair/index.php/user/toggleLookingForJob", {"value": val}, function(data) {
            data = JSON.parse(data);
            if(data["status"] == '0')
            {
                $("#myonoffswitch_1").prop('checked', false);
            }
            else
            {
                $("#myonoffswitch_1").prop('checked', true);
            }
            $("#myonoffswitch_1").val(data["status"]);
        });
    }
    
    // Rene: Change profile css only once. This is to avoid extra computation.
    function changeProfileCompCSS()
    {
        $("#incomplete-box").css("color","#14BA14").css("background", "white"); 
    }


</script>


<div id="fullcontent">

    <div id="basicInfo">

<?php
    // Form for uploading a profile picture.
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-uploadPicture-form', 'action' => '/JobFair/index.php/Profile/uploadImage',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data',),
    ));
?>

    <div style=clear:both></div>
        <div  id="profileImage">
            <div id="upload">
                <img style="width:200px; 
                     height:215px;" src="<?php echo $user->image_url ?>" />
            </div>
            <a id="uploadlink" href="#" onclick="uploadpic()"><img style="margin-top: 5px;" src='/JobFair/images/ico/add.gif' />Upload Image</a>
        <?php echo CHtml::activeFileField($user, 'image_url', array('style' => 'display: none;')); ?>  

            <br>
            <br>

        <?php
            // Rene: Profile Completion Progress bar graph.
            //echo 'Profile Completion Graph';
            //echo '<span title="'. $incompleteComponents .'"> <div span class="progress progress-success progress-striped active"> <div class="bar" style="width:' . $profileCompStatus . '%' . '"> <span class="sr-only">' . $profileCompStatus . '%' . '</span>  </div> </div> </span>';

            echo '<div>Profile Completion Graph</div>';
            // Green bar.
            if($profileCompStatus >= 75)
                echo '<div id="box" span class="progress progress-success progress-striped active"> <div class="bar" style="width:' . $profileCompStatus . '%' . '"> <span class="sr-only">' . $profileCompStatus . '%' . '</span>  </div> </div>';
                   
            // Blue bar.
            else if($profileCompStatus >= 50)
                echo '<div id="box" span class="progress progress-info progress-striped active"> <div class="bar" style="width:' . $profileCompStatus . '%' . '"> <span class="sr-only">' . $profileCompStatus . '%' . '</span>  </div> </div>';
                    
            // Yellow bar.
            else
                echo '<div id="box" span class="progress progress-warning progress-striped active"> <div class="bar" style="width:' . $profileCompStatus . '%' . '"> <span class="sr-only">' . $profileCompStatus . '%' . '</span>  </div> </div>';
                    
            $pending = explode(",", $incompleteComponents);                    
                    
            echo '<div id="incomplete-box"><ul>';
                    
            foreach ($pending as $key=>$value)             
                echo '<li>'.$value.'<i class="fa fa-exclamation-circle pull-right"></i></li>';                        
                   
            echo '</ul></div>';
            
            // Changes the CSS if needed.
            if($profileCompStatus == 100)
                echo '<script> changeProfileCompCSS(); </script>';

         ?> 

        </div>
    
        <script>
            // Toggle for the pending notice of the profile completion graph.
            $("#box").hover(function()
            {
                //$("#incomplete-box:contains('Profile Completed!')").css("color","#14BA14").css("background", "white");                    
                $("#incomplete-box").toggle();
            });

        </script>

    <?php $this->endWidget(); ?>




<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-EditStudent-form', 'action' => '/JobFair/index.php/Profile/EditBasicInfo',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data',),
    ));
?>

        <div id="insidebasicinfo" >
            <name><?php echo $user->first_name . " " . $user->last_name ?></name><br>

            <aboutme>
                <?php 
                    echo $form->textArea($user->basicInfo, 'about_me', array('rows' => 3, 'cols' => 75, 'border' => 0, 'class' => 'ta', 'disabled' => 'true')); 
                ?>
            </aboutme><br>

            <lab>EMAIL:</lab> <?php echo $form->textField($user, 'email', array('class' => 'tb5', 'disabled' => 'true')); ?>
            <lab>PHONE:</lab> <?php echo $form->textField($user->basicInfo, 'phone', array('class' => 'tb5', 'disabled' => 'true')); ?>
            <lab>LOCATION:</lab> <?php echo $form->textField($user->basicInfo, 'city', array('class' => 'tb5', 'disabled' => 'true')); ?><br>
            <lab>STATE:</lab> <?php echo $form->textField($user->basicInfo, 'state', array('class' => 'tb5', 'disabled' => 'true')); ?>
        </div>
        <div style="clear:both"></div>

        <p><a style="float: left; margin-left:230px; width:80px" href="#" id="edit" class="editbox"><img src='/JobFair/images/ico/editButton.gif'/> Edit Info.</a></p>


    </div> <!--  END BASIC INFO -->

    <div style="clear:both"></div>
<?php $this->endWidget(); ?>

    <br>
    <br>
    <hr>

    <div id="leftside">

    </div>

    <div id="subcontent2" >
        <div style=clear:both></div>
        <div id="menutools">
            <div class="titlebox">SETTINGS</div><br><br>
<?php
    $checked = $checked_lfj = '';
    $job_notif = null;
    $looking_for_job = null;
    if (isset($user['looking_for_job']))
    {
        $looking_for_job = $user->looking_for_job;
        if ($user->looking_for_job == '1')
            $checked_lfj = 'checked';
    }
    if (isset($user['job_notification']))
    {
        $job_notif = $user->job_notification;
        if ($user->job_notification == '1')
            $checked = 'checked';
    }
?>
            <!-- Receive notifications from students. -->
            <div style="overflow: hidden;">
                <div style="float: left;">Get Student Notifications:</div>
                <div style="margin-left: 140px;" class="onoffswitch">
                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" value='<?php echo $job_notif; ?>' id="myonoffswitch" <?php echo $checked; ?> onclick="toggleJobMatching()">
                    <label class="onoffswitch-label" for="myonoffswitch">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label>
                </div>
            </div>
            <div style="overflow: hidden;">
                <div style="float: left;">Looking For Student:</div>
                <div style="margin-left: 140px;" class="onoffswitch">
                    <input type="checkbox" name="myonoffswitch_1" class="onoffswitch-checkbox" value='<?php echo $looking_for_job; ?>' id="myonoffswitch_1" <?php echo $checked_lfj; ?> onclick="toggleLookingForJob()">
                    <label class="onoffswitch-label" for="myonoffswitch_1">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label>
                </div>
            </div>
            <p>Select queries to search for jobs</p>
            <form method="GET" id="interestForm" action="/JobFair/index.php/profile/saveinterest">
                <div style= "text-align:left;">
    <?php 
        foreach ($saveQ as $query)
        { ?>
                            <?php
                            if ($query['active'] == '1')
                            {
                                ?>
                                <div class="checkbox">
                                    <input type="checkbox" name="<?php echo $query['id']; ?>" id="<?php echo $query['id']; ?>" value="1" checked>
                                    <strong> <?php echo ($query['query_tag']) . ":"; ?></strong> <?php echo ($query['query']); ?>
                                    <del><a href="/JobFair/index.php/profile/deleteinterest?id=<?php echo $query->id ?>"><img src='/JobFair/images/ico/del.gif' width="10px" height="10px"/></a></del>

                                </div>
                            <?php
                            }
                            else
                            {
                                ?>
                                <div class="checkbox">
                                    <input type="checkbox" name="<?php echo $query['id']; ?>" id="<?php echo $query['id']; ?>" value="1">
                                    <strong> <?php echo ($query['query_tag']) . ":"; ?></strong> <?php echo ($query['query']); ?>
                                    <del><a href="/JobFair/index.php/profile/deleteinterest?id=<?php echo $query->id ?>"><img src='/JobFair/images/ico/del.gif' width="10px" height="10px"/></a></del>

                                </div>
                            <?php } ?>
    <?php } ?>
                </div>
                
                <hr>
                <p>Select email frequency</p>
                <?php
                    $date = $user->job_int_date;

                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'name' => 'day',
                        'id' => 'day',
                        'value' => $date,
                        'htmlOptions' => array('value' => $date, 'placeholder' => 'put number ',
                            'style' => 'width: 150px;'),));
                ?>

                <?php
                    $this->widget('bootstrap.widgets.TbButton', array(
                        'label' => 'Save',
                        'type' => 'primary',
                        'htmlOptions' => array(
                            'data-toggle' => 'modal',
                            'data-target' => '#myModal',
                            'id' => "saveInterest",
                            'style' => "margin-top: 5px; margin-bottom: 5px;width: 120px",
                        //'onclick' => "myFunction()"
                        ),
                    ));
                ?>
            </form>
        </div>


        <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'user-EditStudent-form', 'action' => '/JobFair/index.php/Profile/editCompanyInfo',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('enctype' => 'multipart/form-data',),
            ));
        ?>	

        <br>
        <div class="companyinfo " style="float:right!important; margin-top:-20px;">
            <div class="titlebox ">COMPANY INFO</div>

            <p><a href="#" id="editcompany" class="editbox"><img src='/JobFair/images/ico/editButton.gif'/></a></p>
            <div style=clear:both></div>
            <name><?php echo $user->companyInfo->name ?></name><br>

            <aboutme>
            <?php 
                echo $form->textArea($user->companyInfo, 'description', array('rows' => 3, 'cols' => 75, 'border' => 0, 'class' => 'ta', 'disabled' => 'true')); 
            ?>
            </aboutme> <br>

            <lab>WEBSITE:</lab> <?php echo $form->textField($user->companyInfo, 'website', array('class' => 'tb5', 'disabled' => 'true')); ?>
            <lab>LOCATION:</lab> <?php echo $form->textField($user->companyInfo, 'city', array('class' => 'tb5', 'disabled' => 'true')); ?><br>
            <lab>STATE:</lab> <?php echo $form->textField($user->companyInfo, 'state', array('class' => 'tb5', 'disabled' => 'true')); ?>
            <lab>ZIP CODE:</lab> <?php echo $form->textField($user->companyInfo, 'zipcode', array('class' => 'tb5', 'disabled' => 'true')); ?>

        </div> <!--  END COMPANY INFO -->

    <?php $this->endWidget(); ?>

        <br>
    <div style="clear:one"></div>

    <div class="companyjobs" style="float:right; margin-top:20px;">

        <div class="titlebox">COMPANY JOBS</div>
        <p><a href="/JobFair/index.php/job/post" id="postJob" class="editbox"><img src='/JobFair/images/ico/add.gif'"/></a></p>
        <br>
        <br>
        <?php 
            foreach ($user->jobs as $job)
            { ?>
                <jobtitle>
                    <a href="/JobFair/index.php/job/view/jobid/<?php echo $job->id ?>"><?php echo $job->title ?></a>
                </jobtitle>
                <div style="clear:both;"></div>
                <hr>
    <?php } ?>
    </div> <!--  END COMPANY JOBS -->


    <?php
        function formatDate($mysqldate)
        {
            $time = strtotime($mysqldate);
            return date("F Y", $time);
        }
    ?>

</div><!--  END CONTENT -->
</div><!--  END FULL CONTENT -->






