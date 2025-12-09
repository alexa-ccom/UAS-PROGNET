<?php 

session_start();

if (isset($_SESSION['auth'])) {
    $_SESSION['message'] = "You are already Logged In";
    header('Location: index.php');
    exit();
}

include("includes/header.php") 

?>

<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">


  <form class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm space-y-4" action="proses/proses-auth-register.php" method="POST">
    <h2 class="text-2xl font-bold text-gray-800 text-center">Register</h2>

    <!-- Name -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
      <input 
        type="text" 
        class="w-full px-3 py-2 rounded-md border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none"
        placeholder="Enter your name"
        required
        name="name"
      >
    </div>

    <!-- Phone Number -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
      <input 
        type="number" 
        class="w-full px-3 py-2 rounded-md border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none"
        placeholder="Enter your phone number"
        required
        name="phone"
      >
    </div>

    <!-- Email -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
      <input 
        type="email" 
        class="w-full px-3 py-2 rounded-md border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none"
        placeholder="Enter your email"
        required
        name="email"
      >
    </div>

    <!-- Password -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
      <input 
        type="password" 
        class="w-full px-3 py-2 rounded-md border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none"
        placeholder="Enter your password"
        required
        name="password"
      >
    </div>

    <!-- Confirm -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
      <input 
        type="password" 
        class="w-full px-3 py-2 rounded-md border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none"
        placeholder="Confirm your password"
        required
        name="cpassword"
      >
    </div>

    <!-- Submit -->
    <button 
      type="submit"
      class="w-full py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition"
      name="register_btn"
    >
      Register
    </button>
  </form>
</div>


<?php include("includes/footer.php") ?>


