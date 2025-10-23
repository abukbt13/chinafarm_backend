<?php


namespace App\Http\Controllers\API;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Validation\ValidationException;
    use App\Http\Controllers\Controller;
    use Spatie\Permission\Models\Role;

    class AuthController extends Controller
{
        public function register(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);

            // ✅ Hash the password before saving
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Create or fetch the role
            $farmerRole = Role::firstOrCreate(['name' => 'farmer']);
            $user->assignRole($farmerRole);

            // Create the token
            $token = $user->createToken('api-token')->plainTextToken;

            // Get role name
            $role = $user->getRoleNames()->first();

            // Return a consistent JSON response
            return response()->json([
                'success' => true,
                'message' => 'Registration Successful',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $role,
                ],
            ]);
        }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        $role = $user->getRoleNames()->first(); // returns e.g. "admin", "farmer", etc.

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $role,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }


}
