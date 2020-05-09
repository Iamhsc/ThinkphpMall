<?php
/**
 * Created by PhpStorm.
 * User: imhsc
 * Date: 2020/5/6
 * Time: 21:04
 */

namespace app\common\model;


use think\facade\Request;
use think\Model;

class Upload extends Model
{
    /**
     * @param $file
     * @param $uid
     * @return array
     */
    public function upload($file, $uid)
    {
        $info = $file->validate(['ext' => 'docx,pdf'])
            ->rule('uniqid')
            ->move('../public/uploads/printFile/' . $uid);
        if ($info) {
            $path = '/uploads/printFile/'. $uid . '/' . $info->getSaveName();
            $fileInfo = [
                'uid' => $uid,
                'file_name' => $info->getInfo()['name'],
                'file_size' => $info->getInfo()['size'],
                'file_url' => $path
            ];
            $fn = $_SERVER['DOCUMENT_ROOT'].$path;
            copy($fn,$fn.'.zip');
            $res = $this->get_num_pages($fn);
            if (!$res)
                return ['code' => 0, 'msg' => $res];
            $annex = new File($fileInfo);
            if ($annex->save())
                return ['code' => 1, 'data' => ['annex_id' => $annex->id, 'pages_num'=>$res], 'msg' => '上传成功'];
        }
        // 上传失败获取错误信息
        return ['code' => 0, 'msg' => '上传失败,' . $file->getError()];

    }

    function get_num_pages($filename){
        $path=parse_url($filename);
        $str=explode('.',$path['path']);
        if ($str[1] == 'pdf'){
            return $this->count_pdf_pages($filename);
        }elseif ($str[1] == 'docx'){
            return $this->get_num_pages_docx($filename);
        }
        return false;
    }

    /**
     * 计算PDF文件页数
     * @param $pdfname
     * @return false|int
     */
    function count_pdf_pages($pdfname) {
        $pdftext = file_get_contents($pdfname);
        $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
        return $num;
    }

    /**
     * DOCX文件页数
     * @param $filename
     * @return bool|\SimpleXMLElement
     */
    function get_num_pages_docx($filename)
    {
        $zip = new \ZipArchive();
        if($zip->open($filename) === true)
        {
            if(($index = $zip->locateName('docProps/app.xml')) !== false)
            {
                $data = $zip->getFromIndex($index);
                $zip->close();
                $xml = new \SimpleXMLElement($data);
                return (int)$xml->Pages;
            }

            $zip->close();
        }

        return false;
    }
}
