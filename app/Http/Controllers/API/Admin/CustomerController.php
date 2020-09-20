<?php
namespace App\Http\Controllers\API\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    public static function getAllUsers()
    {
        $user = User::all();
        return response()->json([
            'status' => 1,
            'message' => 'OK',
            'errors' => null,
            'users' => $user,
            'data' => [
                'message' => 'Retrieved successfully'
            ]
        ]);
    }

}
