<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        if (request('error')) {
            return response()->json(["message" => "error message"], 400);
        }
        return response()->json([
            "data" => [
                "returnType" => "string",
                "paginate" => false,
                "result" => "dfadflabdfa",
                "message" => "Malumotlar saqlandi"
            ]
        ], 200);
    }
    public function paginate()
    {
        $result = Author::paginate(10);
        return response()->json([
            "data" => [
                "returnType" => "collection",
                "paginate" => true,
                "result" => $result
            ]
        ], 200);
    }
}
