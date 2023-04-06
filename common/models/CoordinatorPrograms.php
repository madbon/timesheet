<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "coordinator_programs".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $ref_program_id
 * @property int|null $ref_program_major_id
 */
class CoordinatorPrograms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coordinator_programs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id','ref_program_id'],'required'],
            [['user_id', 'ref_program_id', 'ref_program_major_id'], 'integer'],
            [['ref_program_id'], 'unique', 'targetAttribute' => ['ref_program_id','user_id'], 'message' => 'You have already assigned this Program to this OJT Coordinator']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'OJT Coordinator',
            'ref_program_id' => 'Program/Course',
            'ref_program_major_id' => 'Major',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(UserData::class, ['id' => 'user_id']); 
    }

    public function getProgram()
    {
        return $this->hasOne(RefProgram::class, ['id' => 'ref_program_id']); 
    }
}
