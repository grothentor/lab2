<?php
/**
 * Created by PhpStorm.
 * User: grothentor
 * Date: 9/13/17
 * Time: 12:23 PM
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RealtyParamsService;
use Illuminate\Http\Request;

class RealtyParamsController extends Controller
{
    public function index(RealtyParamsService $realtyParamsService)
    {
        $tables = $realtyParamsService->getRealtyParams();

        return view('admin.realty-params.index', [
            'tables' => $tables,
            'yrlTypes' => $realtyParamsService
                ->getYrlRealtyTypes(true)
                ->toArray(),
        ]);
    }

    public function create() {
        return view('admin.realty-params.create', [
            'tables' => RealtyParamsService::getEditableTables(false,false, true),
        ]);
    }

    public function createRealtyType(RealtyParamsService $realtyParamsService) {
        return view('admin.realty-params.create-realty-type', [
            'realtyTypes' => $realtyParamsService->getRealtyTypes(),
            'yrlTypes' => $realtyParamsService->getYrlRealtyTypes(),
        ]);
    }

    public function store(Request $request, RealtyParamsService $realtyParamsService) {
        $tableName = $request->table;
        $this->validate($request, [
            'title' => "required|max:100|unique:$tableName,title",
            'uk_title' => "required|max:100",
        ]);

        $fields = $request->only('title', 'uk_title');
        $entity = $realtyParamsService->createRealtyParam($tableName, $fields);

        session()->flash('flash_message',
            __('messages.added', [
                    'entity' => generateForeignKey($tableName, true),
                    'title' => $entity->title
                ]            )
        );

        return back();
    }

    public function storeRealtyType(Request $request, RealtyParamsService $realtyParamsService) {
        $this->validate($request, [
            'title' => "required|max:100|unique:realty_types,title",
            'yrl_realty_type_id' => "required|exists:yrl_realty_types,id",
            'uk_title' => "required|max:100",
            'parent_id' => "required|max:100",
        ]);

        $fields = $request->only('title', 'uk_title', 'parent_id', 'yrl_realty_type_id');
        $entity = $realtyParamsService->createRealtyType($fields);

        session()->flash('flash_message',
            __('messages.added', [
                    'entity' => __('Realty type'),
                    'title' => $entity->title]
            )
        );

        return back();
    }
}