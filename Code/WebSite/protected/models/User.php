<?php

    /**
     * This is the model class for table "user".
     *
     * The followings are the available columns in table 'user':
     * @property integer $id
     * @property string $username
     * @property string $password
     * @property integer $FK_usertype
     * @property string $email
     * @property string $registration_date
     * @property string $activation_string
     * @property integer $activated
     * @property string $image_url
     * @property string $first_name
     * @property string $last_name
     * @property int $disable
     * @property boolean $hide_email
     * @property boolean $job_notification
     * @property boolean $looking_for_job
     * @property boolean $job_int_date

     *
     * The followings are the available model relations:
     * @property Application[] $applications
     * @property BasicInfo $basicInfo
     * @property CompanyInfo $companyInfo
     * @property Education[] $educations
     * @property Experience[] $experiences
     * @property Job[] $jobs
     * @property Message[] messagesReceived
     * @property Message[] messagesSent
     * @property Rating[] $rating
     * @property SessionSubscriberMap[] $sessionSubscriberMaps
     * @property SessionSubscriberMap[] $sessionSubscriberMaps1
     * @property StudentSkillMap[] $studentSkillMaps
     * @property Usertype $fKUsertype
     * @property Profilefield[] $profilefields
     * @property VideoSession[] $videoSessions
     */
    class User extends CActiveRecord
    {

        public $password_repeat;
        public $skillrating;

        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return User the static model class
         */
        public static function model($className = __CLASS__)
        {
            return parent::model($className);
        }

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
            return 'user';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('username, password, password_repeat, email, first_name, last_name, hide_email', 'required'),
                array('username, email', 'unique'),
                array('password', 'compare'),
                array('password_repeat', 'safe'),
                array('email', 'email'),
                array('username, password, email, activation_string, first_name, last_name', 'length', 'max' => 45),
                array('image_url', 'length', 'max' => 255),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('id, username, password, FK_usertype, email, registration_date, activation_string, image_url, first_name, last_name', 'safe', 'on' => 'search'),
                array('image_url', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true, 'on' => 'update'),
                // Added to activate/deactivate user.
                array('activated', 'required'),
            );
        }

        /**
         * Validates user password
         * @return boolean whether the password is valid
         */
        public function validatePassword($password)
        {
            $hasher = new PasswordHash(8, false);
            return $hasher->CheckPassword($password, $this->password);
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
            // NOTE: you may need to adjust the relation name and the related
            // class name for the relations automatically generated below.
            //print "test";
            return array(
                'applications' => array(self::HAS_MANY, 'Application', 'userid'),
                'basicInfo' => array(self::HAS_ONE, 'BasicInfo', 'userid'),
                'companyInfo' => array(self::HAS_ONE, 'CompanyInfo', 'FK_userid'),
                'educations' => array(self::HAS_MANY, 'Education', 'FK_user_id'),
                'experiences' => array(self::HAS_MANY, 'Experience', 'FK_userid'),
                'jobs' => array(self::HAS_MANY, 'Job', 'FK_poster'),
                'messagesReceived' => array(self::HAS_MANY, 'Message', 'FK_receiver'),
                'messagesSent' => array(self::HAS_MANY, 'Message', 'FK_sender'),
                'rating' => array(self::HAS_MANY, 'Rating', 'FK_studentId'),
                'sessionSubscriberMaps' => array(self::HAS_MANY, 'SessionSubscriberMap', 'studentid'),
                'sessionSubscriberMaps1' => array(self::HAS_MANY, 'SessionSubscriberMap', 'sessionid'),
                'studentSkillMaps' => array(self::HAS_MANY, 'StudentSkillMap', 'userid', 'order' => 'ordering ASC'),
                'fKUsertype' => array(self::BELONGS_TO, 'Usertype', 'FK_usertype'),
                'profilefields' => array(self::MANY_MANY, 'Profilefield', 'user_profilefield_map(userid, fieldid)'),
                'videoSessions' => array(self::HAS_MANY, 'VideoSession', 'FK_host'),
                'resume' => array(self::HAS_ONE, 'Resume', 'id'),
                'notifications' => array(self::HAS_MANY, 'Notification', 'receiver_id'),
                'vidResume' => array(self::HAS_ONE, 'VideoResume', 'id'),
                'coverletter' => array(self::HAS_ONE, 'CoverLetter', 'id'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'username' => 'Username',
                'password' => 'Password',
                'password_repeat' => 'Re-type Password',
                'FK_usertype' => 'Fk Usertype',
                'email' => 'Email',
                'registration_date' => 'Registration Date',
                'activation_string' => 'Activation String',
                'image_url' => 'Image Url',
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
                'hide_email' => 'Hide email from students?',
                'disable' => "Disable",
                'job_notification' => "Job Match Notifications",
                'looking_for_job' => "Searching for job",
                'activated' => "Activated",
            );
        }

        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;

            $criteria->compare('id', $this->id);
            $criteria->compare('username', $this->username, true);
            $criteria->compare('password', $this->password, true);
            $criteria->compare('FK_usertype', $this->FK_usertype);
            $criteria->compare('email', $this->email, true);
            $criteria->compare('registration_date', $this->registration_date, true);
            $criteria->compare('activation_string', $this->activation_string, true);
            $criteria->compare('activated', $this->activated);
            $criteria->compare('image_url', $this->image_url, true);
            $criteria->compare('first_name', $this->first_name, true);
            $criteria->compare('last_name', $this->last_name, true);
            $criteria->compare('disable', $this->disable, true);
            $criteria->compare('job_notification', $this->job_notification, true);
            $criteria->compare('looking_for_job', $this->looking_for_job, true);
            $criteria->compare('job_int_date', $this->job_int_date, true);

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }

        private static function constructEmailObject()
        {
//        $mail = new YiiMailer();
//        $mail->IsSMTP();
//        $mail->Host = 'smtp.gmail.com';
//        $mail->Port = 587;
//        $mail->SMTPSecure= 'tls';
//        $mail->SMTPAuth = true;
//        $mail->Username = "virtualjobfairfiu";
//        $mail->Password = 'cis49112014';
//        $mail->setView('contact');
//        $mail->setLayout('mail');
//        $mail->setFrom('virtualjobfair_no-reply@cs.fiu.edu', 'Virtual Job Fair');
//        return $mail;
            $mail = new YiiMailer();
            $mail->IsSMTP();
            $mail->Host = 'smtp.cs.fiu.edu';
            $mail->Port = 25;
            $mail->SMTPAuth = false;
            $mail->setView('contact');
            $mail->setLayout('mail');
            $mail->setFrom('virtualjobfair_no-reply@cs.fiu.edu', 'Virtual Job Fair');
            return $mail;
        }

        public static function sendEmail($to, $subject, $email_description, $message)
        {
            $email = self::constructEmailObject();
            $email->setTo($to);
            $email->setSubject($subject);
            $email->setData(array('message' => $message,
                'name' => 'Virtual Job Fair',
                'description' => $email_description));

            //added this to check if it was sending
            if ($email->send())
            {
                $message = "this send is sending";
                error_log($message);
            }
            else
            {
                $message = "the sending is failing";
                error_log($message);
                exit;
            }
        }

        public function isAStudent()
        {
            return ($this->FK_usertype == 1);
        }

        public function isMatchNotificationSet()
        {
            return ($this->job_notification == 1);
        }

        public function isLookingForJob()
        {
            return ($this->looking_for_job == 1);
        }

        public function isAEmployer()
        {
            return ($this->FK_usertype == 2);
        }

        public function isAAdmin()
        {
            return ($this->FK_usertype == 3);
        }

        public function isAGuestEmployer()
        {
            return ($this->FK_usertype == 5);
        }

        public function isAGuestStudent()
        {
            return ($this->FK_usertype == 4);
        }

        public function cascade_delete()
        {
            $id = $this->id;

            try
            {
                // Delete Cover Letter.
                $coverletter = CoverLetter::model()->findByPk($id);
                if(isset($coverletter))
                {
                    $path = $coverletter->file_path;

                    // Check if file exists before trying to delete it.
                    if(file_exists(Yii::app()->basePath.'/..'.substr($path, 8)))
                        unlink(Yii::app()->basePath.'/..'.substr($path, 8));

                    $coverletter->delete();
                }

                // Delete Resume.
                $resume = Resume::model()->findByPk($id);
                if(isset($resume))
                {
                    // Delete file from system.
                    $path = $resume->resume;

                    if(file_exists(Yii::app()->basePath.'/..'.substr($path, 8)))
                        unlink(Yii::app()->basePath.'/..'.substr($path, 8));

                    $resume->delete();
                }

                // Delete Video Resume.
                $vidResume = VideoResume::model()->findByPk($id);
                if(isset($vidResume))
                {
                    // Check if user has a video resume on YouTube.
                    if(!empty($vidResume->video_path))
                    {
                        include Yii::app()->basePath . '/youtube_subsystem/YouTubeHandler.php';

                        // Delete the video resume from youtube.
                        $yHandler = new YouTubeHandler();
                        $yHandler->deleteVideo($vidResume);

                    }       

                    $vidResume->delete();
                }

                // Profile picture.
                $profileImagePath = $this->image_url;
                if(!empty($profileImagePath) && strcmp($profileImagePath, "/JobFair/images/profileimages/user-default.png") != 0 && file_exists(Yii::app()->basePath.'/..'.substr($profileImagePath, 8)))
                    unlink(Yii::app()->basePath.'/..'.substr($profileImagePath, 8));


                // delete basic info mappings
                $basic_info = BasicInfo::model()->findByAttributes(array('userid' => $id));
                if (isset($basic_info))
                    $basic_info->delete();

                // delete company info mapping
                $comp_info = CompanyInfo::model()->findByAttributes(array('FK_userid' => $id));
                if (isset($comp_info))
                    $comp_info->delete();

                // delete sms mappings
                $sms_mappings = SMS::model()->findAll("sender_id=:id OR receiver_id=:id ", array(':id' => $id));
                foreach ($sms_mappings as $sms_mapping)
                {
                    $sms_mapping->delete();
                }

                // delete education mapping
                $edu_mappings = Education::model()->findAllByAttributes(array('FK_user_id' => $id));
                foreach ($edu_mappings as $edu_mapping)
                {
                    $edu_mapping->delete();
                }

                // delete skills mappings
                $skills_mappings = StudentSkillMap::model()->findAllByAttributes(array('userid' => $id));
                foreach ($skills_mappings as $skills_mapping)
                {
                    $skills_mapping->delete();
                }

                // delete application mappings
                $app_mappings = Application::model()->findAllByAttributes(array('userid' => $id));
                foreach ($app_mappings as $app_mapping)
                {
                    $app_mapping->delete();
                }

                // delete jobs mappings
                $job_mappings = Job::model()->findAllByAttributes(array('FK_poster' => $id));
                foreach ($job_mappings as $job_mapping)
                {
                    $job_mapping->cascade_delete();
                }

                //deletes saved queries
                $saved_queries = SavedQuery::model()->findAllByAttributes(array('FK_userid' => $id));
                foreach ($saved_queries as $saved_query)
                {
                    $saved_query->delete();
                }

                //deletes experience
                $experience = Experience::model()->findAllByAttributes(array('FK_userid' => $id));
                foreach ($experience as $exp)
                {
                    $exp->delete();
                }

                //deletes messages
                $saved_messages = Message::model()->findAllByAttributes(array('FK_receiver' => $this->username));
                foreach ($saved_messages as $saved_message)
                {
                    $saved_message->delete();
                }
                $saved_messages = Message::model()->findAllByAttributes(array('FK_sender' => $this->username));
                foreach ($saved_messages as $saved_message)
                {
                    $saved_message->delete();
                }

                //deletes handshake
                $saved_handshakes = Handshake::model()->findAllByAttributes(array('studentid' => $id));
                foreach ($saved_handshakes as $saved_handshake)
                {
                    $saved_handshake->delete();
                }
                $saved_handshakes = Handshake::model()->findAllByAttributes(array('employerid' => $id));
                foreach ($saved_handshakes as $saved_handshake)
                {
                    $saved_handshake->delete();
                }

                $this->delete();
            }
            
            catch(Exception $e)
            {
                
            }
        }

        /**
         * Rene.
         * Activates a user or deactivates it. 
         */
        public static function setUserActive($id, $val)
        {
            $user = User::model()->findByPk($id);
            $user->activated = $val;
            $user->save(false);
        }

        /**
         * Disables a user.
         * @param type $userid The user id.
         */
        public static function deActivateUser($userId)
        {
            setUserActive($userId, 0);
        }

        /**
         * Activate a user.
         * @param type $userid The user id.
         */
        public static function activateUser($userId)
        {
            setUserActive($userId, 1);
        }

        public static function isCurrentUserStudent()
        {
            $username = Yii::app()->user->name;
            $user = User::model()->find("username=:username", array(':username' => $username));
            if ($user == null)
                return false;
            return ($user->FK_usertype == 1);
        }

        public static function isCurrentUserAdmin()
        {
            $username = Yii::app()->user->name;
            $user = User::model()->find("username=:username", array(':username' => $username));
            if ($user == null)
                return false;
            return ($user->FK_usertype == 3);
        }

        public static function isCurrentUserEmployer()
        {
            $username = Yii::app()->user->name;
            $user = User::model()->find("username=:username", array(':username' => $username));
            if ($user == null)
                return false;
            return ($user->FK_usertype == 2);
        }

        public static function isCurrentUserGuestStudent()
        {
            $username = Yii::app()->user->name;
            $user = User::model()->find("username=:username", array(':username' => $username));
            if ($user == null)
                return false;
            return ($user->FK_usertype == 4);
        }

        public static function isCurrentUserGuestEmployer()
        {
            $username = Yii::app()->user->name;
            $user = User::model()->find("username=:username", array(':username' => $username));
            if ($user == null)
                return false;
            return ($user->FK_usertype == 5);
        }

        //Return the Guest Employer User
        public static function getGuestEmployerUser()
        {
            $user = User::model()->findbyAttributes(array('FK_usertype' => 5));

            return $user;
        }

        //Check if the Guest Student Account is disable
        public static function getGuestStudentUser()
        {
            $user = User::model()->findbyAttributes(array('FK_usertype' => 4));

            return $user;
        }

        public static function isStudent($username)
        {
            $user = User::model()->find("username=:username", array(':username' => $username));
            if ($user == null)
            {
                return false;
            }
            return ($user->FK_usertype == 1);
        }

        //adds comments to here from down 
        //Note that this function does not take into account Guest users (students or employers)
        public static function countUsers()
        {
            return $count = User::model()->count();
        }

        public static function countStudents()
        {
            $count = 0;
            $students = User::model()->findAllByAttributes(array('FK_usertype' => 1));
            foreach ($students as $student)
            {
                $count++;
            }
            return $count;
        }

        public static function countactiveStudents()
        {
            $count = 0;
            $students = User::model()->findAllByAttributes(array('FK_usertype' => 1, 'activated' => 1));
            foreach ($students as $student)
            {
                $count++;
            }
            return $count;
        }

        public static function countactiveEmployers()
        {
            $count = 0;
            $employers = User::model()->findAllByAttributes(array('FK_usertype' => 2, 'activated' => 1));
            foreach ($employers as $employer)
            {
                $count++;
            }
            return $count;
        }

        public static function countAdmin()
        {
            $count = 0;
            $admin = User::model()->findAllByAttributes(array('FK_usertype' => 3));
            foreach ($admin as $admin)
            {
                $count++;
            }
            return $count;
        }

        public static function countEmployers()
        {
            $count = 0;
            $employers = User::model()->findAllByAttributes(array('FK_usertype' => 2));
            foreach ($employers as $employers)
            {
                $count++;
            }
            return $count;
        }

        public static function countJobs()
        {
            return $count = Job::model()->count();
        }

        public static function countactiveJobs()
        {
            $count = 0;
            $jobs = Job::model()->findAllByAttributes(array('active' => 1));
            foreach ($jobs as $jobs)
            {
                $count++;
            }
            return $count;
        }

        //stop here
        public static function sendAllStudentVerificationAlart($id, $username, $email, $message, $link)
        {


            $students = User::model()->findAllByAttributes(array('FK_usertype' => 1));

            foreach ($students as $student)
            {
                $model = new Notification;
                $model->sender_id = $id;
                $model->receiver_id = $student->id;
                date_default_timezone_set('America/New_York');
                $model->datetime = date('Y-m-d H:i:s');
                $model->been_read = 0;
                $model->importancy = 1;
                $model->message = $message; //$username. " just join our website, check there jobpost and apply... ";
                $model->link = $link;
                $model->save(false);
            }


            return;
        }

        public static function sendSchedualNotificationAlart($sender, $reciver, $message, $link)
        {

            $model = new Notification;
            $model->sender_id = $sender;
            $model->receiver_id = $reciver;
            $model->datetime = date('Y-m-d H:i:s');
            $model->been_read = 0;
            $model->message = $message;
            $model->importancy = 4;
            $model->link = $link;
            $model->save(false);
        }

        public static function sendEmployerNotificationAlart($sender, $reciver, $message, $link, $level)
        {

            $model = new Notification;
            $model->sender_id = $sender;
            $model->receiver_id = $reciver;
            $model->datetime = date('Y-m-d H:i:s');
            $model->been_read = 0;
            $model->message = $message;
            $model->link = $link;
            $model->importancy = 6;
            $model->save(false);
        }



        public static function sendUserNotificationHandshakeAlart($sender, $reciver, $link, $message)
        {

            $model = new Notification;
            $model->sender_id = $sender;

            $model->receiver_id = $reciver;
            $model->datetime = date('Y-m-d H:i:s');
            $model->been_read = 0;
            $model->link = $link;
            //print "<pre>"; print_r($model->link);print "</pre>";return;
            $model->message = $message;
            $model->importancy = 2;
            $model->save(false);
        }

        // Rene: This function has been deprecated and added to the NotificationController
        public static function sendStudentNotificationMatchJobAlart($sender, $reciver, $link, $message)
        {
            /*$model = new Notification;
            $model->sender_id = $sender;

            $model->receiver_id = $reciver;
            date_default_timezone_set('America/New_York');
            $model->datetime = date('Y-m-d H:i:s');
            $model->been_read = 0;
            $model->link = $link;
            //print "<pre>"; print_r($model->link);print "</pre>";return;
            $model->message = $message;
            $model->importancy = 2;
            $model->save(false);*/
        }

        
        public static function sendAdminNotificationNewEmpolyer($employer, $admins, $link, $message)
        {
            foreach ($admins as $admin)
            {
                $model = new Notification();
                $model->sender_id = $employer->id;
                $model->receiver_id = $admin->id;
                $model->datetime = date('Y-m-d H:i:s');
                $model->been_read = 0;
                $model->link = $link;
                //print "<pre>"; print_r($model->link);print "</pre>";return;
                $model->message = $message;
                $model->importancy = 1;
                $model->save(false);
            }
        }

        public static function sendEmployerNotificationStudentAcceptIntervie($sender, $reciver)
        {

            $model = new Notification;
            $student = User::model()->findByPk($sender);
            $model->sender_id = $sender;
            $model->receiver_id = $reciver;
            $model->datetime = date('Y-m-d H:i:s');
            $model->been_read = 0;
            $model->message = "$student->username just accept the interview invitation";
            $model->importancy = 4;
            $model->link = $student->username;
            $model->save(false);
        }

        public static function getCurrentUser()
        {
            $username = Yii::app()->user->name;
            $user = User::model()->find("username=:username", array(':username' => $username));
            return $user;
        }

        public static function getUser($userid)
        {
            $user = User::model()->findByPk($userid);
            return $user;
        }

        public static function getUserName($userid)
        {
            $user = User::model()->findByPk($userid);
            return $user->username;
        }

        public static function activeEmployer($id)
        {
            $user = user::model()->findByPk($id);
            $user->activated = 1;
            $user->save(false);
        }

        //Activates the Guest Employer Account
        public static function activateGuestEmployerAcct()
        {
            //Fetch the user row from the database
            $user = User::model()->find('FK_usertype=:FK_usertype', array('FK_usertype' => 5));
            //Set the user active by being 1
            $user->activated = 1;
            //Save to the database without validating
            $user->save(false);
        }

        //Deactivates the Guest Employer Account
        public static function deactivateGuestEmployerAcct()
        {
            $user = User::model()->find('FK_usertype=:FK_usertype', array('FK_usertype' => 5));
            $user->activated = 0;
            $user->save(false);
        }

        //Activates the Guest Student Account
        public static function activateGuestStudentAcct()
        {
            $user = User::model()->find('FK_usertype=:FK_usertype', array('FK_usertype' => 4));
            $user->activated = 0;
            $user->save(false);
        }

        //Deactivates the Guest Student Account
        public static function deactivateGuestStudentAcct()
        {
            $user = User::model()->find('FK_usertype=:FK_usertype', array('FK_usertype' => 4));
            $user->activated = 0;
            $user->save(false);
        }

        //Retrieve Guest Employer Current password for authentication
        public static function getGuestEmployerPass()
        {
            $user = User::model()->find('FK_usertype=:FK_usertype', array('FK_usertype' => 5));
            $pass = $user->password;
            return ($pass);
        }

        public static function replaceMessage($to, $message)
        {
            try {
            $base = Yii::app()->basePath;
            $base = explode('/', $base);
            array_pop($base);
            $base = implode('/', $base);
            $file = fopen($base . "/email/index1.html", "r");
            $html = "";
            while (!feof($file))
            {
                $html .= fgets($file);
            }
            $html = str_replace("%USER%", $to, $html);
            $html = str_replace("%MESSAGE%", $message, $html);
            return $html;
            } catch (Exception $e){
                
            }
        }

    }
    