<?php

namespace backend\controllers;

use common\models\User;
use Yii;
use yii\db\Query;
use yii\web\Response;
use yii\web\UploadedFile;

class BlogController extends \yii\web\Controller {

    public function beforeAction( $action ) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction( $action );
    }

    public function actionIndex() {
        $query = new Query();
        $bloglist = $query->select( '*' )
        ->from( 'blogs' )
        ->all();
        return json_encode( [ 'data'=>$bloglist ] );
    }

    public function actionCreate() {
        $blog_title = Yii::$app->request->post( 'blog_title' );
        $blog_description = Yii::$app->request->post( 'blog_description' );
        $status = Yii::$app->request->post( 'status' );
        //Yii::$app->response->format = Response::FORMAT_JSON;

        $uploadedFile = UploadedFile::getInstanceByName( 'blog_image' );
        // 'image' should match the name in your form data

        if ( $uploadedFile === null ) {
            return [ 'error' => 'No file uploaded.' ];
        }

        // Generate unique file name to prevent conflicts
        $fileName = 'image_' . time() . '.' . $uploadedFile->getExtension();

        // Path where the image will be saved
        $uploadPath = Yii::getAlias( '@backend/web/uploads/' ) . $fileName;

        // Move the uploaded file to the specified path
        if ( !$uploadedFile->saveAs( $uploadPath ) ) {
            return [ 'error' => 'Failed to upload file.' ];
        }

        $blog = Yii::$app->db->createCommand()->insert( 'blogs', [
            'blog_title' => $blog_title,
            'blog_description' => $blog_description,
            'status'=>$status,
            'blog_image'=>$fileName,
            'created_by'=>1
        ] )->execute();
        if ( $blog>0 ) {
            return json_encode( [ 'result'=>'success', 'messages'=>'Record Added Successfully' ] );
        }
    }

    public function actionUpdate() {
        $blog_title = Yii::$app->request->post( 'blog_title' );
        $blog_description = Yii::$app->request->post( 'blog_description' );
        $status = Yii::$app->request->post( 'status' );
        $id = Yii::$app->request->post( 'blog_id' );
        //Yii::$app->response->format = Response::FORMAT_JSON;

        $uploadedFile = UploadedFile::getInstanceByName( 'blog_image' );
        // 'image' should match the name in your form data

        if ( $uploadedFile === null ) {
            return [ 'error' => 'No file uploaded.' ];
        }

        // Generate unique file name to prevent conflicts
        $fileName = 'image_' . time() . '.' . $uploadedFile->getExtension();

        // Path where the image will be saved
        $uploadPath = Yii::getAlias( '@backend/web/uploads/' ) . $fileName;

        // Move the uploaded file to the specified path
        if ( !$uploadedFile->saveAs( $uploadPath ) ) {
            return [ 'error' => 'Failed to upload file.' ];
        }
        $blog = Yii::$app->db->createCommand()->update( 'blogs', [
            'blog_title' => $blog_title,
            'blog_description' => $blog_description,
            'status'=>$status,
            'blog_image'=>$fileName,
            'updated_by'=>1
        ], [ 'blog_id' => $id ] )->execute();

        if ( $blog>0 ) {
            return json_encode( [ 'response'=>[ 'result'=>'success', 'status'=>'200', 'messages'=>'Record Updated Successfully' ] ] );
        } else {
            return json_encode( [ 'response'=>[ 'result'=>'success', 'status'=>'200', 'messages'=>'No any field change' ] ] );
        }
    }

    public function actionDelete() {
        $id = Yii::$app->request->post( 'blog_id' );
        $blog = Yii::$app->db->createCommand()->delete( 'blogs', [ 'blog_id' => $id ] )->execute();
        if ( $blog>0 ) {
            return json_encode( [ 'response'=>[ 'result'=>'success', 'status'=>'200', 'messages'=>'Record Delete Successfully' ] ] );
        }
    }

}