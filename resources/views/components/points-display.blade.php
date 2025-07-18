@auth
<div class="fixed bottom-4 right-4 z-50">
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
        <div class="flex items-center space-x-2">
            <div class="bg-white/20 rounded-full p-1">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <div>
                <div class="text-sm font-semibold">{{ number_format(auth()->user()->points) }}</div>
                <div class="text-xs text-white/80">Points</div>
            </div>
        </div>
    </div>
    
    <!-- Tooltip -->
    <div class="absolute bottom-full right-0 mb-2 hidden group-hover:block">
        <div class="bg-gray-900 text-white text-xs rounded py-1 px-2 whitespace-nowrap">
            Click to view leaderboard
        </div>
    </div>
</div>

<style>
@keyframes pointsEarned {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

.points-earned {
    animation: pointsEarned 0.6s ease-in-out;
}
</style>

<script>
// Make points display clickable to go to leaderboard
document.addEventListener('DOMContentLoaded', function() {
    const pointsDisplay = document.querySelector('.fixed.bottom-4.right-4');
    if (pointsDisplay) {
        pointsDisplay.style.cursor = 'pointer';
        pointsDisplay.addEventListener('click', function() {
            window.location.href = '{{ route("leaderboard.index") }}';
        });
    }
});
</script>
@endauth