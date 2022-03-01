<?php

namespace Modules\Admin\Http\Controllers;


use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\CommonPageRequest;
use Modules\Admin\Http\Requests\DelIdRequest;
use Modules\Admin\Http\Requests\KeywordHintAddRequest;
use Modules\Admin\Services\banner\BannerService;
use Modules\Admin\Services\keyword\KeywordService;


class KeywordController extends BaseAdminController
{

    /**
     * @Name: 搜尋歷史視圖
     * @Route: keyword_history
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:23
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function history()
    {
        $title = __('admin::controller.keyword_history');

        return view('admin::keyword.history_list',compact('title'));
    }

    /**
     * @Name: 搜尋歷史列表
     * @Route: keyword_history_list
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:27
     * @param CommonPageRequest $request
     * @param KeywordService $service
     * @return \Modules\Admin\Services\keyword\JSON
     */
    public function historyList(CommonPageRequest $request,KeywordService $service)
    {

        return $service->historyList($request->only([
            'page',
            'limit',
            'keyword',
            'num',
            'start_time',
            'end_time',
        ]));
    }


    /**
     * @Name: 搜尋提示詞視圖
     * @Route: keyword_hint
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:28
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function hint()
    {
        $title = __('admin::controller.keyword_hint');

        return view('admin::keyword.hint_list',compact('title'));
    }

    /**
     * @Name: 搜尋提示詞列表
     * @Route: keyword_hint_list
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:31
     * @param CommonPageRequest $request
     * @param KeywordService $service
     * @return \Modules\Admin\Services\keyword\JSON
     */
    public function hintList(CommonPageRequest $request,KeywordService $service)
    {

        return $service->hintList($request->only([
            'page',
            'limit',
            'keyword',
            'weight',
        ]));
    }


    /**
     * @Name: 搜尋提示詞編輯視圖
     * @Route: keyword_hint_edit
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:32
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function hintEdit()
    {
        $title = __('admin::controller.keyword_hint');

        return view('admin::keyword.hint_edit',compact('title'));
    }


    /**
     * @Name: 搜尋提示詞添加
     * @Route: keyword_hint_add
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:32
     * @param KeywordHintAddRequest $request
     * @param KeywordService $service
     * @return \Modules\Admin\Services\keyword\JSON
     */
    public function hintAdd(KeywordHintAddRequest $request,KeywordService $service)
    {

        return $service->hintAdd($request->only([
            'keyword', 'weight']));
    }


    /**
     * @Name: 搜尋提示詞更新
     * @Route: keyword_hint_update
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:33
     * @param Request $request
     * @param KeywordService $service
     * @return \Modules\Admin\Services\keyword\JSON
     */
    public function hintUpdate(Request $request,KeywordService $service)
    {

        return $service->hintUpdate($request->get('id'), $request->only([
            'weight'
        ]));
    }


    /**
     * @Name: 搜尋提示詞刪除
     * @Route: keyword_hint_del
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:34
     * @param DelIdRequest $request
     * @param KeywordService $service
     * @return \Modules\Common\Services\JSON
     */
    public function hintDel(DelIdRequest $request,KeywordService $service)
    {
        return $service->hintDel($request->get('ids'));
    }

    /**
     * @Name: 網站設置視圖
     * @Route: website_index
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:47
     * @param $type
     * @param WebsiteService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function hot(KeywordService $service)
    {


        $title = __('admin::controller.keyword_hot');
        $model =  $service->hot();


        return view('admin::keyword.hot',compact('title','model'));
    }

    /**
     * @Name: 搜尋提示詞更新
     * @Route: keyword_hint_update
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:33
     * @param Request $request
     * @param KeywordService $service
     * @return \Modules\Admin\Services\keyword\JSON
     */
    public function hotUpdate(Request $request,KeywordService $service)
    {
        return $service->hotUpdate($request->get('id'), $request->only([
            'keyword'
        ]));
    }




}
