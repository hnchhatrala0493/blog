<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blogs".
 *
 * @property int $blog_id
 * @property string $blog_title
 * @property string|null $blog_description
 * @property string|null $blog_image
 * @property string|null $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int|null $updated_by
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blogs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['blog_title', 'created_by'], 'required'],
            [['blog_description', 'status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['blog_title', 'blog_image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'blog_id' => 'Blog ID',
            'blog_title' => 'Blog Title',
            'blog_description' => 'Blog Description',
            'blog_image' => 'Blog Image',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
