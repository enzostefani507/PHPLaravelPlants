<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plantas;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:8',
        ]);

        $user = User::create([
            'name'=>$validatedData['name'],
            'email'=>$validatedData['email'],
            'password'=>Hash::make($validatedData['password']),
        ]);

        if (strlen($request->image)>5){
            $user->image()->create(['url'=>$request->input('image')]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Baerer',
        ],201);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email','password')))
        {
            return response()->json([
                'message' => 'Datos incorrectos'
            ],401);
        }

        $user = User::where('email',$request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Baerer'
        ]);
    }

    public function infouser(Request $request)
    {
        return $request->user();
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name'=>'required|string|max:255',
            'password'=>'required|string|min:8',
        ]);
        $user = $request->user();
        $user->name = $validatedData['name'];
        $user->password = Hash::make($validatedData['password']);
        $user->save();
        return response()->noContent();
    }

    public function borrarImagen(Request $request)
    {
        $user = $request->user();
        if ($user->image != null){
            $user->image()->delete(['url'=>$request->input('image')]);
            return response()->noContent();
        }else{
            return response()->isNotModified();
        }
    }

    public function cargarImagen(Request $request)
    {
        $user = $request->user();
        if (strlen($request->image)>5){
            $user->image()->create(['url'=>$request->input('image')]);
            return response()->json($user->image);
        }else{
            return response()->isNotModified();
        }
    }

    public function updateImagen(Request $request)
    {
        $user = $request->user();
        if ($user->image != null){
            $user->image()->delete(['url'=>$request->input('image')]);
            $user->image()->create(['url'=>$request->input('image')]);
            return response()->json($user->image);
        }else{
            if (strlen($request->image)>5) {
                $user->image()->create(['url' => $request->input('image')]);
                return response()->json($user->image);
            }else {
                return response()->isNotModified();
            }
        }
    }

    public function verPlantas(Request $request)
    {
        $plantas = $request->user()->plantas;
        return response()->json($plantas);
    }
}
