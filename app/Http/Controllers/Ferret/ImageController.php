<?php

namespace App\Http\Controllers\Ferret;

use App\Models\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ResponseController as Response;

class ImageController extends Controller
{
    /**
     * 图像控制器
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 新增图像.
     * post
     * @author daidh
     * @access public
     * @param  $request        Request
     * @version V1
     * @return 200         添加成功
     *                     序列号
     *         210         添加失败
     *         520         服务器端处理失败:无法添加图像
     *         211         添加图像失败：缺少必要参数
     */
    public function add(Request $request)
    {
        try {

            //TODO
            // 验证请求...

            // 校验图像
            // 不可重复添加，一张图片只能归属一个相册
            // 如果存在直接返回
            // 如果不存在，将上传信息写入数据库
            // 理论上存在MD5重复的极端异常情况
            // @author daidh

            if (Image::where('md5_value', $request->md5_value)->count()) {
                return Response::response(510,'图像已经存在');
            } else {
                $image = new Image;
                $image->album_id = $request->album_id;
                $image->md5_value = $request->md5_value;
                $image->shot_date = $request->shot_date;
                $image->orign_fname = $request->orign_fname;
                $image->orign_fsize = $request->orign_fsize;
                $image->display = true;
                $image->exif = $request->exif;
                $image->save();
                return Response::response(200,'添加图像成功');
            }
        } catch (Exception $e) {
            return Response::response(520, '服务器端处理失败:无法添加图像' . $e->getMessage());
        }
    }

    /**
     * 获取图像信息.
     * post
     * @author daidh
     * @access public
     * @param  $image_id        integer
     * @version V1
     * @return 200         添加成功
     *                     序列号
     *         210         添加失败
     *         520         服务器端处理失败:无法添加图像
     *         211         序列号生成失败：缺少必要参数
     */
    public function show($image_id)
    {
        try {

            //TODO
            // 验证请求...

            $image = Image::findOrFail($image_id);

            return Response::response(200,'获取图像成功',json_encode($image));

        } catch (Exception $e) {
            return Response::response(520, '服务器端处理失败:无法添加图像' . $e->getMessage());
        }
    }


    /**
     * 分页获取图像s.
     * get
     * @author daidh
     * @access public
     * @param  $album_id        integer
     * @version V1
     * @return 200         添加成功
     *                     序列号
     *         210         添加失败
     *         520         服务器端处理失败:分页获取图像
     *         211         分页获取失败：缺少必要参数
     */
    public function getImages($album_id)
    {
        try {

            //TODO
            // 验证请求...

            //使用Eloquent 模型分页功能
            //每页默认16项
            $images = Image::where('album_id',$album_id)->orderBy('id', 'desc')->paginate(36);

            return Response::response(200,'分页获取成功', $images);

        } catch (Exception $e) {
            return Response::response(520, '服务器端处理失败:分页获取图像s' . $e->getMessage());
        }
    }
}