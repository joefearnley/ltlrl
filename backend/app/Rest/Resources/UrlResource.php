<?php

namespace App\Rest\Resources;

use App\Rest\Resource as RestResource;

class UrlResource extends RestResource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    public static $model = \App\Models\Model::class;

    /**
     * The exposed fields that could be provided
     * @param RestRequest $request
     * @return array
     */
    public function fields(\Lomkit\Rest\Http\Requests\RestRequest $request): array
    {
        return [
            'id'
        ];
    }

    /**
     * The exposed relations that could be provided
     * @param RestRequest $request
     * @return array
     */
    public function relations(\Lomkit\Rest\Http\Requests\RestRequest $request): array
    {
        return [];
    }

    /**
     * The exposed scopes that could be provided
     * @param RestRequest $request
     * @return array
     */
    public function scopes(\Lomkit\Rest\Http\Requests\RestRequest $request): array
    {
        return [];
    }

    /**
     * The exposed limits that could be provided
     * @param RestRequest $request
     * @return array
     */
    public function limits(\Lomkit\Rest\Http\Requests\RestRequest $request): array
    {
        return [
            10,
            25,
            50
        ];
    }

    /**
     * The actions that should be linked
     * @param RestRequest $request
     * @return array
     */
    public function actions(RestRequest $request): array {
        return [];
    }

    /**
     * The instructions that should be linked
     * @param RestRequest $request
     * @return array
     */
    public function instructions(RestRequest $request): array {
        return [];
    }
}
