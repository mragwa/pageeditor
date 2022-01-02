<?php

namespace AnywhereMedia\PageEditor\Http\Controllers;

use AnywhereMedia\PageEditor\Page;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use PHPageBuilder\Theme;
use PHPageBuilder\Modules\GrapesJS\PageRenderer;
use PHPageBuilder\Repositories\PageRepository;
use DB;
use Session;
use Auth;

class PageBuilderController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function uri($slug = 'home')
    {
        $page = Page::where(['slug' => $slug, 'status' => 'ACTIVE'])->firstOrFail();

        if(isset($page)){
            $theme = new Theme(config('pagebuilder.theme'), config('pagebuilder.theme.active_theme'));
            $pageId = $page->id;
            $page = (new PageRepository)->findWithId($pageId);
            $pageRenderer = new PageRenderer($theme, $page);
            $html = $pageRenderer->render();
            return $html;
        } else {
            return 'Not Found.';
        }
    }

    public function build()
    {

        if(!Auth::user()){
            return redirect('/admin');
        }

        if(Auth::user()->hasPermission('edit_pages')){
            $route = $_GET['route'] ?? null;
            $action = $_GET['action'] ?? null;

            $pageId = $_GET['page'];

            $myVoyagerPage = DB::table('pages')->where('id', $pageId)->first();

            if(isset($myVoyagerPage)){

                DB::table('pagebuilder__pages')->updateOrInsert(['id'=>$myVoyagerPage->id], ['name'=>$myVoyagerPage->title, 'layout'=>'master']);

                $pageId = is_numeric($pageId) ? $pageId : ($_GET['page'] ?? null);
                $pageRepository = new \PHPageBuilder\Repositories\PageRepository;
                $page = $pageRepository->findWithId($pageId);

                $phpPageBuilder = app()->make('phpPageBuilder');
                $pageBuilder = $phpPageBuilder->getPageBuilder();

                $customScripts = view("pageeditor::pagebuilder.scripts")->render();
                $pageBuilder->customScripts('head', $customScripts);

                $pageBuilder->handleRequest($route, $action, $page);
            } else {
                return 'No page found.';
            }
        } else {
            return redirect('/admin');
        }
    }
}
