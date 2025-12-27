
        <div class="max-w-[1400px] mx-auto mt-24  px-4">
            <div class="flex flex-col md:flex-row items-start justify-between gap-10 py-10 border-b border-slate-500/30 text-slate-500">
                <div>
                    <a href="/" class="text-4xl font-semibold text-slate-700">
                        <img src="assets/img/ALDYN.png" alt="" class="w-48">
                    </a>
                    <p class="max-w-[410px] mt-6 text-sm">Welcome to gocart, your ultimate destination for the latest and smartest gadgets. From smartphones and smartwatches to essential accessories, we bring you the best in innovation — all in one place.</p>
                    <div class="flex items-center gap-3 mt-5">

                        <a href="" class="flex items-center justify-center w-10 h-10 bg-gray-200 hover:scale-105 hover:border border-slate-300 transition rounded-full">
                            <i class="ri-facebook-line text-xl"></i>
                        </a>

                        <a href="" class="flex items-center justify-center w-10 h-10 bg-gray-200 hover:scale-105 hover:border border-slate-300 transition rounded-full">
                            <i class="ri-instagram-line"></i>
                        </a>

                        <a href="" class="flex items-center justify-center w-10 h-10 bg-gray-200 hover:scale-105 hover:border border-slate-300 transition rounded-full">
                            <i class="ri-twitter-x-line"></i>
                        </a>

                        <a href="" class="flex items-center justify-center w-10 h-10 bg-gray-200 hover:scale-105 hover:border border-slate-300 transition rounded-full">
                            <i class="ri-linkedin-line"></i>
                        </a>
                    </div>
                </div>
                <div class="flex flex-wrap justify-between w-full md:w-[45%] gap-5 text-sm ">

                        <div>
                            <h3 class="font-medium text-slate-700 md:mb-5 mb-3">Products</h3>
                            <ul class="space-y-2.5">
                                    <li class="flex items-center gap-2">
                                        <a href="" class="hover:underline transition">Mac</a>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <a href="" class="hover:underline transition">iPhone</a>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <a href="" class="hover:underline transition">iPad</a>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <a href="" class="hover:underline transition">Watch</a>
                                    </li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-medium text-slate-700 md:mb-5 mb-3">WEBSITE</h3>
                            <ul class="space-y-2.5">
                                    <li class="flex items-center gap-2">
                                        <a href="" class="hover:underline transition">Home</a>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <a href="" class="hover:underline transition">Landing Page</a>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <a href="" class="hover:underline transition">Buy</a>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <a href="" class="hover:underline transition">Become Member</a>
                                    </li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-medium text-slate-700 md:mb-5 mb-3">CONTACT</h3>
                            <ul class="space-y-2.5">
                                    <li class="flex items-center gap-2">
                                        <i class="ri-phone-line"></i>
                                        <a href="" class="hover:underline transition">+62-873-398-388</a>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <i class="ri-mail-line"></i>
                                        <a href="" class="hover:underline transition">aldyne@gmail.com</a>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <i class="ri-map-pin-line"></i>
                                        <a href="" class="hover:underline transition">Jalan aldin 13 , Sanur</a>
                                    </li>
                            </ul>
                        </div>

                </div>
            </div>
            <p class="py-4 text-sm text-slate-500">
                Copyright 2025 © Aldynè All Right Reserved.
            </p>
        </div>











<?php if (isset($_SESSION['message'])): ?>
<div 
    id="toast"
    class="fixed bottom-6 right-6 z-50 flex items-start gap-3 w-[340px] p-4 
           bg-white/90 backdrop-blur-md 
           border border-slate-200 
           rounded-2xl shadow-xl
           animate-toast-in">

    <!-- Icon -->
    <div class="flex-shrink-0 mt-0.5">
        <i class="ri-checkbox-circle-line text-slate-800 text-xl"></i>
    </div>

    <!-- Message -->
    <div class="flex-1 mt-1">
        <p class="text-sm font-medium text-slate-800 leading-relaxed">
            <?= $_SESSION['message'] ?>
        </p>
    </div>

    <!-- Close -->
    <button 
        onclick="closeToast()"
        class="text-slate-400 hover:text-slate-600 transition">
        <i class="ri-close-line text-lg"></i>
    </button>
</div>

<style>
@keyframes toastIn {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.animate-toast-in {
    animation: toastIn 0.35s ease-out forwards;
}
</style>

<script>
function closeToast() {
    const toast = document.getElementById('toast');
    if (!toast) return;

    toast.style.opacity = '0';
    toast.style.transform = 'translateY(20px)';
    setTimeout(() => toast.remove(), 300);
}

setTimeout(closeToast, 4000);
</script>

<?php
unset($_SESSION['message']);
endif;
?>


<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/custom.js"></script>


</body>
</html>