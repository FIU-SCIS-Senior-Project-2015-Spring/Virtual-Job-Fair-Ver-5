<?php

    require ('PasswordHash.php');

    class UserController extends Controller
    {

        public $username = '';
        public $email = '';

        public function actionIndex()
        {
            $user = User::model()->findByPk(1);
            $this->username = $user->username;
            $this->email = $user->email;

            $this->render('index', array('username' => $this->username, 'email' => $this->email));
        }
        
        
        /**
         * Specifies the access control rules.
         * This method is used by the 'accessControl' filter.
         * @return array access control rules
         */
        public function accessRules()
        {
            return array(
                
                // Rules for admin.
                array('allow', 
                    'actions' => array('CreateAdmin', 'AdminRegister', 'VerifyAdminRegistration', 'NewAdmin'),
                    
                    //'users' => array('admin', 'administrator'),
                    'users' => array('@'),
                    'expression' => 'User::getCurrentUser()->FK_usertype == 3',
                ),
  
            );
        }

        public function actionRegister()
        {
            $this->render('register');
        }
        
        
        // Creates an admin.
        public function actionCreateAdmin()
        {                        
            if(User::isCurrentUserAdmin())
            {
                $model = new User;

                                
                if (isset($_POST['User']))
                {
                    $model->attributes = $_POST['User'];

                    $this->actionAdminRegister();
                }

                $this->render('AdminRegister', array('model' => $model,));
            }
        }
        
        /**
         * Register admin account.
         */
        public function actionAdminRegister()
        {
            $model = new User;

            if (isset($_POST['User']))
            {
                $model->attributes = $_POST['User'];
                $model->activated = '1';
                
                if($model->validate())
                {
                    if ($this->actionVerifyAdminRegistration() != "")
                        $this->render('AdminRegister');
                  
                    //Form inputs are valid
                    //Populate user attributes
                    $model->FK_usertype = 3;
                    $model->registration_date = new CDbExpression('NOW()');
                    $model->activation_string = $this->genRandomString(10);
                    $model->image_url = '/JobFair/images/profileimages/user-default.png';

                    //Hash the password before storing it into the database
                    $hasher = new PasswordHash(8, false);
                    $unHashedPass = $model->password;
                    $model->password = $hasher->HashPassword($model->password);

                    //Save user into database. Account still needs to be activated
                    if($model->save($runValidation = false))
                    {
                        $basicInfo = new BasicInfo;
                        $basicInfo->attributes = $_POST['BasicInfo'];
                        
                        $basicInfo->userid = $model->id;
                        $basicInfo->city = '';
                        $basicInfo->state = '';

                        $basicInfo->save(false);
                    }

                    $link = 'http://' . Yii::app()->request->getServerName() . '/JobFair/index.php/UserCrud/admin';
                    
                    $message = $model->username . " just joined VJF, click here to view their profile.";
                    
           
                    $message1 = "There is a new admin named " . $model->username . " that is waiting for activation";
                    $admins = User::model()->findAllByAttributes(array('FK_usertype' => 3));
                    
                    User::sendAdminNotificationNewEmpolyer($model, $admins, ($link . $model->username), $message1);
                    
                    $message = "Congratulations you have been successfully registered by another Admin. You are now an Admin of the system.";
                    $message .= "<br/>Your username: $model->username";
                    $message .= "<br>Your temporary password: $unHashedPass";
                    $message .= "<br>Login link: $link";
                    
                    // Comment this line below if you are using a local machine. 
                    // Sends an email.
                    User::sendEmail($model->email, "Registration Notification", "Registration Notification", $message);

                    // Redirect to confirmation page.
                    $this->redirect('NewAdmin?byAdmin='. $model->first_name);
                    
                    return;
                }
            }
            
          //  $errorMsg = 'Something failed.';
            $this->render('AdminRegister', array('model' => $model)); //'errorMsg' => $errorMsg));
        }

        // Admin function that creates employers.
        public function actionCreateEmployer()
        {
            if(User::isCurrentUserAdmin())
            {
                $model = new User;

                // Uncomment the following line if AJAX validation is needed
                // $this->performAjaxValidation($model);

                if (isset($_POST['User']))
                {
                    $model->attributes = $_POST['User'];

                    $this->actionEmployerRegister();
                }

                $this->render('EmployerRegister', array('model' => $model,));
            }
        }

        // Admin function that creates user.
        public function actionCreate()
        {
            if(User::isCurrentUserAdmin())
            {
                $model = new User;

                // Uncomment the following line if AJAX validation is needed
                // $this->performAjaxValidation($model);

                if (isset($_POST['User']))
                {
                    $model->attributes = $_POST['User'];

                    $this->actionStudentRegister();
                }

                $this->render('create', array('model' => $model,));
                
            }
        }

        
        public function actionChangePassword()
        {
            $model = User::getCurrentUser();
            $error = '';
            
            $confirmation;
            
            if (isset($_POST['User']))
            {
                $pass = $_POST['User']['password'];
                $p1 = $_POST['User']['password1'];
                $p2 = $_POST['User']['password2'];

                //This address the bug in card #341 (Allowing blank passwords and leaving users locked out) 
                if ($p1 == $p2 && strlen($p1) < 6)
                { //Check that the new password is at least 6 characters
                    $error .= "New password must have at least 6 characters. Please enter another password. <br />";
                    $this->render('ChangePassword', array('model' => $model, 'error' => $error));
                    exit();
                }
                //verify old password
                $username = Yii::app()->user->name;
                $hasher = new PasswordHash(8, false);
                $login = new LoginForm;
                $login->username = $username;
                $login->password = $pass;

                //$user = User::model()->find("username=:username AND password=:password", array(":username"=> $username, ":password"=>$password));
                if (!$login->validate())
                {
                    $error = "Old Password was incorrect.";
                    $this->render('ChangePassword', array('model' => $model, 'error' => $error));
                }
                elseif ($p1 == $p2)
                {
                    //Hash the password before storing it into the database
                    $hasher = new PasswordHash(8, false);
                    $user = User::getCurrentUser();
                    $user->password = $hasher->HashPassword($p1);
                    $user->save(false);

                    $confirmation = "Your password was changed succesfully!";
                    
                    $this->render('ChangePassword', array('model' => $model, 'confirmation'=>$confirmation));
                }
                else
                {
                    $error = "Passwords do not match.";
                    $this->render('ChangePassword', array('model' => $model, 'error' => $error));
                }
            }
            else
                $this->render('ChangePassword', array('model' => $model, 'error' => $error));

        }

        public function mynl2br($text)
        {
            return strtr($text, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />'));
        }
        
        /**
         * Handles employer registration.
         */
        public function actionEmployerRegister()
        {
            $model = new User;

            // uncomment the following code to enable ajax-based validation
            /*
              if(isset($_POST['ajax']) && $_POST['ajax']==='user-EmployerRegister-form')
              {
              echo CActiveForm::validate($model);
              Yii::app()->end();
              }
             */

            if (isset($_POST['User']))
            {
                $model->attributes = $_POST['User'];
                $model->activated = '1';
                
                if ($model->validate())
                {
                    if ($this->actionVerifyEmployerRegistration() != "")
                        $this->render('EmployerRegister');
                  
                    //Form inputs are valid
                    //Populate user attributes
                    $model->FK_usertype = 2;
                    $model->registration_date = new CDbExpression('NOW()');
                    $model->activation_string = $this->genRandomString(10);
                    $model->image_url = '/JobFair/images/profileimages/user-default.png';
                    //$model->actived = null;

                    //Hash the password before storing it into the database
                    $hasher = new PasswordHash(8, false);
                    $model->password = $hasher->HashPassword($model->password);

                    $model->activated = null;
                    
                    //Save user into database. Account still needs to be activated
                    //save employers company info
                    if ($model->save($runValidation = false))
                    {
                        $companyInfo = new CompanyInfo;
                        $companyInfo->attributes = $_POST['CompanyInfo'];
                        $companyInfo->description = $this->mynl2br($_POST['CompanyInfo']['description']);
                        $companyInfo->FK_userid = $model->id;
                        $companyInfo->save($runValidation = false);
                        $basicInfo = new BasicInfo;
                        $basicInfo->attributes = $_POST['BasicInfo'];
                        $basicInfo->about_me = $this->mynl2br($_POST['BasicInfo']['about_me']);
                        $basicInfo->userid = $model->id;
                        $basicInfo->city = $companyInfo->city;
                        $basicInfo->state = $companyInfo->state;

                        $basicInfo->save(false);
                    }

                    $link = 'http://' . Yii::app()->request->getServerName() . '/JobFair/index.php/profile/employer/user/' . $model->username;
                    $link2 = 'http://' . Yii::app()->request->getServerName() . '/JobFair/index.php/profile/employer/user/' . $model->username;
                    $message = $model->username . " just joined VJF, click here to view their profile.";
                    User::sendAllStudentVerificationAlart($model->id, $model->username, $model->email, $message, $link);
                    $message1 = "There is a new employer named " . $model->username . " that is waiting for activation";
                    $admins = User::model()->findAllByAttributes(array('FK_usertype' => 3));
                    User::sendAdminNotificationNewEmpolyer($model, $admins, $link2, $message1);
                    $message = "You have successfully registered. Once your account has been approved, you will receive an email stating your account is active.";
                    $message .= "<br/>Your username: $model->username";
                    
                    // Comment this line below if you are using a local machine. 
                    // Sends an email.
                    User::sendEmail($model->email, "Registration Notification", "Registration Notification", $message);

                    // Redirect to confirmation page.
                    if(User::isCurrentUserAdmin())
                        $this->redirect('NewEmployer?byAdmin='. $model->first_name);
                    
                    else
                        $this->redirect(array('user/newEmployer', 'name'=> $model->first_name));
                    
                    return;
                }
            }
            
          //  $errorMsg = 'Something failed.';
            $this->render('EmployerRegister', array('model' => $model)); //'errorMsg' => $errorMsg));
        }

        
        /**
         * Rene: Display the confirmation page.
         */
        public function actionNewEmployer()
        {
            if(isset($_REQUEST['name']))
            {
                $name = $_REQUEST['name'];
                
                // Check if registration was done by admin.
                if(User::getCurrentUser()->FK_usertype == 3)
                    $this->render('NewEmployer', array('byAdmin' => $name));
                 
                // Registration was done by employer.
                else
                    $this->render('NewEmployer', array('byEmployer' => $name));
            }

            $this->render('NewEmployer');
                
        }
        
        public function actionNewAdmin()
        {
            if(isset($_REQUEST['name']))
            {
                $name = $_REQUEST['name'];
                
                // Check if registration was done by admin.
                if(User::getCurrentUser()->FK_usertype == 3)  
                    $this->redirect('NewAdmin?byAdmin='.$name);
                 
            }     
            
            $this->render('NewAdmin');
        }

        
        public function actionSendVerificationEmail($email = null)
        {
            if (!isset($email))
            {
                $username = $_GET['username'];
                $user = User::model()->find("username=:username", array(':username' => $username));
            }
            else
            {
                $user = User::model()->find("email=:email", array(':email' => $email));
            }
            $link = CHtml::link('click here', 'http://' . Yii::app()->request->getServerName() . '/JobFair/index.php/user/VerifyEmail?username=' . $user->username
                    . '&activation_string=' . $user->activation_string);
            $message = 'You need to verify your account before logging in.  Use this ' . $link . ' to verify your account.';
            $user->sendEmail($user->email, 'Verify your account on Virtual Job Fair', 'Verify Account', $message);
            //$user->sendVerificationEmail();
            $this->redirect('/JobFair/index.php/site/page?view=verification');
        }

        
        public function actionStudentRegister()
        {
            $model = new User;

            // uncomment the following code to enable ajax-based validation
            /*
              if(isset($_POST['ajax']) && $_POST['ajax']==='user-StudentRegister-form')
              {
              echo CActiveForm::validate($model);
              Yii::app()->end();
              }
             */

            if (isset($_POST['User']))
            {
                $user = $_POST['User'];
                $email = $user['email'];
                $pathStudent = $this->actionVerifyStudentRegistration();
                if ($pathStudent == 1)
                {
                    $this->actionStudentHelpReg($email);
                    return;
                }
                if ($pathStudent != "" && $pathStudent != 1)
                {
                    $this->render('StudentRegister');
                }

                $model->attributes = $_POST['User'];
                $model->image_url = '/JobFair/images/profileimages/user-default.png';
                $resume = Resume::model();

                //Form inputs are valid
                // save ID to resume table
                $resume->id = $model->id;
                $resume->save(false);

                //Populate user attributes
                $model->FK_usertype = 1;
                $model->registration_date = new CDbExpression('NOW()');
                $model->activation_string = $this->genRandomString(10);

                //Hash the password before storing it into the database
                $hasher = new PasswordHash(8, false);
                $model->password = $hasher->HashPassword($model->password);

                //Save user into database. Account still needs to be activated
                $model->save($runValidation = false);

                if (User::isCurrentUserAdmin() == FALSE)
                {
                    //added in order to store phone number
                    $basicInfo = new BasicInfo;
                    $basicInfo->attributes = $_POST['BasicInfo'];
                    $basicInfo->userid = $model->id;

                    if (!isset($_POST['BasicInfo']['phone']))
                    {
                        Yii::log("checks", CLogger::LEVEL_ERROR, 'application.controller.Prof');
                        $basicInfo->phone = NULL;
                    }
                    $basicInfo->save(false);
                }

                $this->actionSendVerificationEmail($model->email);
                return;
            }
            $error = '';
            $this->render('StudentRegister', array('model' => $model, 'error' => $error));
        }

        public function actionVerifyStudentRegistration()
        {
            $user = $_POST['User'];
            $error = "";

            $username = $user['username'];
            $password = $user['password'];
            $password2 = $user['password_repeat'];
            $email = $user['email'];


            if ((strlen($username) < 4) || (!ctype_alnum($username)))
            {
                $error .= "Username must be alphanumeric and at least 4 characters.<br />";
            }
            if (User::model()->find("username=:username", array(':username' => $username)))
            {
                $error .= "Username is taken<br />";
            }
            if (User::model()->find("email=:email", array(':email' => $email)))
            {
                $error .= "Email is taken<br />";
                return 1;
            }
            if ($password != $password2)
            {
                $error .= "Passwords do not match<br />";
            }
            if (strlen($password) < 6)
            {
                $error .= "Password must be more than 5 characters<br />";
            }
            if (!$this->check_email_address($email))
            {
                $error .= "Email is not correct format<br />";
            }

            print $error;
            return $error;
        }
        
        public function actionVerifyAdminRegistration()
        {
            $user = $_POST['User'];
            $basicInfo = $_POST['BasicInfo'];
            $error = "";

            $username = $user['username'];
            $password = $user['password'];
            $password2 = $user['password_repeat'];
            $email = $user['email'];

            $phone = $basicInfo['phone'];

            if ((strlen($username) < 4) || (!ctype_alnum($username)))
                $error .= "Username must me alphanumeric and at least 4 characters.<br />";
            
            if (User::model()->find("username=:username", array(':username' => $username)))
                $error .= "Username is taken<br />";
            
            if (User::model()->find("email=:email", array(':email' => $email)))
                $error .= "Email is taken<br />";
            
            if($password != $password2)
                $error .= "Passwords do not match<br />";
            
            if (strlen($password) < 6)
                $error .= "Password must be more than 5 characters<br />";

            if (!$this->check_email_address($email))
                $error .= "Email is not correct format<br />";

            
            print $error;

            return $error;
        }

        public function actionVerifyEmployerRegistration()
        {
            $user = $_POST['User'];
            $company = $_POST['CompanyInfo'];
            $basicInfo = $_POST['BasicInfo'];
            $error = "";

            $username = $user['username'];
            $password = $user['password'];
            $password2 = $user['password_repeat'];
            $email = $user['email'];

            $aboutme = $basicInfo['about_me'];
            $phone = $basicInfo['phone'];

            $companyname = $company['name'];
            $companystreet = $company['street'];
            $companystreet2 = $company['street2'];
            $companycity = $company['city'];
            $companystate = $company['state'];
            $companyzip = $company['zipcode'];
            $companydescription = $company['description'];

            if ((strlen($username) < 4) || (!ctype_alnum($username)))
            {
                $error .= "Username must me alphanumeric and at least 4 characters.<br />";
            }
            if (User::model()->find("username=:username", array(':username' => $username)))
            {
                $error .= "Username is taken<br />";
            }
            if (User::model()->find("email=:email", array(':email' => $email)))
            {
                $error .= "Email is taken<br />";
            }
            if ($password != $password2)
            {
                $error .= "Passwords do not match<br />";
            }
            if (strlen($password) < 6)
            {
                $error .= "Password must be more than 5 characters<br />";
            }

            if (!$this->check_email_address($email))
            {
                $error .= "Email is not correct format<br />";
            }
            if (strlen($aboutme) < 1)
            {
                $error .= "Must enter information for \"About Me\"<br />";
            }
            if (strlen($companyname) < 1)
            {
                $error .= "Must enter information for \"Company Name\"<br />";
            }
            if (strlen($companystreet) < 1)
            {
                $error .= "Must enter information for \"Company Street\"<br />";
            }
            if (strlen($companycity) < 1)
            {
                $error .= "Must enter information for \"Company City\"<br />";
            }
            if (strlen($companystate) < 1)
            {
                $error .= "Must enter information for \"Company State\"<br />";
            }
            if (strlen($companyzip) < 1)
            {
                $error .= "Must enter information for \"Company Zip\"<br />";
            }
            if (strlen($companydescription) < 1)
            {
                $error .= "Must enter information for \"Company Description\"<br />";
            }

            print $error;
            //return ($error == "");
            return $error;
        }

        function check_email_address($email)
        {
            // First, we check that there's one @ symbol, and that the lengths are right
            if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email))
            {
                // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
                return false;
            }
            // Split it into sections to make life easier
            $email_array = explode("@", $email);
            $local_array = explode(".", $email_array[0]);
            for ($i = 0; $i < sizeof($local_array); $i++)
            {
                if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i]))
                {
                    return false;
                }
            }
            if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1]))
            { // Check if domain is IP. If not, it should be valid domain name
                $domain_array = explode(".", $email_array[1]);
                if (sizeof($domain_array) < 2)
                {
                    return false; // Not enough parts to domain
                }
                for ($i = 0; $i < sizeof($domain_array); $i++)
                {
                    if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i]))
                    {
                        return false;
                    }
                }
            }

            return true;
        }

        public function actionSendVerification()
        {
            
        }

        public static function genRandomString($length = 10)
        {
            $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
            $string = "";
            for ($p = 0; $p < $length; $p++)
            {
                $string .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            return $string;
        }

        public function actionMessage()
        {

            $username = Yii::app()->user->name;
            $user = User::model()->find("username=:username", array(':username' => $username));
            $this->render('message', array('user' => $user));
        }

        public function actionTomer()
        {
            $this->render('message');
        }

        public function actionVerifyEmail($username, $activation_string)
        {
            $usermodel = User::model()->find("username=:username AND activation_string=:activation_string", array(':username' => $username, ':activation_string' => $activation_string));
            if ($usermodel != null)
            {
                $usermodel->activated = 1;
                $usermodel->save(false);
                $this->redirect("/JobFair/index.php/site/login");
            }
            else
                redirect();
        }

    public function actionRegisterLinkedIn()
    { 
        
    include "linkedin.php";
    
        $linkedIn = new Linkedin;
         
    // OAuth 2 Control Flow
      if (isset($_GET['error'])) {
          // LinkedIn returned an error
          // print $_GET['error'] . ': ' . $_GET['error_description'];
          $this->redirect('/JobFair/index.php'); 
          
      } elseif (isset($_GET['code'])) {
          // User authorized your application
          if ($_SESSION['state'] == $_GET['state']) {
              // Get token so you can make API calls
              $linkedIn->getAccessToken();
          } else {
              // CSRF attack? Or did you mix up your states?
              exit;
          }
      } else { 
          if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
              // Token has expired, clear the state
              $_SESSION = array();
          }
          if (empty($_SESSION['access_token'])) {
              // Start authorization process
              $linkedIn->getAuthorizationCode();
          }
      }
      
        # You now have a $linkedin->access_token and can make calls on behalf of the current member
        $data = $linkedIn->fetch('GET', '/v1/people/~:(id,first-name,last-name,headline,picture-url,industry,email-address,languages,phone-numbers,skills,educations,location:(name),positions,picture-urls::(original))');        
        //print_r($data);

        
            // get user by linkedinid
            $model = new User();
            $user = User::model()->findByAttributes(array('linkedinid' => $data->id));


            // check if user exits in database, if so login
            if ($user != null)
            {

                if ($user->disable != 1)
                {
                    $identity = new UserIdentity($user->username, '');
                    if ($identity->authenticateOutside())
                    {
                        Yii::app()->user->login($identity);
                    }

                    $this->redirect("/JobFair/index.php/home/studenthome");
                    return;
                }
                else
                {
                    $this->redirect("/JobFair/index.php/site/page?view=disableUser");
                    return;
                }


                // register
            }
            else
            {

                // print "<pre>"; print_r('user is null');print "</pre>";
                // check that there is no duplicate user if so link to that account
                $duplicateUser = User::model()->findByAttributes(array('email' => $data->emailAddress));
                if ($duplicateUser != null)
                {
                    // get username and link the accounts
                    $username = $duplicateUser->username;
                    $user = User::model()->find("username=:username", array(':username' => $username));
                    $user->linkedinid = $data->id;
                    $user->save(false);
                    $user_id = $user->id;


                    // ------------------BASIC INFO---------------
                    $basic_info = null;
                    $basic_info = BasicInfo::model()->findByAttributes(array('userid' => $user_id));
                    if ($basic_info == null){
                    $basic_info = new BasicInfo();
                    $basic_info->userid = $user_id;
                    $basic_info->save(false);
                    }
                }/*
                    // ------------------BASIC INFO -----------------
                    // -----------------EDUCATION ----------------------
                    // get number of educations to add
                    $educ_count = $data->educations->total;

                    // delete current educations
                    $delete_educs = Education::model()->findAllByAttributes(array('FK_user_id' => $user_id));
                    foreach ($delete_educs as $de)
                    {
                        $de->delete();
                    }

                    // add educations
                    for ($i = 0; $i < $educ_count; $i++)
                    {
                        // first check if current education is in school table. if not, add it
                        $current_school_name = $data->educations->education[$i]->{'school-name'};
                        $school_exists = School::model()->findByAttributes(array('name' => $current_school_name));
                        if ($school_exists == null)
                        {
                            $new_school = new School();
                            $new_school->name = $current_school_name;
                            $new_school->save();
                            $school_id = School::model()->findByAttributes(array('name' => $current_school_name))->id;
                        }
                        else
                        {
                            $school_id = $school_exists->id;
                        }

                        // now ready to add new education
                        $new_educ = new Education();
                        $new_educ->degree = $data->educations->education[$i]->degree;
                        $new_educ->major = $data->educations->education[$i]->{'field-of-study'};
// 	   	$model->admission_date=date('Y-m-d',strtotime($model->admission_date));
                        $new_educ->graduation_date = date('Y-m-d', strtotime($data->educations->education[$i]->{'end-date'}->year));
// 	   	print "<pre>"; print_r($new_educ->graduation_date);print "</pre>";return;
                        $new_educ->FK_school_id = $school_id;
                        $new_educ->FK_user_id = $user_id;
                        $new_educ->additional_info = $data->educations->education[$i]->notes;
                        $new_educ->save(false);
                    }
                    // -----------------EDUCATION ----------------------
                    // -----------------EXPERIENCE -------------------
                    // get number of educations to add
                    $pos_count = $data->positions['total'];

                    // delete current positions
                    $delete_pos = Experience::model()->findAllByAttributes(array('FK_userid' => $user_id));
                    foreach ($delete_pos as $de)
                    {
                        $de->delete();
                    }

                    for ($i = 0; $i < $pos_count; $i++)
                    {
                        $new_pos = new Experience();
                        $new_pos->FK_userid = $user_id;
                        $new_pos->company_name = $data->positions->position[$i]->company->name;
                        $new_pos->job_title = $data->positions->position[$i]->title;
                        $new_pos->job_description = $data->positions->position[$i]->summary;
                        $temp_start_date = $data->positions->position[$i]->{'start-date'}->month . '/01/' . $data->positions->position[$i]->{'start-date'}->year;
                        $new_pos->startdate = date('Y-m-d', strtotime($temp_start_date));
                        if ($data->positions->position[$i]->{'is-current'} == 'true')
                        {
                            $new_pos->enddate = '';
                        }
                        else
                        {
                            $temp_end_date = $data->positions->position[$i]->{'end-date'}->month . '/01/' . $data->positions->position[$i]->{'end-date'}->year;
                            $new_pos->enddate = date('Y-m-d', strtotime($temp_end_date));
                        }
                        $new_pos->city = '';
                        $new_pos->state = '';
                        $new_pos->save(false);
                    }
                    // -----------------EXPERIENCE -------------------
                    // ----------------------SKILLS----------------------
                    // get number of educations to add
                    $linkedin_skill_count = $data->skills['total'];

                    for ($i = 0; $i < $linkedin_skill_count; $i++)
                    {
                        // check if skill exists in skill set table, if not, add it to skill set table
                        if (Skillset::model()->findByAttributes(array('name' => $data->skills->skill[$i]->skill->name)) == null)
                        {
                            $new_skill = new Skillset();
                            $new_skill->name = $data->skills->skill[$i]->skill->name;
                            $new_skill->save(false);
                            //echo 'New Skill ' . $new_skill->attributes;
                        }

                        // check if student has that skill, if not add it to student-skill-map table
                        if (StudentSkillMap::model()->findByAttributes(array('userid' => $user_id,
                                'skillid' => Skillset::model()->findByAttributes(array('name' => $data->skills->skill[$i]->skill->name))->id)) == null)
                        {
                            $new_sdnt_skill = new StudentSkillMap();
                            $new_sdnt_skill->userid = $user_id;
                            $new_sdnt_skill->skillid = Skillset::model()->findByAttributes(array('name' => $data->skills->skill[$i]->skill->name))->id;
                            $new_sdnt_skill->ordering = $i + 1;
                            $new_sdnt_skill->save(false);
                            //echo 'New Skill for student' . $new_sdnt_skill->attributes;
                        }
                    }
                    // ----------------------SKILLS----------------------

                    if ($duplicateUser->disable != 1)
                    {
                        $identity = new UserIdentity($duplicateUser->username, '');
                        if ($identity->authenticateOutside())
                        {
                            Yii::app()->user->login($identity);
                        }
                        $mesg = "LinkedIn";
                        //get variables
                        $mesg = "LinkedIn";

                        $phone = $data->{'phone-numbers'}->{'phone-number'}->{'phone-number'};
                        if ($phone != null)
                        {
                            $phone = strip_tags($data->{'phone-numbers'}->{'phone-number'}->{'phone-number'}->asXML());
                        }

                        $city = $data->location->name;
                        if ($city != null)
                        {
                            $city = strip_tags($data->location->name->asXML());
                        }

                        $state = '';

                        $about_me = $data->headline;
                        if ($about_me != null)
                        {
                            $about_me = strip_tags($data->headline->asXML());
                        }

                        $picture = $data->{'picture-urls'}->{'picture-url'}[0];
                        if ($picture != null)
                        {
                            $picture = strip_tags($data->{'picture-urls'}->{'picture-url'}[0]->asXML());
                        }
                        $this->actionLinkTo($data->{'email-address'}, $data->{'first-name'}, $data->{'last-name'}, $picture, $mesg, $phone, $city, $state, $about_me);
                        return;
                    }
                    else
                    {
                        $this->redirect("/JobFair/index.php/site/page?view=disableUser");
                        return;
                    }
                }
                */
                // Populate user attributes
                $model->FK_usertype = 1;
                $model->registration_date = new CDbExpression('NOW()');
                $model->activation_string = 'linkedin';
                $model->username = $data->emailAddress;
                $model->first_name = $data->firstName;
                $model->last_name = $data->lastName;
                $model->email = $data->emailAddress;
                if(!empty($data->pictureUrl)){
                    $model->image_url = $data->pictureUrl;
                } else {
                    $model->image_url = '/JobFair/images/profileimages/user-default.png';
                }               
                $model->linkedinid = $data->id;
                //Hash the password before storing it into the database
                $hasher = new PasswordHash(8, false);
                $model->password = $hasher->HashPassword('tester');
                $model->activated = 1;
                $model->has_viewed_profile = 1;
                $model->save(false);

                // 		// ------------------BASIC INFO---------------
                $basic_info = null;
                $basic_info = BasicInfo::model()->findByAttributes(array('userid' => $model->id));
                if ($basic_info == null)
                    $basic_info = new BasicInfo();
                $basic_info->userid = $model->id;
                //$basic_info->phone = $data->{'phone-numbers'}->{'phone-number'}->{'phone-number'};
                $basic_info->city = $data->location->name;
                $basic_info->state = '';
                $basic_info->about_me = $data->headline;

                $basic_info->save(false);
                /*
                // WAITING FOR LINKEDIN DEVELOPER ACCOUNT UPGRADE TO ACCESS r_fullprofile 
                // ------------------BASIC INFO -----------------
                // -----------------EDUCATION ----------------------
                // get number of educations to add
                /*$educ_count = $data->educations['total'];

                // delete current educations
                $delete_educs = Education::model()->findAllByAttributes(array('FK_user_id' => $model->id));
                foreach ($delete_educs as $de)
                {
                    $de->delete();
                }

                // add educations
                for ($i = 0; $i < $educ_count; $i++)
                {
                    // first check if current education is in school table. if not, add it
                    $current_school_name = $data->educations->education[$i]->{'school-name'};
                    $school_exists = School::model()->findByAttributes(array('name' => $current_school_name));

                    if ($school_exists == null)
                    {
                        $new_school = new School();
                        $new_school->name = $current_school_name;
                        $new_school->save();
                        $school_id = School::model()->findByAttributes(array('name' => $current_school_name))->id;
                    }
                    else
                    {
                        $school_id = $school_exists->id;
                    }

                    // now ready to add new education
                    $new_educ = new Education();
                    $new_educ->degree = $data->educations->education[$i]->degree;
                    $new_educ->major = $data->educations->education[$i]->{'field-of-study'};
                    // 	   	$model->admission_date=date('Y-m-d',strtotime($model->admission_date));
                    $new_educ->graduation_date = date('Y-m-d', strtotime($data->educations->education[$i]->{'end-date'}->year));
                    // 	   	print "<pre>"; print_r($new_educ->graduation_date);print "</pre>";return;
                    $new_educ->FK_school_id = $school_id;
                    $new_educ->FK_user_id = $model->id;
                    $new_educ->additional_info = $data->educations->education[$i]->notes;
                    $new_educ->save(false);
                }
                // -----------------EDUCATION ----------------------
                // -----------------EXPERIENCE -------------------
                // get number of educations to add
                $pos_count = $data->positions['total'];

                // delete current positions
                $delete_pos = Experience::model()->findAllByAttributes(array('FK_userid' => $model->id));
                foreach ($delete_pos as $de)
                {
                    $de->delete();
                }


                for ($i = 0; $i < $pos_count; $i++)
                {
                    $new_pos = new Experience();
                    $new_pos->FK_userid = $model->id;
                    $new_pos->company_name = $data->positions->position[$i]->company->name;
                    $new_pos->job_title = $data->positions->position[$i]->title;
                    $new_pos->job_description = $data->positions->position[$i]->summary;
                    $temp_start_date = $data->positions->position[$i]->{'start-date'}->month . '/01/' . $data->positions->position[$i]->{'start-date'}->year;
                    $new_pos->startdate = date('Y-m-d', strtotime($temp_start_date));
                    if ($data->positions->position[$i]->{'is-current'} == 'true')
                    {
                        $new_pos->enddate = '';
                    }
                    else
                    {
                        $temp_end_date = $data->positions->position[$i]->{'end-date'}->month . '/01/' . $data->positions->position[$i]->{'end-date'}->year;
                        $new_pos->enddate = date('Y-m-d', strtotime($temp_end_date));
                    }
                    $new_pos->city = '';
                    $new_pos->state = '';
                    $new_pos->save(false);
                }
                // -----------------EXPERIENCE -------------------
                // ----------------------SKILLS----------------------
                // get number of educations to add
                $linkedin_skill_count = $data->skills['total'];
                for ($i = 0; $i < $linkedin_skill_count; $i++)
                {
                    // check if skill exists in skill set table, if not, add it to skill set table
                    if (Skillset::model()->findByAttributes(array('name' => $data->skills->skill[$i]->skill->name)) == null)
                    {
                        $new_skill = new Skillset();
                        $new_skill->name = $data->skills->skill[$i]->skill->name;
                        $new_skill->save(false);
                        //echo 'New Skill ' . $new_skill->attributes;
                    }

                    // check if student has that skill, if not add it to student-skill-map table
                    if (StudentSkillMap::model()->findByAttributes(array('userid' => $model->id,
                            'skillid' => Skillset::model()->findByAttributes(array('name' => $data->skills->skill[$i]->skill->name))->id)) == null)
                    {
                        $new_sdnt_skill = new StudentSkillMap();
                        $new_sdnt_skill->userid = $model->id;
                        $new_sdnt_skill->skillid = Skillset::model()->findByAttributes(array('name' => $data->skills->skill[$i]->skill->name))->id;
                        $new_sdnt_skill->ordering = $i + 1;
                        $new_sdnt_skill->save(false);
                    }
                }*/
                // ----------------------SKILLS----------------------
                // LOGIN
                $user = User::model()->find("username=:username", array(':username' => $model->username));
                $identity = new UserIdentity($user->username, 'tester');
                if ($identity->authenticate())
                {
                    Yii::app()->user->login($identity);
                }
                $this->redirect("/JobFair/index.php/user/ChangeFirstPassword");
            } 
        }

        public function actionChangeFirstPassword()
        {

            $model = User::getCurrentUser();
            $error = '';
            if (isset($_POST['User']))
            {
                $pass = 'tester';
                $p1 = $_POST['User']['password1'];
                $p2 = $_POST['User']['password2'];
                //verify old password
                $username = Yii::app()->user->name;
                $hasher = new PasswordHash(8, false);
                $login = new LoginForm;
                $login->username = $username;
                $login->password = $pass;

                if ($p1 == $p2)
                {
                    //Hash the password before storing it into the database
                    $hasher = new PasswordHash(8, false);
                    $user = User::getCurrentUser();
                    $user->password = $hasher->HashPassword($p1);
                    $user->save(false);
                    $this->redirect("/JobFair/index.php/home/studenthome");
                }
                else
                {
                    $error = "Passwords do not match.";
                    $this->render('ChangeFirstPassword', array('model' => $model, 'error' => $error));
                }
            }
            else
            {
                $this->render('ChangeFirstPassword', array('model' => $model, 'error' => $error));
            }
        }

        public function actionMergeAccounts()
        {

            $model = new LinkTooForm();
            $error = '';

            if (isset($_POST['LinkTooForm']))
            {

                $model = new LinkTooForm();
                $model->attributes = $_POST['LinkTooForm'];

                $username = $model->email;
                $password = $model->password;

                $login = new LoginForm;
                $login->username = $username;
                $login->password = $password;

                $user1 = User::model()->findByAttributes(array('username' => $username));
                $user2 = User::getCurrentUser();

                if ($user1 == null || !$login->validate())
                {
                    $error = "Username or password was incorrect.";
                    $this->render('MergeAccounts', array('model' => $model, 'error' => $error));
                }
                //if user is disable
                elseif ($user1->disable == 1)
                {
                    $error = "User's account is disable.";
                    $this->render('MergeAccounts', array('model' => $model, 'error' => $error));
                }
                else
                {
                    $basic_info = BasicInfo::model()->findByAttributes(array('userid' => $user1->id));

                    //link the third party accounts;
                    $linkedinid = $user1->linkedinid;
                    $googleid = $user1->googleid;
                    $fiucsid = $user1->fiucsid;
                    $fiu_account_id = $user1->fiu_account_id;

                    if ($user2->linkedinid == null && $linkedinid != null)
                    {
                        $user2->linkedinid = $linkedinid;
                        $user1->linkedinid = null;
                        $user2->save(false);
                    }
                    if ($user2->googleid == null && $googleid != null)
                    {
                        $user2->googleid = $googleid;
                        $user1->googleid = null;
                        $user2->save(false);
                    }
                    if ($user2->fiucsid == null && $fiucsid != null)
                    {
                        $user2->fiucsid = $fiucsid;
                        $user1->fiucsid = null;
                        $user2->save(false);
                    }
                    if ($user2->fiu_account_id == null && $fiu_account_id != null)
                    {
                        $user2->fiu_account_id = $fiu_account_id;
                        $user1->fiu_account_id = null;
                        $user2->save(false);
                    }

                    //disable user
                    $user1->disable = 1;
                    $user1->save(false);

                    //get basic info
                    $first_name = $user1->first_name;
                    $last_name = $user1->last_name;
                    $email = $user1->email;
                    $picture = $user1->image_url;
                    $mesg = "Virtual Job Fair";
                    $phone = $basic_info->phone;
                    $city = $basic_info->city;
                    $state = $basic_info->state;
                    $about_me = $basic_info->about_me;

                    //get education
                    $education1 = Education::model()->find('FK_user_id=:id', array(':id' => $user1->id));
                    $education2 = Education::model()->find('FK_user_id=:id', array(':id' => $user2->id));

                    if ($education1 != null && $education2 == null)
                    {

                        $education1->FK_user_id = $user2->id;
                        $education1->save(false);
                    }

                    if ($education1 != null && $education2 != null)
                    {
                        if ($education1->FK_school_id != $education2->FK_school_id)
                        {
                            $education1->FK_user_id = $user2->id;
                            $education1->save(false);
                        }
                    }
                    //get experience
                    $experience1 = Experience::model()->find('FK_userid=:id', array(':id' => $user1->id));
                    $experience2 = Experience::model()->find('FK_userid=:id', array(':id' => $user2->id));



                    if ($experience1 != null && $experience2 == null)
                    {

                        $experience1->FK_userid = $user2->id;
                        $experience1->save(false);
                    }
                    if ($experience1 != null && $experience2 != null)
                    {
                        if ($experience1->company_name != $experience2->company_name)
                        {
                            $experience1->FK_userid = $user2->id;
                            $experience1->save(false);
                        }
                    }
                    //get skill

                    $this->actionLinkTo($email, $first_name, $last_name, $picture, $mesg, $phone, $city, $state, $about_me);
                    return;
                }
//
            }
            else
            {
                $this->render('MergeAccounts', array('model' => $model, 'error' => $error));
            }
        }

        public function actionAuth1()
        {
            $this->actionRegisterLinkedIn();
        }

        /*
         * Get notifications. These are not actually emails, just  system notifications.
         */
        public function actionToggleEmailMatch()
        {
            // print_r("its getting here");
            if (isset($_GET['value']))
            {
                // print_r("its getting here");
                $val = intval($_GET['value']);
                $val = ($val == 0) ? 1 : 0;
                $current_user = User::getCurrentUser();
                $current_user->job_notification = $val;
                $current_user->save(false);
                echo json_encode(Array("status" => $val));
            }
        }

        /*
         * Handles the publication of the video or not.
         */

        public function actionTogglePublishedVideo()
        {
            if (isset($_GET['value']))
            {
                $val = intval($_GET['value']);
                $val = ($val == 0) ? 1 : 0;

                $currentUser = User::getCurrentUser();
                $videoresume = VideoResume::model()->findByPk($currentUser->id);
                $videoresume->publish_video = $val;
                $videoresume->save(true);

                echo json_encode(Array("status" => $val));
            }
        }

        public function actionDuplicationError()
        {
            //$model = User::getCurrentUser();
            //$error = '';
            //,array('model'=>$model, 'error' => $error)
            $this->render('duplicationError');
        }

        public function actionStudentHelpReg($email)
        {
            $model = new LinkTooForm();
            $this->render('StudentHelpReg', array('model' => $model, 'email' => $email));
        }

        public function actionLinkTo($email, $first_name, $last_name, $picture, $mesg, $phone, $city, $state, $about_me)
        {
            $model = new LinkTooForm();
            $this->render('LinkTo', array('model' => $model, 'email' => $email, 'first_name' => $first_name, 'last_name' => $last_name,
                'picture' => $picture, 'mesg' => $mesg, 'phone' => $phone, 'city' => $city, 'state' => $state, 'about_me' => $about_me));

            //return $link;
        }

        public function actionUserChoice()
        {

            if (isset($_POST['LinkTooForm']))
            {
                $user = User::getCurrentUser();
                $basic_info = BasicInfo::model()->findByAttributes(array('userid' => $user->id));

                $model = new LinkTooForm();
                $model->attributes = $_POST['LinkTooForm'];
                $mesg = $model->toPost;

                if ($model->profilePic != null)
                {
                    $user->image_url = $model->profilePic;
                    $user->save(false);
                }
                if ($model->profilePicVar != null)
                {
                    $user->image_url = $model->profilePicVar;
                    $user->save(false);
                }
                if ($model->firstname != null)
                {
                    $user->first_name = $model->firstname;
                    $user->save(false);
                }
                if ($model->firstnamevar != null)
                {
                    $user->first_name = $model->firstnamevar;
                    $user->save(false);
                }
                if ($model->lastname != null)
                {
                    $user->last_name = $model->lastname;
                    $user->save(false);
                }
                if ($model->lastnamevar != null)
                {
                    $user->last_name = $model->lastnamevar;
                    $user->save(false);
                }
                if ($model->email != null)
                {
                    $user->email = $model->email;
                    $user->save(false);
                }
                if ($model->emailvar != null)
                {
                    $user->email = $model->emailvar;
                    $user->save(false);
                }
                if ($model->phone != null)
                {
                    $basic_info->phone = $model->phone;
                    $basic_info->save(false);
                }
                if ($model->phonevar != null)
                {
                    $basic_info->phone = $model->phonevar;
                    $basic_info->save(false);
                }
                if ($model->city != null)
                {
                    $basic_info->city = $model->city;
                    $basic_info->save(false);
                }
                if ($model->cityvar != null)
                {
                    $basic_info->city = $model->cityvar;
                    $basic_info->save(false);
                }
                if ($model->state != null)
                {
                    $basic_info->state = $model->state;
                    $basic_info->save(false);
                }
                if ($model->statevar != null)
                {
                    $basic_info->state = $model->statevar;
                    $basic_info->save(false);
                }
                if ($model->about_me != null)
                {
                    $basic_info->about_me = $model->about_me;
                    $basic_info->save(false);
                }
                if ($model->about_me_var != null)
                {
                    $basic_info->about_me = $model->about_me_var;
                    $basic_info->save(false);
                }
            }
            Yii::app()->end();
        }

        public function actionLinkNotification($mesg)
        {
            $model = new LinkTooForm();
            $this->render('LinkNotification', array('model' => $model, 'mesg' => $mesg));
        }

        public function actionToggleLookingForJob()
        {
            if (isset($_GET['value']))
            {
                $val = intval($_GET['value']);
                $val = ($val == 0) ? 1 : 0;
                $current_user = User::getCurrentUser();
                $current_user->looking_for_job = $val;
                $current_user->save(false);
                echo json_encode(Array("status" => $val));
            }
        }

        // Uncomment the following methods and override them if needed
        /*
          public function filters()
          {
          // return the filter configuration for this controller, e.g.:
          return array(
          'inlineFilterName',
          array(
          'class'=>'path.to.FilterClass',
          'propertyName'=>'propertyValue',
          ),
          );
          }

          public function actions()
          {
          // return external action classes, e.g.:
          return array(
          'action1'=>'path.to.ActionClass',
          'action2'=>array(
          'class'=>'path.to.AnotherActionClass',
          'propertyName'=>'propertyValue',
          ),
          );
          }
         */


        public function actionGuestEmployerAuth()
        {
            /*
             *  Authenticates a Guest Employer User 
             */

            $user = new User();
            $user = User::model()->getGuestEmployerUser();

            if ($user->disable != 0)
            {
                $this->redirect("/JobFair/index.php/site/page?view=disableUser");
            }

            $userIdentity = new UserIdentity($user->username, $user->password);

            if ($userIdentity->authenticateOutside())
            {
                Yii::app()->user->login($userIdentity);

                $notification = Notification::model()->getNotificationId($user->id); // pass the notifications
                $univs = School::getAllSchools(); // pass universities
                $skills = Skillset::getNames(); // pass skills
                $countvideo = 0;
                $countapplicants = 0;
                $countmessages = 0;
                $countcandidates = 0;
                foreach ($notification as $n)
                {
                    if ($n->importancy == 4 & $n->been_read == 0)
                    {
                        $countvideo++;
                        $key = VideoInterview::model()->findByAttributes(array('notification_id' => $n->id));
                        if ($key != null)
                        {
                            $n->keyid = $key->session_key;
                            //print "<pre>"; print_r($key);print "</pre>";return;
                        }
                    }
                    else if ($n->importancy == 4 & $n->been_read != 0)
                    {
                        //$countvideo++;
                        $key = VideoInterview::model()->findByAttributes(array('notification_id' => $n->id));
                        if ($key != null)
                        {
                            $n->keyid = $key->session_key;
                            //print "<pre>"; print_r($key);print "</pre>";return;
                        }
                    }
                    elseif ($n->importancy == 6 & $n->been_read == 0)
                        $countapplicants++;
                    elseif ($n->importancy == 3 & $n->been_read == 0)
                        $countmessages++;
                    elseif ($n->importancy == 5 & $n->been_read == 0)
                        $countcandidates++;
                }

                $this->render('guestEmployerAuth', array(
                    'user' => $user,
                    'universities' => $univs,
                    'skills' => $skills,
                    'notification' => $notification,
                    'countvideo' => $countvideo,
                    'countapplicants' => $countapplicants,
                    'countmessages' => $countmessages,
                    'countcndidates' => $countcandidates));
            }

            //Redirect to the contact form of the site due to failed authentication
            //Crate array with information to be shown to the user
            //TODO
            //$this->redirect('');
        }

        public function actionGuestAuth()
        {
            $user = new User();
            $user = User::model()->getGuestStudentUser();

            if($user->disable != 0)
                $this->redirect("/JobFair/index.php/site/page?view=disableUser");

            $userIdentity = new UserIdentity($user->username, $user->password);

            if ($userIdentity->authenticateOutside())
            {
                Yii::app()->user->login($userIdentity);

                //Prepare Dashboard Objects for Guest Student

                $companies = CompanyInfo::getNames(); // pass the companies;
                $skills = Skillset::getNames(); // pass the skills;
                $notification = Notification::model()->getNotificationId($user->id); // pass the notifications;


                $criteria = new CDbCriteria();
                $criteria = array(
                    'group' => 'skillid',
                    'select' => 'skillid,count(*) as cc',
                    'order' => 'cc desc'
                );

                $skillids = JobSkillMap::model()->findAll($criteria);

                $most_wanted_skills = Array();
                $i = 0;

                foreach ($skillids as $sk)
                {
                    $most_wanted_skills[] = Skillset::model()->findByAttributes(array('id' => $sk->skillid));
                    $i++;
                    if ($i == 5)
                    {
                        break;
                    }
                }

                $countvideo = 0;
                $countmachingjobs = 0;
                $countmessages = 0;
                $countmisc = 0;

                if(User::isCurrentUserGuestStudent())
                {
                   $this->redirect('/JobFair/index.php/home/studenthome');
                
                    //Send to his home page
                    /*$this->render('/home/studenthome', array('user' => $user,
                        'companies' => $companies,
                        'skills' => $skills, 'notification' => $notification,
                        'mostwanted' => $most_wanted_skills,
                        'countvideo' => $countvideo,
                        'countmachingjobs' => $countmachingjobs,
                        'countmessages' => $countmessages,
                        'countmisc' => $countmisc));*/
                }
            }
            //Redirect to the contact form of the site due to failed authentication
            //Crate array with information to be shown to the user
            //TODO
            //$this->render('guestStudentAuth');
        }

    }
    