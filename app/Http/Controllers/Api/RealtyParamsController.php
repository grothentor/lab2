<?php
/**
 * Created by PhpStorm.
 * User: grothentor
 * Date: 9/13/17
 * Time: 2:15 PM
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\RealtyType;
use Illuminate\Http\Request;

class RealtyParamsController extends Controller
{
    public function createAlternative($tableName, $entity, Request $request) {
        $table = generateTableClass($tableName);
        $entity = $table::query()->where('id', $entity)->firstOrFail();
        $this->validate($request, ['title' => "required|max:100|unique:$tableName,title"]);

        $alternative = $request->request->all();
        $alternative[$table::getAlternativeKey()] = $entity->id;

        $alternative = $table::query()->create($alternative);
        return [
            'success' => __('messages.added', ['entity' => __('alternative'), 'title' => $alternative->title]),
            'entity' => $alternative,
        ];
    }

    public function updateAlternative($tableName, $entity, $alternative, Request $request) {
        $table = generateTableClass($tableName);
        $table::query()->where('id', $entity)->firstOrFail();
        $alternative = $table::getAlternative($alternative);
        $this->validate($request, ['title' => "required|max:100|unique:$tableName,title"]);
        $alternative->update($request->request->all());
        return [
            'success' => __('messages.update', ['entity' => __('alternative'), 'title' => $alternative->title]),
            'entity' => $alternative->getOriginal(),
        ];
    }

    public function deleteAlternative($tableName, $entity, $alternative) {
        $table = generateTableClass($tableName);
        $table::query()->where('id', $entity)->firstOrFail();
        $alternative = $table::getAlternative($alternative);
        $message = __('messages.delete', ['entity' => __('alternative'), 'title' => $alternative->title]);
        $alternative->delete();
        return ['success' => $message];
    }

    public function updateEntity($tableName, $entity, Request $request) {
        $table = generateTableClass($tableName);
        $entity = $table::query()->where('id', $entity)->firstOrFail();

        $this->validate($request, ['title' => "max:100|unique:$tableName,title"]);
        $entity->update($request->request->all());
        return [
            'success' => __('messages.update', ['entity' => generateForeignKey($tableName, true), 'title' => $entity->title]),
            'entity' => $entity->getOriginal(),
        ];
    }

    public function deleteEntity($tableName, $entity) {
        $table = generateTableClass($tableName);
        $entity = $table::query()->where('id', $entity)->firstOrFail();
        $message = __('messages.delete', ['entity' => generateForeignKey($tableName, true), 'title' => $entity->title]);
        if ($tableName !== RealtyType::getTableName() || null !== $entity->parent_id) {
            /* update realties here

            $foreign = generateForeignKey($tableName);
            $newValue = $tableName === RealtyType::getTableName() ? $entity->parent_id : null;
            Realty::query()->where($foreign, $entity->id)->update([$foreign => $newValue]);
            */
            $entity->delete();
            return ['success' => $message];
        }

        return response()->json(['errors' => [__('messages.errors403')]], 403);
    }
}