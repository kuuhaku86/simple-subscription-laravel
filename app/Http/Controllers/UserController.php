<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserWebsite;
use App\Models\Website;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email|unique:users'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->getMessageBag(),
            ], 400);
        }

        $user = User::create($input);

        return response()->json([
            "success" => true,
            "message" => "User created successfully.",
            "data" => $user
        ]);
    }

    public function subscribe(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required|exists:users,id',
            'website_id' => 'required|exists:websites,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->getMessageBag(),
            ], 400);
        }


        try {
            UserWebsite::create($input);

            return response()->json([
                "success" => true,
                "message" => "User subscribed successfully.",
            ]);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $websites = Website::join('user_website', 'websites.id', '=', 'user_website.website_id')
            ->where('user_website.user_id', $id)
            ->select('websites.*')
            ->get();

        return response()->json([
            "success" => true,
            "message" => "User's website subscription.",
            "data" => $websites
        ]);
    }
}
