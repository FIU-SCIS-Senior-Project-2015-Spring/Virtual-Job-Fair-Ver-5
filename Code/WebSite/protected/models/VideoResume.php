<?php

    /**
     * This is the model class for table "video_resume".
     *
     * The followings are the available columns in table 'video_resume':
     * @property integer $id
     * @property string $video_path
     * 
     * @author Rene Alfonso
     */
    class VideoResume extends CActiveRecord
    {

        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return VideoResume the static model class
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
            return 'video_resume';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('id', 'required'),
                array('id', 'numerical', 'integerOnly' => true),
                array('video_path', 'length', 'max' => 100),
                array('video_path', 'file', 'types' => 'mp4, mov, MP4, MOV', 'allowEmpty' => true, 'on' => 'update'),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('id', 'safe', 'on' => 'search'),
            );
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
            // NOTE: you may need to adjust the relation name and the related
            // class name for the relations automatically generated below.
            return array(
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'video_path' => 'Youtube Video Path',
                'publish_video' => 'Publish Video',
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
            $criteria->compare('video_path', $this->video_path, true);
            $criteria->compare('publish_video', $this->publish_video);

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }

    }
    