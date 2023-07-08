<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserAuthController extends Controller
{

    public function show()
    {
        $users = DB::table('users')
            ->whereNotIn('id', [auth()->guard('api')->user()->id])
            ->get();
        return response()->json([
            "users" => $users,
            "status" => 200,
        ]);
    }

    public function user()
    {
        return auth()->guard('api')->user();
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            "message" => "User deleted successfully!",
            "status" => 200
        ]);
    }

    public function getByChar($user_name)
    {

        $user = User::where('name', 'like', '%' . $user_name . '%')->get();

        if ($user) {
            return response()->json([
                "users" => $user,
                "status" => 200,
            ]);
        } else {
            return response()->json(['error' => 'user not found'], 404);
        }
    }

    public function register(Request $request)
    {
        $data = $request->all();


        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $data['password'] = bcrypt($request->password);


        // upload image to storage
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $image_name = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('images/users/'), $image_name);
        //     $data['image'] = $image_name;
        // } else if ($request->image) {
        //     $base64_string = $request->image;
        //     $image = base64_decode($base64_string);

        //     $file_name = time() . '.' . 'png';
        //     $file_path = public_path('images/users/' . $file_name);
        //     file_put_contents($file_path, $image);
        //     $data['image'] = $file_name;
        // }

        // upload image to storage for Cloudinary
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->getRealPath();
            $uploadedImage = Cloudinary::upload($imagePath)->getSecurePath();
            $data['image'] = $uploadedImage;
        } else if ($request->image) {
            $imageBase64 = $request->image;
            $uploadedImage = Cloudinary::upload("data:image/png;base64," . $imageBase64)->getSecurePath();
            $data['image'] = $uploadedImage;
        }


        $user = User::create($data);

        $token = $user->createToken('API Token')->accessToken;

        return response(['user' => $user, 'token' => $token]);
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        if (!auth()->attempt($data)) {
            return response([
                'error_message' => 'Incorrect Details. Please try again'
            ], 400);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;

        return response(['user' => auth()->user(), 'token' => $token]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $image_name = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('images/users/'), $image_name);
        //     $data['image'] = $image_name;
        //     // remove old image
        //     $old_image = public_path('images/users/' . $user->image);
        //     if (file_exists($old_image)) {
        //         @unlink($old_image);
        //     }
        // } else if ($request->image) {
        //     $base64_string = $request->image;
        //     $image = base64_decode($base64_string);

        //     $file_name = time() . '.' . 'png';
        //     $file_path = public_path('images/users/' . $file_name);
        //     file_put_contents($file_path, $image);
        //     $data['image'] = $file_name;
        //     // remove old image
        //     $old_image = public_path('images/users/' . $user->image);
        //     if (file_exists($old_image)) {
        //         @unlink($old_image);
        //     }
        // }

        // upload image to storage for Cloudinary
        if ($request->hasFile('image')) {

            //check if old image exist
            $old_image = Cloudinary::getImage($user->image);
            if ($old_image->getPublicId() != null) {
                Cloudinary::destroy($old_image->getPublicId());
            }

            //set image to response json
            $imagePath = $request->file('image')->getRealPath();
            $uploadedImage = Cloudinary::upload($imagePath)->getSecurePath();
            $data['image'] = $uploadedImage;
        } else if ($request->image) {
            //check if old image exist
            $old_image = Cloudinary::getImage($user->image);
            if ($old_image->getPublicId() != null) {
                Cloudinary::destroy($old_image->getPublicId());
            }
            //set image to response json
            $imageBase64 = $request->image;
            $uploadedImage = Cloudinary::upload("data:image/png;base64," . $imageBase64)->getSecurePath();
            $data['image'] = $uploadedImage;
        }

        if ($user) {
            $user->update($data);
            return response(['user' => $user, 'message' => 'Success'], 200);
        } else {
            return response(['message' => 'User not found']);
        }
    }


    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response(['message' => 'Logged out successfully']);
    }
}
