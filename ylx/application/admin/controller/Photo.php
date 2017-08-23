<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Photo extends ApiCommon
{
    public function  index()
    {
        echo "Hello photo index";
    }

     public function upload()
    {	
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        $file = request()->file('file');
        if (!$file) {
        	return resultArray(['error' => '请上传文件']);
        }
        
        $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . DS . 'uploads');
        if ($info) {

        $photoModel = model('photo');
        ////$param = $this->param;

        $param = array( );
        $userInfo = $cache['userInfo'];
        //$userInfo['id'] = 1;
        $param['userid'] = $userInfo['id'];
        $param['username'] = $userInfo['id'];
        $param['status'] = 1;
        $param['photourl'] = 'uploads'. DS .$info->getSaveName();


       file_put_contents("wmlog.txt", $param['username'].PHP_EOL, FILE_APPEND);
              file_put_contents("wmlog.txt", $param['photourl'].PHP_EOL, FILE_APPEND);
        $data = $photoModel->createData($param);
       // if (!$data) {
            //return resultArray(['error' => $photoModel->getError()]);
        //} 
        //return resultArray(['data' => '添加成功']);

            return resultArray(['data' =>  'uploads'. DS .$info->getSaveName()]);
        }
        
        return resultArray(['error' =>  $file->getError()]);
    }


    public function download()
    {	
        $photoModel = model('photo');
        $userInfo = $cache['userInfo'];
        //$userInfo['id'] = 1;
        $userid = $userInfo['id'];
        $data = $photoModel->getPhotos($userid);
        if (!$data) {
            return resultArray(['error' => $photoModel->getError()]);
        } 
        return resultArray(['data' => $data]);
    }

    public function read()
    {   
        $photoModel = model('photo');
        $param = $this->param;
        $data = $photoModel->getDataById($param['id']);
        if (!$data) {
            return resultArray(['error' => $photoModel->getError()]);
        } 
        return resultArray(['data' => $data]);
    }

    public function save()
    {
        $photoModel = model('photo');
        $param = $this->param;
        $data = $photoModel->createData($param);
        if (!$data) {
            return resultArray(['error' => $photoModel->getError()]);
        } 
        return resultArray(['data' => '添加成功']);
    }

    public function update()
    {
        $photoModel = model('photo');
        $param = $this->param;
        $data = $photoModel->updateDataById($param, $param['id']);
        if (!$data) {
            return resultArray(['error' => $photoModel->getError()]);
        } 
        return resultArray(['data' => '编辑成功']);
    }

    public function delete()
    {
        $photoModel = model('photo');
        $param = $this->param;
        $data = $photoModel->delDataById($param['id'], true);       
        if (!$data) {
            return resultArray(['error' => $photoModel->getError()]);
        } 
        return resultArray(['data' => '删除成功']);    
    }

    public function deletes()
    {
        $photoModel = model('photo');
        $param = $this->param;
        $data = $photoModel->delDatas($param['ids'], true);  
        if (!$data) {
            return resultArray(['error' => $photoModel->getError()]);
        } 
        return resultArray(['data' => '删除成功']); 
    }

    public function enables()
    {
        $photoModel = model('photo');
        $param = $this->param;
        $data = $photoModel->enableDatas($param['ids'], $param['status'], true);  
        if (!$data) {
            return resultArray(['error' => $photoModel->getError()]);
        } 
        return resultArray(['data' => '操作成功']);         
    }
}
 