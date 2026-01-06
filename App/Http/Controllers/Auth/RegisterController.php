<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Helper: Xác định URL chuyển hướng dựa trên vai trò người dùng.
     * * @param \App\Models\User $user
     * @return string
     */
    protected function getRedirectUrlByRole($user)
    {
        // Kiểm tra vai trò của người dùng
        if ($user->role === 'admin') {
            // Chuyển hướng đến trang người dùng (ví dụ: trang chủ /home)
            // route('home') phải được định nghĩa trong web.php
           return route('admin.dashboard') ?? '/index';  
        } else {
            // Chuyển hướng đến trang quản trị (ví dụ: trang index/dashboard)
            // route('dashboard') phải được định nghĩa trong web.php
            return route('home') ?? '/'; 
        }
    }
    
    /**
     * Xử lý yêu cầu đăng ký từ Modal (AJAX).
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerModal(Request $request)
    {
        try {
            // 1. Xác thực dữ liệu
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'phone' => ['required', 'string', 'max:20', 'unique:users'], 
            ]);

            // 2. Tạo người dùng mới
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password, 
                'phone' => $request->phone,
                'role' => 'user', // Gán giá trị mặc định là 'user'
            ]);

            // 3. Đăng nhập người dùng
            Auth::login($user);

            // 4. LOGIC CHUYỂN HƯỚNG DỰA TRÊN VAI TRÒ
            $redirectTo = $this->getRedirectUrlByRole($user); 
            
            // 5. Kiểm tra xem request có phải AJAX không
            if ($request->expectsJson() || $request->ajax()) {
                // Trả về phản hồi JSON cho AJAX
                return response()->json([
                    'success' => true,
                    'message' => 'Đăng ký thành công! Chào mừng bạn.',
                    'user' => ['name' => $user->name, 'role' => $user->role],
                    'redirect' => $redirectTo,
                ], 201);
            } else {
                // Trả về redirect cho form submit truyền thống
                return redirect($redirectTo)->with('success', 'Đăng ký thành công! Chào mừng bạn.');
            }

        } catch (ValidationException $e) {
            // Log validation errors to help debugging (AJAX requests)
            Log::info('RegisterModal validation errors', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error("Registration Fatal Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau.',
            ], 500);
        }
    }
    
    /**
     * Xử lý yêu cầu đăng nhập qua Modal (AJAX).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginModal(Request $request)
    {
        try {
            // 1. Validation
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $credentials = $request->only('email', 'password');

            // 2. Xử lý Đăng nhập
            if (Auth::attempt($credentials, $request->has('remember'))) {
                // Đăng nhập thành công
                $request->session()->regenerate();
                $user = Auth::user();

                // 3. LOGIC CHUYỂN HƯỚNG DỰA TRÊN VAI TRÒ
                $redirectTo = $this->getRedirectUrlByRole($user); 

                // 4. Trả về response JSON thành công
                return response()->json([
                    'success' => true,
                    'message' => 'Đăng nhập thành công!',
                    'redirect' => $redirectTo // URL chuyển hướng đã xác định
                ], 200);
            }

            // Đăng nhập thất bại
            return response()->json([
                'success' => false,
                'message' => 'Email hoặc mật khẩu không chính xác.'
            ], 401);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi xác thực dữ liệu.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error("Login Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
            
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi hệ thống (500).',
            ], 500);
        }
    }

    /**
     * Xử lý yêu cầu đăng nhập qua Form (POST).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials, $request->has('remember'))) {
                $request->session()->regenerate();
                $user = Auth::user();
                $redirectTo = $this->getRedirectUrlByRole($user);
                return redirect()->to($redirectTo);
            }

            return back()->withErrors([
                'email' => 'Email hoặc mật khẩu không chính xác.',
            ])->onlyInput('email');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error("Login Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau.');
        }
    }

    /**
     * Xử lý yêu cầu đăng ký qua Form (POST).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'phone' => ['required', 'string', 'max:20', 'unique:users'],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
                'role' => 'user',
            ]);

            Auth::login($user);

            $redirectTo = $this->getRedirectUrlByRole($user);
            return redirect()->to($redirectTo);

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error("Registration Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau.');
        }
    }
}