<?php

namespace App\Http\Controllers\Api\User;

use App\Key;
use App\User;
use Illuminate\Routing\Controller;
use App\Http\Requests\KeyRequest as Request;
use App\Contracts\KeyInterface as Repository;
use App\Http\Resources\KeyResource as Resource;

class KeyController extends Controller
{
    /**
     * @var \App\User
     */
    protected $user;

    /**
     * @var \App\Http\Requests\KeyRequest
     */
    protected $request;

    /**
     * @var \App\Contracts\KeyInterface
     */
    protected $reposotory;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Contracts\KeyInterface  $reposotory
     * @return void
     */
    public function __construct(Request $request, Repository $reposotory)
    {
        $this->user = User::find(1);

        $this->request = $request;

        $this->reposotory = $reposotory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\KeyResource
     */
    public function index()
    {
        $method = $this->request->search
            ? 'searchKeysByUser'
            : 'getKeysByUser';

        $keys = $this->reposotory->$method($this->user);

        return Resource::collection($keys);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \App\Http\Resources\KeyResource
     */
    public function store()
    {
        $key = $this->reposotory->storeKeyByUser($this->user);

        return new Resource($key);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Key  $key
     * @return \App\Http\Resources\KeyResource
     */
    public function show(Key $key)
    {
        $keys = $this->reposotory->getKeyByUser($this->user, $key->id);

        return new Resource($keys);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Key  $key
     * @return \App\Http\Resources\KeyResource
     */
    public function update(Key $key)
    {
        $key = $this->reposotory->updateKey($key);

        return new Resource($key);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Key  $key
     * @return \Illuminate\Http\Response
     */
    public function destroy(Key $key)
    {
        $this->reposotory->destroyKey($key);

        return response(null, 204);
    }
}