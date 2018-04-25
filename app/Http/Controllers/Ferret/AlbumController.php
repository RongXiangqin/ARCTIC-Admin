<?php

namespace App\Http\Controllers\Ferret;

use App\Models\Album;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ResponseController as Response;
use App\Models\Image;

class AlbumController extends Controller
{
    /**
     * 相册控制器
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 新增相册.
     * post
     * @access public
     * @param  $request        Request
     * @version V1
     * @return 200         添加相册成功
     *                     序列号
     *         210         添加失败
     *         520         服务器端处理失败:无法添加相册
     *         211         添加相册失败：缺少必要参数
     */
    public function add(Request $request)
    {
        try {

            //TODO
            // 验证请求...

            // 校验相册
            // 不可重复添加，一个相册下不允许出现同名相册
            // 如果存在直接返回
            // 如果不存在，将POST信息写入数据库
            // @author daidh

            if (Album::where('parent_id', $request->parent_id)->where('name',$request->name)->count()) {
                return Response::response(510,'相册已经存在');
            } else {
                $album = new Album;
                $album->project_id = $request->project_code;
                $album->name = $request->name;
                $album->parent_id = $request->parent_id;
                $album->description = $request->description;
                $album->project_state = $request->project_state;
                $album->save();
                return Response::response(200, '添加相册成功', json_encode($album));
            }

        } catch (Exception $e) {
            return Response::response(520, '服务器端处理失败:无法添加相册' . $e->getMessage());
        }
    }


    /**
     * 获取单个相册信息.
     * get
     * @access public
     * @param  $album_id        integer
     * @version V1
     * @return 200         获取相册成功
     *         210         获取相册失败
     *         520         服务器端处理失败:无法获取相册信息
     *         211         序列号生成失败：缺少必要参数
     */
    public function show($album_id)
    {
        try {

            //TODO
            // 验证请求...

            $album = Album::where('id',$album_id)->get();
            return Response::response(200,'获取相册成功',$album);

        } catch (Exception $e) {
            return Response::response(520, '服务器端处理失败:无法获取相册信息' . $e->getMessage());
        }
    }

	/**
     * 获取相册与图片的信息.
     * get
     * @access public
     * @param  $id        integer
     * @version V1
     * @author daidh
     * @return 200         获取成功
     *         210         获取失败
     *         520         服务器端处理失败:无法获取信息
     *         211         序列号生成失败：缺少必要参数
     */
    public function getAlbum($id=0)
    {
        try {
            if ($id == 0) {
                $albums = Album::where('parent_id',null)->orderBy('id', 'desc')->get();
                return Response::response(200,'获取顶级相册成功', $albums);
            } else {
                $albums = Album::where('parent_id',$id)->orderBy('id', 'desc')->paginate(12);
                if (is_null($albums)){
                    $results['albums'] = [];
                    $results['images'] = [];
                } else {
                    $results['albums'] = $albums;
                    $images = Image::where('album_id',$id)->paginate(36);
                    if (($images->count()) == 0) {
                        $results['images'] = [];
                    } else {
                        $results['images'] = $images;
                    }
                }
                return Response::response(200,'获取相册成功', $results);
            }

        } catch (Exception $e) {
            return Response::response(520, '服务器端处理失败:无法获取信息' . $e->getMessage());
        }
    }
	
	/**
     * 获取相册信息.
     * get
     * @access public
     * @param  $parent_id        integer
     * @version V1
     * @author weiwl
     * @return 200         获取相册成功
     *         210         获取相册失败
     *         520         服务器端处理失败:无法获取相册信息
     *         211         序列号生成失败：缺少必要参数
     */
	public function getAlbumName($parent_id = 0) 
	{
		try {
			if($parent_id == 0) {
				$albums = Album::where('parent_id',null)->orderBy('id', 'desc')->get();
			} else {
				$albums = Album::where('parent_id',$parent_id)->orderBy('id', 'desc')->get();
			}
			$results['albums'] = $albums;
			return Response::response(200,'获取相册成功', $results);
		} catch (Exception $e) {
            return Response::response(520, '服务器端处理失败:无法获取相册信息' . $e->getMessage());
        }
	}

    /**
     * 分页获取相册s.
     * get
     * @author daidh
     * @access public
     * @param  $state        integer
     * @version V1
     * @author daidh
     * @return 200         添加成功
     *                     序列号
     *         210         添加失败
     *         520         服务器端处理失败:分页获取相册
     *         211         分页获取失败：缺少必要参数
     */
    public function getAlbums($state)
    {
        try {
            // 验证请求参数...
            if (in_array($state,[1,2,20,30,40])) {
                //使用Eloquent 模型分页功能
                //每页默认12项
                $albums = Album::where([
                    ['parent_id', null],
                    ['project_state', $state]])
                    ->where('display',true)
                    ->orderBy('id', 'desc')
                    ->paginate(12);
                return Response::response(200,'分页获取相册成功', $albums);
            } else {
                return Response::response(211, '分页获取失败：缺少必要参数');
            }
        } catch (Exception $e) {
            return Response::response(520, '服务器端处理失败:无法分页获取相册' . $e->getMessage());
        }
    }
}