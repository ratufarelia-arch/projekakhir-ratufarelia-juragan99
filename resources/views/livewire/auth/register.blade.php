<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - Meat Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white flex items-center justify-center p-6">

   
    <div class="w-full max-w-md bg-white backdrop-blur-xl border border-red-900/40 rounded-2xl shadow-2xl p-10 space-y-8 relative overflow-hidden">

       
        <div class="relative z-10 flex justify-center mb-4">
            <img src="{{ asset('icons/anjaygurinjay.jpeg') }}" 
                 class="w-24 h-24 object-cover rounded-full border-4 shadow-xl" />
        </div>

      
        <div class="relative z-10 text-center space-y-2">
            <h1 class="text-3xl font-extrabold text-green-300">Create Your Account</h1>
            <p class="text-black text-sm">Join Meat Lovers Community 🍖🔥</p>
        </div>

       
        <form method="POST" action="{{ route('register') }}" class="relative z-10 space-y-5">
            @csrf

            <div>
                <label class="text-black text-sm">Name</label>
                <input type="text" name="name" required
                       class="w-full mt-1 p-3 rounded-lg  border border-green-700 text-black focus:outline-none focus:ring-2 focus:ring-green-400" />
            </div>

            <div>
                <label class="text-black text-sm">Email</label>
                <input type="email" name="email" required
                       class="w-full mt-1 p-3 rounded-lg  border border-green-700 text-black focus:outline-none focus:ring-2 focus:ring-green-400" />
            </div>

            <div>
                <label class="text-black text-sm">Password</label>
                <input type="password" name="password" required
                       class="w-full mt-1 p-3 rounded-lg  border border-green-700 text-black focus:outline-none focus:ring-2 focus:ring-green-400" />
            </div>

            <div>
                <label class="text-black text-sm">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                       class="w-full mt-1 p-3 rounded-lg border border-green-700 text-black focus:outline-none focus:ring-2 focus:ring-green-400" />
            </div>

            <button type="submit"
                    class="w-full py-3 rounded-lg bg-red-700 hover:bg-green-700 transition text-white font-semibold">
                Create Account
            </button>
        </form>

      
        <div class="relative z-10 text-center pt-4 text-gray-600 text-sm">
            <p>Already have an account? 
                <a class="text-green-500 hover:underline" href="{{ route('login') }}">
                    Log In
                </a>
            </p>
        </div>

    </div>

</body>
</html>
